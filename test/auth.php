<?php
$servername = "localhost";
$username = "root";
$password = "LogLn1042949719!";
$database = "fruitVendor";

function guidv4()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function get_dump($object){
	ob_start();
	var_dump($object);
	return ob_get_clean();
};

try {
		error_log("Request " . get_dump($_REQUEST), 0);
		

	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$json = file_get_contents('php://input'); 
		$obj = json_decode($json);
		$data = [];
		$conn = new mysqli($servername, $username, $password, $database);
		if ($conn->connect_error) {
			error_log("Connection Failed: " . get_dump($conn), 0);
			return;
		} 
		
		$guid = guidv4();

		if($conn->query("INSERT INTO `fruitvendor`.`session`(`user_id`,`token`,`token_expiry_date`,`created_date`,`updated_date`,`created_by`,`updated_by`)select auth.id,'".$guid."',DATE_ADD(current_timestamp, INTERVAL 10 Minute),current_timestamp,current_timestamp,auth.id,auth.id from `fruitvendor`.`auth` where auth.email = '".$obj->email."' and auth.password = '".$obj->password."'") === TRUE){
			$result = $conn->query("select count(1) as result from `fruitvendor`.`session` where token = '".$guid."' and token_expiry_date > current_timestamp() ");
			
			if($result){
				while ($row = $result->fetch_object()){
					$data[] = (array)$row;
				}
				$result->close();
				$conn->next_result();
			}
		}
		if($data[0]['result'] == 1){
			$data[0]['token'] = $guid;
			echo json_encode($data[0]);
		}else{
			echo json_encode($data[0]);
		}
		
		$conn->close();
	}
}catch(Exception $e) {
    error_log("Error : " . get_dump($e), 0);
	return;
}

?>
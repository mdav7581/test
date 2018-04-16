<?php
$servername = "localhost";
$username = "root";
$password = "LogLn1042949719!";
$database = "fruitVendor";

$user_id = null;

function validate($request){
	return true;
}

function get_dump($object){
	ob_start();
	var_dump($object);
	return ob_get_clean();
}

function user_data($obj){
	return json_decode('{
  "user": {
    "primary_contact": {
      "primary_phone": {}
    }
  },
  "address": [{}],
  "contact": [
    {
      "primary_phone": {}
    }
  ],
  "phone": [{}],
  "order": [
    {
      "billing_address": {},
      "delivery_address": {},
      "order_item": [
        {
          "product": {}
        }
      ]
    }
  ],
  "outgoing_invoice": [
    {
      "order": {
        "billing_address": {},
        "delivery_address": {},
        "order_item": [
          {
            "product": {}
          }
        ]
      },
      "outgoing_invoice_item": {
        "product": {}
      }
    }
  ]
}',true);
}

function auth($cookies){
	error_log("Cookies: " .get_dump($cookies));
	return 1;
}

try {
	
	$user_id = auth($_COOKIE);
	error_log("User: " .get_dump($user_id));
	if($user_id == null){
		error_log("No User: " . get_dump($_REQUEST), 0);
		return;
	}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$json = file_get_contents('php://input'); 
		$obj = json_decode($json);
		
		if(!validate($obj)){ error_log("Invalid Request: " . get_dump($json), 0); return;}
		$data = [];
		$conn = new mysqli($servername, $username, $password, $database);
		if ($conn->connect_error) {
			error_log("Connection Failed: " . get_dump($conn), 0);
			return;
		} 
		
		if($obj->type == "user_data"){
			$data = user_data($obj);
		}
		
		/*
		$result = $conn->query($obj->query);
		if($result){
			
			while ($row = $result->fetch_object()){
				
				$data[] = (array)$row;
			}

			$result->close();
			$conn->next_result();
			
		}
		*/
		echo json_encode($data);
		$conn->close();
	}
}catch(Exception $e) {
    error_log("Error : " . get_dump($e), 0);
	return;
}
?>
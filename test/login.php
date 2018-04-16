<?php

namespace Flow\JSONPath;

foreach (glob("includes/Flow/JSONPath/*.php") as $filename)
{
    require_once $filename;
}
foreach (glob("includes/Flow/JSONPath/Filters/*.php") as $filename)
{
    require_once $filename;
}

$login_form = '{"$id":"http://example.com/example.json","type":"object","definitions":{},"$schema":"http://json-schema.org/draft-07/schema#","properties":{"email":{"$id":"/properties/email","type":"string","title":"Email","default":"","examples":[""]},"password":{"$id":"/properties/password","type":"string","title":"Password","default":"","examples":[""]}}}';




?>
<html>
<head>
<script src="includes/JsonEditor/jsoneditor.js"></script>
</head>
<body>
<p id="data"></p>
 
 <div id="form_holder"></div>
 <button id='submit'>Submit</button>
<script>
      // Initialize the editor with a JSON schema
      var editor = new JSONEditor(document.getElementById('form_holder'),{
        schema: JSON.parse(`<?php 
		
		echo $login_form;
		
	  ?>`)});
      
      document.getElementById('submit').addEventListener('click',function() {
      
		
		var xhr = new XMLHttpRequest();
		var url = "auth.php";
		xhr.open("POST", url, true);
		xhr.setRequestHeader("Content-Type", "application/json");
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
				var response = JSON.parse(xhr.responseText);
				console.log(response);
			}
		};
		var data = JSON.stringify(editor.getValue());
		xhr.send(data);
		
      });
    </script>
</body>
</html>
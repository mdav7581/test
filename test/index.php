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

$form = '{"$id":"http://example.com/example.json","type":"object","definitions":{},"$schema":"http://json-schema.org/draft-07/schema#","properties":{"people":{"$id":"/properties/people","type":"array","items":{"$id":"/properties/people/items","type":"object","properties":{"name":{"$id":"/properties/people/items/properties/name","type":"string","default":"","examples":["Joe"]}}}}}}';

$data = ['people' => [['name' => 'Joe'], ['name' => 'Jane'], ['name' => 'John']]];
$result = (new JSONPath($data))->find('$.people[?(@.name = "Joe")]');

?> 

<html>
 <head>
  <title>PHP Test</title>
  <script src="includes/JsonEditor/jsoneditor.js"></script>
 </head>
 <body>
 <p>data: <?php echo json_encode ($data); ?> </p>
 <p>result: <?php echo json_encode ($result); ?> </p>
 <div id="form_holder"></div>
 <button id='submit'>Submit (console.log)</button>
 <script>
      // Initialize the editor with a JSON schema
      var editor = new JSONEditor(document.getElementById('form_holder'),{
        schema: JSON.parse(`<?php 
		
		echo $form;
		
	  ?>`)});
      
      document.getElementById('submit').addEventListener('click',function() {
        console.log(editor.getValue());
      });
    </script>
 
 </body>
</html>
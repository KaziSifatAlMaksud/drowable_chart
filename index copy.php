<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>


</body>
</html>
<!-- 
Handle multiple input connections
        $inputConnections = explode(",", $rows[$i]['input']);
        foreach ($inputConnections as $inputNode) {
            $dataToImport["req{$rows[$i]['id']}"]["inputs"]["input_1"]["connections"][] = array(
                "node" => trim($inputNode),
                "input" => "output_1"
            );
        }

         Handle multiple output connections
        $outputConnections = explode(",", $rows[$i]['output']);
        foreach ($outputConnections as $outputNode) {
            $dataToImport["req{$rows[$i]['id']}"]["outputs"]["output_1"]["connections"][] = array(
                "node" => trim($outputNode),
                "output" => "input_1"
            );
        }
    }
    
    $jsonData = json_encode($dataToImport); -->
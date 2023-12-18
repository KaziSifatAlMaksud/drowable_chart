<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php
include 'connect.php';

$sql = "SELECT * FROM requisition";
$sql1 = "SELECT * FROM po";
$sql2 = "SELECT * FROM chalan";

$result = $conn->query($sql);
$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$mergedData = array();

$dataToImport = array();
$datatopo = array();
$datatochalan = array();



if ($result2 && $result2->rowCount() > 0) {
    // Output data of each row
    $rows = $result2->fetchAll(PDO::FETCH_ASSOC);

   


    for ($i = 0; $i < count($rows); $i++) {
        // Create an associative array for each row
        $datatochalan["ch_{$rows[$i]['id']}"] = array(
            "id" => "ch_{$rows[$i]['id']}",
            "name" => "chalan",
            "data" => array(),
            "class" => "chalan",
            "html" => "
                <div>
                    <div class=\"title-box\"><i class=\"fas fa-at\"></i> {$rows[$i]['tittle']}</div>
                    <div class=\"box\">{$rows[$i]['body']}</div>
                </div>",
            "typenode" => false,
            "inputs" => array(
                "input_1" => array(  
                    "connections" => array(
                      array(
                          "node" => "{$rows[$i]['po_id']}",
                          "input"=> "output_1"     
                      )             
                  ),                
                )
            ),
            "outputs" => array(),  
            "pos_x" => $rows[$i]["pos_x"],
            "pos_y" => $rows[$i]["pos_y"]
        );
    }
    // $jsonData = json_encode($datatopo);


    // echo "<script>let datatopo = $jsonData; console.log(datatopo);</script>";

    // echo "<script>let frontendData = JSON.parse('$jsonData');</script>";
} else {
    echo "0 results";
}


//result 1:

if ($result1 && $result1->rowCount() > 0) {
    // Output data of each row
    $rows = $result1->fetchAll(PDO::FETCH_ASSOC);

   


    for ($i = 0; $i < count($rows); $i++) {
        // Create an associative array for each row
        $datatopo["po_{$rows[$i]['id']}"] = array(
            "id" => "po_{$rows[$i]['id']}",
            "name" => "po",
            "data" => array(),
            "class" => "po",
            "html" => "
                <div>
                    <div class=\"title-box\"><i class=\"fas fa-at\"></i> {$rows[$i]['tittle']}</div>
                    <div class=\"box\">{$rows[$i]['body']}</div>
                </div>",
            "typenode" => false,
            "inputs" => array(
                "input_1" => array(  
                    "connections" => array(
                      array(
                          "node" => "{$rows[$i]['requisition_id']}",
                          "input"=> "output_1"     
                      )             
                  ),
                
                )

            ),
               
            "outputs" => array(
              "output_1" => array(  
                "connections" => array(
                  array(
                      "node" => "{$rows[$i]['calan_id']}",
                      "output"=> "intput_1"     
                  )             
              ),
            
            )
        ),
            "pos_x" => $rows[$i]["pos_x"],
            "pos_y" => $rows[$i]["pos_y"]
        );
    }
    // $jsonData = json_encode($datatopo);


    // echo "<script>let datatopo = $jsonData; console.log(datatopo);</script>";

    // echo "<script>let frontendData = JSON.parse('$jsonData');</script>";
} else {
    echo "0 results";
}


//$result 
if ($result && $result->rowCount() > 0) {
    // Output data of each row
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

   

    for ($i = 0; $i < count($rows); $i++) {
        // Create an associative array for each row
        $dataToImport["req{$rows[$i]['id']}"] = array(
            "id" => "req{$rows[$i]['id']}",
            "name" => "requisition",
            "data" => array(),
            "class" => "requisition",
            "html" => "
                <div>
                    <div class=\"title-box\"><i class=\"fas fa-at\"></i> {$rows[$i]['tittle']}</div>
                    <div class=\"box\">{$rows[$i]['body']}</div>
                </div>",
            "typenode" => false,
            "inputs" => array(),
               
            "outputs" => array(
              "output_1" => array(  
                "connections" => array(
                  array(
                      "node" => "{$rows[$i]['output']}",
                      "input"=> "intput_1"     
                  )             
              ),
            
            )
        ),
            "pos_x" => $rows[$i]["pos_x"],
            "pos_y" => $rows[$i]["pos_y"]
        );
    }
    // $jsonData = json_encode($dataToImport);


    // echo "<script>let dataToImport = $jsonData; console.log(dataToImport);</script>";

    // echo "<script>let frontendData = JSON.parse('$jsonData');</script>";
} else {
    echo "0 results";
}


$mergedData = array_merge($dataToImport, $datatopo, $datatochalan);

$jsonData = json_encode($mergedData);
echo "<script>let mergedData = $jsonData; console.log(mergedData);</script>";


?>

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
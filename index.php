
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

//for chalan report 

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

} else {
    echo "0 results";
}


//$result 
if ($result && $result->rowCount() > 0) {
    // Initialize an empty array for the output
    $dataToImport = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $outputs = [];

        $original_array = json_decode($row['output_node']);
        
        if ($original_array) {
            $connections = [];
            foreach ($original_array as $item) {
                $connections[] = [
                    "node" => $item,
                    "output" => "input_1"
                ];
            }
            
            $outputs["output_1"] = [
                "connections" => $connections
            ];
        }
        

        $dataToImport["req{$row['id']}"] = [
            "id" => "req{$row['id']}",
            "name" => "requisition",
            "data" => [],
            "class" => "requisition",
            "html" => "
                <div>
                    <div class=\"title-box\"><i class=\"fas fa-at\"></i> {$row['tittle']}</div>
                    <div class=\"box\">{$row['body']}</div>
                </div>",
            "typenode" => false,
            "inputs" => [],
            "outputs" => $outputs,
            "pos_x" => $row["pos_x"],
            "pos_y" => $row["pos_y"]
        ];
    }
} else {
    echo "0 results";
}


$mergedData = array_merge($dataToImport, $datatopo, $datatochalan);

$jsonData = json_encode($mergedData);
echo "<script>let mergedData = $jsonData; console.log(mergedData);</script>";


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Drawflow | Simple Flow program libray</title>
  <meta name="description" content="Simple library for flow programming. Drawflow allows you to create data flows easily and quickly.">

</head>
<body>

  <link rel="stylesheet" type="text/css" href="access/beautiful.css" />
  <script src="access/drawflow.min.js"></script>
   <link rel="stylesheet" type="text/css" href="access/drawflow.css"> </link> 
  <link rel="stylesheet" href="access/swap.css"></link>
  <script src="access/handlebars.min.js"></script>
  <script src="access/sweetelert2@9.js"></script>
  <script src="access/micromodal.min.js"></script> 


  <div class="wrapper">
    <div class="col-right">
     
      <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">
    </div>
  </div>

  <script>
    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.reroute = true;

    const dataToImport = {
  "drawflow": {
    "Home": {
      "data": mergedData
    }
  }
};


    

    editor.start();
    editor.import(dataToImport);
  </script>
</body>
</html>

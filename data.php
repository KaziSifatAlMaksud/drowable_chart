<?php
include 'connect.php';

try {
    $sql = "SELECT * FROM dataset";
    $stmt = $conn->query($sql);

    $dataset = array();
    if ($stmt) {
        $dataset = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($dataset) == 0) {
            echo "0 results";
        }
    } else {
        throw new Exception("Error executing query");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


$recognitionIdToFilter = '101';
$poConnectionArrayInput = [];
$tempConnections1 = [];

if (!empty($dataset)) { 
    foreach ($dataset as $item) {
        if (isset($item["req"], $item["po"], $item["cha"]) && $item["req"] === $recognitionIdToFilter) {
            if (!in_array($item["po"], $tempConnections1)) {
                $tempConnections1[] = $item["po"];
               
            }
            $poConnectionArrayInput[] = array(
                "node" => $item["cha"],
                "input" => "output_1",
            );
        }
    } 
}

$connections1 = [];
foreach ($tempConnections1 as $po) {
    $connections1[] = array(
        "node" => $po,
        "output" => "input_1"
    );
}

$finalStructure = array(
    "inputs" => array(
        "input_1" => array(
            "connections" => $poConnectionArrayInput
        )
    )
);

$outputs1 = array(
    "id" => $recognitionIdToFilter,
    "name" => "requisition",
    "data" => "",
    "class" => "requisition",
    "html" => "",
    "typenode" => false,
    "input" => $finalStructure,
    "output_1" => array(
        "connections" => $connections1
    ),
    "pos_x" => 100,
    "pos_y" => 200
);





//Po o order





$tempConnections = array();
$data = []; 


if (!empty($dataset)) { 
    foreach ($dataset as $item) {
        if (isset($item["req"], $item["po"]) && $item["req"] === $recognitionIdToFilter) {
            $tempConnections[$item["po"]] = true; 
        }
    }
}


$connections = array();
foreach (array_keys($tempConnections) as $po) {
    if ($po !== null) {
        $connections[] = array(
            "node" => $po,
            "output" => "input_1"
        );
    }
}

$outputs = array();
if (!empty($connections)) {
    $outputs = array(
        "id" => $recognitionIdToFilter,
        "name" => "requisition",
        "data" => "",
        "class" => "requisition",
        "html" => "",
        "typenode" => false,
        "input" => array(),
        "outputs" => array("output_1" => array(
            "connections" => $connections
        )
        ),
        "pos_x" => 100,
        "pos_y" => 200
    );
}









// for chalan ....
$recognitionIdToFilter = '101'; 
  
$outputs3 = [];  

if (!empty($dataset)) {
    foreach ($dataset as $item) {
        if (isset($item["req"], $item["po"], $item["cha"]) && $item["req"] === $recognitionIdToFilter) {
            if (!empty($connections)) {
                
                $outputs3[$item["cha"]][] = array( 
                    "id" => $item["cha"],
                    "name" => "chalan",
                    "data" => "",
                    "class" => "chalan",
                    "html" => "",
                    "typenode" => false,
                    "input" => array(
                        "input_1" => array(  
                            "connections" => array(
                                array(
                                    "node" => $item['po'],
                                    "input" => "output_1"     
                                )             
                            ),                
                        )
                    ),
                    "outputs" => array(),
                    "pos_x" => 100,
                    "pos_y" => 200
                );
            }
        }
    }
echo '<pre>';
echo json_encode($outputs3, JSON_PRETTY_PRINT);
echo '</pre>';

}









$jsonData = json_encode($outputs);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta tags and other head elements -->
</head>
<body>
  <!-- HTML structure -->
  <div id="jsonDataDisplay"></div>
  <script>
    var jsonData = <?php echo $jsonData; ?>;
    console.log(jsonData);
    document.getElementById('jsonDataDisplay').textContent = JSON.stringify(jsonData, null, 2);
  </script>
</body>
</html>




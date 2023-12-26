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

// Initialize arrays to store connections for each PO
$poConnections = [];
$tempConnections1 = [];

// Assuming $dataset is defined somewhere before this code
if (!empty($dataset)) {
    foreach ($dataset as $item) {
        if (isset($item["req"], $item["po"], $item["cha"]) && $item["req"] === $recognitionIdToFilter) {
            $po = $item["po"];
            $cha = $item["cha"];

            // Initialize the array for this PO if it doesn't exist
            if (!array_key_exists($po, $poConnections)) {
                $poConnections[$po] = [];
                $tempConnections1[] = $po;
            }

            // Add the connection to the specific PO
            $poConnections[$po][] = array(
                "node" => $cha,
                "input" => "output_1",
            );
        }
    }
}

// Function to create output connections
function connection1($tempConnections1) {
    $connections1 = [];
    foreach ($tempConnections1 as $po) {
        $connections1[] = array(
            "node" => $po,
            "output" => "input_1"
        );
    }
    return $connections1;
}

$outputs1 = [];
foreach ($tempConnections1 as $po) {
    $outputs1[] = array(
        "id" => $po,
        "name" => "PO",
        "data" => "",
        "class" => "requisition",
        "html" => "",
        "typenode" => false,
        "input" => array(
            "inputs" => array(
                "input_1" => array(
                    "connections" => $poConnections[$po]
                )
            )
        ),
        "output_1" => array(
            "connections" => connection1($tempConnections1)
        ),
        "pos_x" => 100,
        "pos_y" => 200
    );
}

// Convert to JSON and output
$jsonOutput = json_encode($outputs1, JSON_PRETTY_PRINT);
echo $jsonOutput;










//Po o order

$tempConnections = array();
$data = []; 
$recognitionIdToFilter = '101'; 


if (!empty($dataset)) { 
    foreach ($dataset as $item) {
      
            $tempConnections[$item["po"]] = true; 
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
// echo '<pre>';
// echo json_encode($outputs3, JSON_PRETTY_PRINT);
// echo '</pre>';

}

// $jsonData = json_encode($outputs);
// $jsonData = json_encode($outputs1);
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




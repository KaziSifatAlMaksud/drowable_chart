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
$result = $conn->query($sql);

if ($result && $result->rowCount() > 0) {
    // Output data of each row
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    $dataToImport = array(); // Initialize an array to store data

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
            "inputs" => array(
                "input_1" => array(
                    "connections" => array(
                        array(
                            "node" => "{$rows[$i]['output']}",
                            "input" => "output_1"
                        )
                    )
                )
            ),
            "outputs" => array(),
            "pos_x" => $rows[$i]["pos_x"],
            "pos_y" => $rows[$i]["pos_y"]
        );
    }

    $jsonData = json_encode($dataToImport);


    echo "<script>let dataToImport = $jsonData; console.log(dataToImport);</script>";

    echo "<script>let frontendData = JSON.parse('$jsonData');</script>";
} else {
    echo "0 results";
}
?>

</body>
</html>

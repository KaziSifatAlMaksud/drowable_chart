
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

 <script src="access/drawflow.min.js"></script> 
 <link rel="stylesheet" type="text/css" href="access/drawflow.css" />
  <link rel="stylesheet" type="text/css" href="access/beautiful.css" />

  <div class="wrapper">
    <div class="col-right">
      <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">
    </div>
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


// const dataToImport =  {"drawflow":{"Home":{"data":{"2":{"id":2,"name":"slack","data":{},"class":"slack","html":"\n<div>\n <div class=\"title-box\"><i class=\"fab fa-slack\"></i> Slack chat message</div>\n          </div>\n          ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"7","input":"output_1"}]}},"outputs":{},"pos_x":1028,"pos_y":87},"3":{"id":3,"name":"telegram","data":{"channel":"channel_2"},"class":"telegram","html":"\n          <div>\n            <div class=\"title-box\"><i class=\"fab fa-telegram-plane\"></i> Telegram bot</div>\n            <div class=\"box\">\n              <p>Send to telegram</p>\n              <p>select channel</p>\n              <select df-channel>\n                <option value=\"channel_1\">Channel 1</option>\n                <option value=\"channel_2\">Channel 2</option>\n                <option value=\"channel_3\">Channel 3</option>\n                <option value=\"channel_4\">Channel 4</option>\n              </select>\n            </div>\n          </div>\n          ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"7","input":"output_1"}]}},"outputs":{},"pos_x":1032,"pos_y":184},"4":{"id":4,"name":"email","data":{},"class":"email","html":"\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-at\"></i> Send Email </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"5","input":"output_1"}]}},"outputs":{},"pos_x":1033,"pos_y":439},"5":{"id":5,"name":"template","data":{"template":"Write your template"},"class":"template","html":"\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-code\"></i> Template</div>\n              <div class=\"box\">\n                Ger Vars\n                <textarea df-template></textarea>\n                Output template with vars\n              </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"6","input":"output_1"}]}},"outputs":{"output_1":{"connections":[{"node":"4","output":"input_1"},{"node":"11","output":"input_1"}]}},"pos_x":607,"pos_y":304},"6":{"id":6,"name":"github","data":{"name":"https://github.com/jerosoler/Drawflow"},"class":"github","html":"\n          <div>\n            <div class=\"title-box\"><i class=\"fab fa-github \"></i> Github Stars</div>\n            <div class=\"box\">\n              <p>Enter repository url</p>\n            <input type=\"text\" df-name>\n            </div>\n          </div>\n          ","typenode": false, "inputs":{},"outputs":{"output_1":{"connections":[{"node":"5","output":"input_1"}]}},"pos_x":341,"pos_y":191},"7":{"id":7,"name":"facebook","data":{},"class":"facebook","html":"\n        <div>\n          <div class=\"title-box\"><i class=\"fab fa-facebook\"></i> Facebook Message</div>\n        </div>\n        ","typenode": false, "inputs":{},"outputs":{"output_1":{"connections":[{"node":"2","output":"input_1"},{"node":"3","output":"input_1"},{"node":"11","output":"input_1"}]}},"pos_x":347,"pos_y":87},"11":{"id":11,"name":"log","data":{},"class":"log","html":"\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-file-signature\"></i> Save log file </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"5","input":"output_1"},{"node":"7","input":"output_1"}]}},"outputs":{},"pos_x":1031,"pos_y":363}}},"Other":{"data":{"8":{"id":8,"name":"personalized","data":{},"class":"personalized","html":"\n            <div>\n              Personalized\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"12","input":"output_1"},{"node":"12","input":"output_2"},{"node":"12","input":"output_3"},{"node":"12","input":"output_4"}]}},"outputs":{"output_1":{"connections":[{"node":"9","output":"input_1"}]}},"pos_x":764,"pos_y":227},"9":{"id":9,"name":"dbclick","data":{"name":"Hello World!!"},"class":"dbclick","html":"\n            <div>\n            <div class=\"title-box\"><i class=\"fas fa-mouse\"></i> Db Click</div>\n              <div class=\"box dbclickbox\" ondblclick=\"showpopup(event)\">\n                Db Click here\n                <div class=\"modal\" style=\"display:none\">\n                  <div class=\"modal-content\">\n                    <span class=\"close\" onclick=\"closemodal(event)\">&times;</span>\n                    Change your variable {name} !\n                    <input type=\"text\" df-name>\n                  </div>\n\n                </div>\n              </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[{"node":"8","input":"output_1"}]}},"outputs":{"output_1":{"connections":[{"node":"12","output":"input_2"}]}},"pos_x":209,"pos_y":38},"12":{"id":12,"name":"multiple","data":{},"class":"multiple","html":"\n            <div>\n              <div class=\"box\">\n                Multiple!\n              </div>\n            </div>\n            ","typenode": false, "inputs":{"input_1":{"connections":[]},"input_2":{"connections":[{"node":"9","input":"output_1"}]},"input_3":{"connections":[]}},"outputs":{"output_1":{"connections":[{"node":"8","output":"input_1"}]},"output_2":{"connections":[{"node":"8","output":"input_1"}]},"output_3":{"connections":[{"node":"8","output":"input_1"}]},"output_4":{"connections":[{"node":"8","output":"input_1"}]}},"pos_x":179,"pos_y":272}}}}}
    
    

    editor.start();
    editor.import(dataToImport);
  </script>
</body>
</html>

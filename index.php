
<?php
include 'connect.php'; 

$sql = "SELECT * FROM requisition";
$result = $conn->query($sql);

if ($result && $result->rowCount() > 0) {
    // Output data of each row
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($rows); $i++) {
      echo "id: " . $rows[$i]["id"] . " - Name: " . $rows[$i]["name"] . " - Title: " . $rows[$i]["tittle"] . " - Body: " . $rows[$i]["body"] . " - Pos X: " . $rows[$i]["pos_x"] . " - Pos Y: " . $rows[$i]["pos_y"] . "<br>";
  }
  
} else {
    echo "0 results";
}

// $conn->close();

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
  <script src="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow@0.0.48/dist/drawflow.min.css">
  <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.min.js"></script>
  <link rel="stylesheet" type="text/css" href="beautiful.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>

  <div class="wrapper">
    <div class="col-right">
     
      <div id="drawflow" ondrop="drop(event)" ondragover="allowDrop(event)">
    </div>
  </div>

  <script>
    var id = document.getElementById("drawflow");
    const editor = new Drawflow(id);
    editor.reroute = true;
 

    
    const dataToImport = 
    {
  "drawflow": {
    "Home": {
      "data": {
        "PO_4": {
          "id": 'PO_4',
          "name": "email",
          "data": {},
          "class": "email",
          "html": "\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-at\"></i> Send Email </div>\n            </div>\n            ",
          "typenode": false,
          "inputs": {
            "input_1": {
              "connections": [
                {
                  "node": "po_5",
                  "input": "output_1"
                }
              ]
            }
          },
          "outputs": {},
          "pos_x": 1033,
          "pos_y": 439
        },

        "po_1": {
                    "id": "po_1",
                    "name": "po",
                    "data": [],
                    "class": "po",
                    "html": "\r\n                <div>\r\n                    <div class=\"title-box\"><i class=\"fas fa-at\"><\/i> parchece Oder 1<\/div>\r\n                    <div class=\"box\">asdfasfasdffdgfdgdfgsgsfdgsgsdfgsdfgsdfg<\/div>\r\n                <\/div>",
                    "typenode": false,
                    "inputs": {
                        "input_1": {
                            "connections": [{
                                "node": "req2",
                                "input": "output_1"
                            }]
                        }
                    },
                    "outputs": {
                        "output_1": {
                            "connections": [{
                                "node": "ch_1",
                                "output": "intput_1"
                            }]
                        }
                    },
                    "pos_x": "500",
                    "pos_y": "500"
                },
        

        "req2": {
                    "id": "req2",
                    "name": "requisition",
                    "data": [],
                    "class": "requisition",
                    "html": "\r\n                <div>\r\n                    <div class=\"title-box\"><i class=\"fas fa-at\"><\/i> Requgition_1<\/div>\r\n                    <div class=\"box\">this is our test<\/div>\r\n                <\/div>",
                    "typenode": false,
                    "inputs": [],
                    "outputs": {
                        "output_1": {
                            "connections": [{
                                "node": "po_1",
                                "input": "intput_1"
                            }]
                        }
                    },
                    "pos_x": "200",
                    "pos_y": "100"
                },

        "po_5": {
          "id": "po_5",
          "name": "template",
          "data": {
            "template": "Write your template"
          },
          "class": "template",
          "html": "\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-code\"></i> Template</div>\n              <div class=\"box\">\n                Ger Vars\n                <textarea df-template></textarea>\n                Output template with vars\n              </div>\n            </div>\n            ",
          "typenode": false,
          "inputs": {
            "input_1": {
              "connections": [
                {
                  "node": "re_6",
                  "input": "output_1"
                }
              ]
            }
          },
          "outputs": {
            "output_1": {
              "connections": [
                {
                  "node": "PO_4",
                  "output": "input_1"
                },
                {
                  "node": "ch_11",
                  "output": "input_1"
                }
              ]
            }
          },
          "pos_x": 607,
          "pos_y": 304
        },



        "re_6": {
          "id": "re_6",
          "name": "github",
          "data": {
            "name": "https://github.com/jerosoler/Drawflow"
          },
          "class": "github",
          "html": "\n          <div>\n            <div class=\"title-box\"><i class=\"fab fa-github \"></i> Github Stars</div>\n            <div class=\"box\">\n              <p>Enter repository url</p>\n            <input type=\"text\" df-name>\n            </div>\n          </div>\n          ",
          "typenode": false,
          "inputs": {},
          "outputs": {
            "output_1": {
              "connections": [
                {
                  "node": "po_5",
                  "output": "input_1"
                }
              ]
            }
          },
          "pos_x": 341,
          "pos_y": 191
        },



        "ch_11": {
          "id": "ch_11",
          "name": "log",
          "data": {},
          "class": "log",
          "html": "\n            <div>\n              <div class=\"title-box\"><i class=\"fas fa-file-signature\"></i> Save log file </div>\n            </div>\n            ",
          "typenode": false,
          "inputs": {
            "input_1": {
              "connections": [
                {
                  "node": "po_5",
                  "input": "output_1"
                }
              ]
            }
          },
          "outputs": {},
          "pos_x": 1031,
          "pos_y": 363
        }
      }
    }
  }
}

    editor.start();
    editor.import(dataToImport);
  </script>
</body>
</html>

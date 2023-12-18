<?php
session_start();
include 'connect.php'; // Make sure this path is correct

try {
    if(isset($_POST['name'], $_POST['tittle'], $_POST['body'], $_POST['pos_x'], $_POST['pos_y'],  $_POST['po_id'])
       && !empty($_POST['name']) && !empty($_POST['tittle']) && !empty($_POST['body'])
       && !empty($_POST['pos_x']) && !empty($_POST['pos_y'])  && !empty($_POST['po_id'])) {

        // Prepare statement
        $stmt = $conn->prepare("INSERT INTO chalan (name, tittle, body, pos_x, pos_y, po_id) VALUES (:name, :tittle, :body, :pos_x, :pos_y, :po_id)");

        // Bind parameters
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':tittle', $_POST['tittle']);
        $stmt->bindParam(':body', $_POST['body']);
        $stmt->bindParam(':pos_x', $_POST['pos_x']);
        $stmt->bindParam(':pos_y', $_POST['pos_y']);
        $stmt->bindParam(':po_id', $_POST['po_id']);

        // Execute statement
        $stmt->execute();

        $_SESSION['success_message'] = "New records created successfully";
        header('Location: chalan_from.php');
        exit();
    } 
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<div class="container">

<?php
    // Check if there is a success message in the session
    if(isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        // Clear the message after displaying it
        unset($_SESSION['success_message']);
    }
    ?>

    <h1> Chalan From</h1>

<form action="chalan_from.php" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="form-group col-md-6">
      <label for="tittle">Tittle</label>
      <input type="text" class="form-control" id="tittle" name="tittle">
    </div>
  </div>
  <div class="form-group">
    <label for="body">Body:</label>
    <input type="text" class="form-control" id="body" name="body" placeholder="1234 Main St">
  </div>
  <div class="form-group">
    <label for="pos_x">Position X:</label>
    <input type="text" class="form-control" id="pos_x" name="pos_x" placeholder="weight">
  </div>
  <div class="form-group">
    <label for="pos_y">Position Y:</label>
    <input type="text" class="form-control" id="pos_y" name="pos_y" placeholder="height">
  </div>

  <div class="form-group">
    <label for="calan_id">PO ID</label>
    <input type="text" class="form-control" id="po_id" name="po_id" placeholder="po_id">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>
</html>







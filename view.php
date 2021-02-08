<?php

session_start();
if (!isset($_SESSION['name'])) {
  die('Not logged in');
}
require_once "pdo.php";

//***testcases***
if (!isset($_GET['medicine_id'])) {
  $_SESSION['error'] = "Missing medicine_id";
  header('Location: main.php');
  return;
}


//---------select a row with where medicine id matches for displaying--------
$stmt = $pdo->prepare("SELECT * FROM stock where medicine_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['medicine_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
  <?php require_once "bootstrap.php"; ?>
  <title>View Medicine</title>
</head>

<body>
  <div class="container">

    <h3>Hey <?php echo $_SESSION['name'] ?>! Here is details of <?php echo ($row['name']); ?>. </h3>
    <div class="card mb-3">
      <h3 class="card-header">Medicine Details</h3>
      <div class="card-body">
        <h5 class="card-title"><span class="text-primary"> Name: </span><?php echo ($row['name']); ?></h5>
        <h6 class="card-subtitle text-muted"><span class="text-primary"> Category: </span> <?php echo ($row['category']); ?></h6>
      </div>
      <img style="height: 100px; width: 25%; display: block;" src="img/Medicine.jpg" alt="Card image">
      <div class="card-body">
        <p class="card-text">Other Information</p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><span class="text-primary"> Mfg Company: </span> <?php echo ($row['mgf_company']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Price: </span> <?php echo ($row['price']) . "per unit"; ?></li>
        <li class="list-group-item"><span class="text-primary"> Current Stock: </span> <?php echo ($row['current_stock']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Chemical Comp: </span> <?php echo ($row['chemical_comp']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Super Stockist: </span> <?php echo ($row['super_stockist']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Last date of updation of stock: </span> <?php echo ($row['date_m']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Side Effects: </span> <?php echo ($row['side_effects']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Storage Condition: </span> <?php echo ($row['storage_condition']); ?></li>
        <li class="list-group-item"><span class="text-primary"> Warning: </span> <?php echo ($row['warning']); ?></li>
      </ul>
      <div class="card-body">
        <a href="main.php" class="btn btn-info">Back</a>
      </div>
    </div>
</body>

</html>
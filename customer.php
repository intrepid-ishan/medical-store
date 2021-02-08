<?php
//start

session_start();
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
//establish connection
require_once "pdo.php";

if (isset($_SESSION['searchtext'])) {
    //select
    //query for matching search
    $searchtext = $_SESSION['searchtext'];

    $stmt = $pdo->query("SELECT * FROM customer WHERE 
    p_med_name LIKE '%$searchtext%' 
    ");
    //associative array form 
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    unset($_SESSION['searchtext']);
} else {
    //select
    $stmt = $pdo->query("SELECT * from customer");
    //associative array form fetch
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Customer Details</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        <p><a href='main.php' class='btn btn-outline-info'>Back</a></p>

        <div class="form-group col-xs-3 w-25 form-inline">
            <form method="POST">
                <input class="form-control" type="text" placeholder="Search by Medicine" id="searchtext" name="searchtext">
                <button type="submit" class="btn btn-link" name="search">Search</button>
            </form>
        </div>
        <?php
        if (isset($_POST['search'])) {
            $_SESSION['searchtext'] = $_POST['searchtext'];
            header("Location: customer.php");
            return;
        }
        ?>


        <?php


        if (true) {
            //--------table---------
            echo "<table border='2' class='table table-hover' >";

            echo "<thead><tr class='table-info'>";

            echo "<th>Sr. No</th>";
            echo "<th>Name</th>";
            echo "<th>Phone Number</th>";
            echo "<th>Quantity Bought</th>";
            echo "<th>Medicine Name</th>";
            echo "<th>Date Bought</th>";
            echo " </tr></thead>";

            foreach ($rows as $row) {
                echo "<tr><td>";
                echo ($row['customer_id']);
                echo ("</td><td>");
                echo ($row['p_name']);
                echo ("</td><td>");
                echo ($row['p_phone_no']);
                echo ("</td><td>");
                echo ($row['p_quantity']);
                echo ("</td><td>");
                echo ($row['p_med_name']);
                echo ("</td><td>");
                echo ($row['p_date']);
                echo ("</td></tr>\n");
            } //end for                
            echo "</table>";
        } else {
            echo 'No rows found';
        }
        ?>

    </div>

</body>

</html>
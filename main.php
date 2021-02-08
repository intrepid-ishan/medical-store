<?php
//start

session_start();
//establish connection
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

require_once "pdo.php";
//select
$stmt = $pdo->query("SELECT * from stock");
//associative array form 
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <!-- displayed using session -->
        <h2>Welcome <?php echo $_SESSION['name'] ?> </h2>

        <!-- --------logout-------- -->
        <!-- name not set until login done -->
        <div style="float: left">
            <?php
            if (isset($_SESSION['name'])) {
                echo "<p><a href='logout.php' class='btn btn-danger'>Logout</a></p>";
            }
            ?>
        </div>
        <div style="float: right">
            <?php
            if (isset($_SESSION['name'])) {
                echo "<p><a href='customer.php' class='btn btn-outline-info'>View Customer Details</a></p>";
            }
            ?>

        </div>
        <!-- --------flash message box-------- -->

        <?php
        if (isset($_SESSION['success'])) {
            echo ("<br>" . "<br>" . '<p class="alert alert-dismissible alert-success col-sm-4" >' . htmlentities($_SESSION['success']) . "</p>\n");
            unset($_SESSION['success']);
        }
        ?>
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p class="alert alert-dismissible alert-danger col-sm-4" >' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>

        <?php

        if (true) {
            //--------table---------
            echo "<table border='1' class='table table-hover' >";

            echo "<thead><tr class='table-active'>";

            echo "<th>Name</th>";
            echo "<th>Category</th>";
            echo "<th>Current Stock</th>";
            echo "<th>Update Details</th>";
            echo "<th>Delete Record</th>";
            echo "<th>Generate Bill</th>";
            echo " </tr></thead>";                   //end row 

            foreach ($rows as $row) {
                echo "<tr><td>";                     //start row
                //NAME
                echo ("<a  href='view.php?medicine_id=" . $row['medicine_id'] . "'>"
                    . $row['name']  .
                    "</a>" .
                    "<span class='badge badge-info'>View</span>");
                echo ("</td><td>");
                //CATEGORY
                echo ($row['category']);
                echo ("</td><td>");
                //STOCK
                echo ($row['current_stock']);
                echo ("</td>");
                //ACTION
                echo ("<td>");
                echo ('<a class="btn btn-outline-success" href="edit.php?medicine_id=' . $row['medicine_id'] . '">
                    Edit
                    </a>');
                echo ("</td>");
                echo ("<td>");
                echo ('<a class="btn btn-outline-danger" href="delete.php?medicine_id=' . $row['medicine_id'] . '">
                    Delete
                    </a>');
                echo ("</td>");
                //Generate Bill
                echo ("<td>");
                echo ('<a class="btn btn-success" href="generate.php?medicine_id=' . $row['medicine_id'] . '">
                    Generate
                    </a> 
                    ');
                echo ("</td></tr>\n");//end row  
            } //end for                
            echo "</table>";
        } else {
            echo 'No rows found';
        }
        ?>
        <p><a href="add.php"><button type="button" class="btn btn-info">Add New Medicine</button></a></p>
        <p class="text-muted">Note:Click on medicine name for more details.</p>
    </div>
</body>
</html>
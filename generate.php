<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['cancel'])) {
    header("Location: main.php");
    return;
}


require_once "pdo.php";
$stmt = $pdo->prepare("SELECT * FROM stock where medicine_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['medicine_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['stock_available'] = $row['current_stock'];
// echo $_SESSION['stock_available'];
$_SESSION['medicine_id'] = $row['medicine_id'];
// echo $_SESSION['medicine_id'];
$_SESSION['medicine_name'] = $row['name'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $p_name = $_POST['p_name'];
    $p_phone_no = $_POST['p_phone_no'];
    $p_quantity = $_POST['p_quantity'];
    // $p_med_name = $_SESSION['medicine_name'];
    $p_med_name = $_POST['p_med_name'];
    // echo $p_med_name;
    $p_date = $_POST['p_date'];


    if (empty($p_name)) {
        $_SESSION['error'] = "Error:Customer Name is required";
        header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $p_name = test_input($p_name);
        if (!preg_match("/^[a-zA-Z ]*$/", $p_name)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Customer Name";
            header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }

    if (empty($p_phone_no)) {
        $_SESSION['error'] = "Error:Phone No. is required";
        header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $p_phone_no = test_input($p_phone_no);
        if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $p_phone_no)) {
            $_SESSION['error'] = "Error:Phone No. Pattern not matched";
            header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }


    if (empty($p_quantity)) {
        $_SESSION['error'] = "Error:Quantity is required";
        header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        if (is_numeric($p_quantity)) {
            if ($p_quantity > 0) {
                $p_quantity = test_input($p_quantity);
            } else {
                $_SESSION['error'] = "Error:Quantity must be positive";
                header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
                return;
            }
        } else {
            $_SESSION['error'] = "Error:Quantity must be numeric";
            header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }


    if (empty($p_date)) {
        $_SESSION['error'] = "Error:Date is required";
        header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $p_date = test_input($p_date);
    }



    if ($_SESSION['stock_available'] - $p_quantity >= 0) {

        $_SESSION['stock_available'] = $_SESSION['stock_available'] - $p_quantity; //for stock table

        $stmt = $pdo->prepare('INSERT INTO customer (p_name, p_phone_no, p_quantity,p_med_name,p_date) VALUES 
         (:p_name, :p_phone_no, :p_quantity, :p_med_name,:p_date)');

        $stmt->execute(
            array(
                ':p_name' => $p_name,
                ':p_phone_no' => $p_phone_no,
                ':p_quantity' => $p_quantity,
                ':p_med_name' => $p_med_name,
                ':p_date' => $p_date
            )
        );

        //update stock in stock table
        $sql = "UPDATE stock 
        SET  current_stock = :current_stock
        WHERE medicine_id = :medicine_id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute(
            array(
                ':current_stock' => $_SESSION['stock_available'],
                ':medicine_id' => $_SESSION['medicine_id'] //--------update in row with similar medicine id
            )
        );

        $_SESSION['success'] = "Bill Generated Successfully";
        header("Location: main.php");
        return;
    } else {
        $_SESSION['error'] = "Requested number of quantity not available.Please Verify.";
        //to display information again, therefore passing as get parameter
        header('Location:generate.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Generation</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>


    <div class="container">

        <div class="card border-info mb-3" style="max-width: 20rem;">
            <div class="card-header">Generate bill for <?php echo ($row['name']); ?></div>
            <div class="card-body">
                <h4 class="card-title"><?php echo ($row['category']); ?></h4>
                <p class="card-text">Quantity Available : <?php echo ($row['current_stock']); ?></p>
            </div>
        </div>
        <!-- --------flash message box-------- -->
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p class="alert alert-dismissible alert-danger col-sm-4" >' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>

        <h1>Customer Details</h1>
        <div class="form-group">
            <form method="post">
                Name<input type="text" class="form-control col-sm-8" placeholder="Name of Person" name="p_name"><br>
                Phone No<input type="text" class="form-control col-sm-8" placeholder="Phone Number(000-000-0000)" name="p_phone_no"><br>
                Quantity Required<input type="text" class="form-control col-sm-8" placeholder="Quantity Required" name="p_quantity"><br>
                Name of medicine<input type="text" class="form-control col-sm-8" value="<?php echo $row['name'] ?>" name="p_med_name" readonly=""><br>
                Buying Date <input type="date" class="form-control col-sm-4" name="p_date"><br>
                <button type="submit" class="btn btn-info">Submit</button>
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>


    </div>
</body>

</html>
<?php
session_start();

//***testcases*** 
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['cancel'])) {
    header("Location: main.php");
    return;
}


require_once "pdo.php";



//--------deletion in table where medicine id matches after submit--------
if (isset($_POST['Delete']) && isset($_POST['medicine_id'])) {
    $sql = "DELETE FROM stock WHERE medicine_id = :zip";
    $stmt = $pdo->prepare($sql);

    //you can take here GET also
    $stmt->execute(array(':zip' => $_POST['medicine_id'])); //POST due to hidden field set
    $_SESSION['success'] = 'Record deleted';
    header('Location: main.php');
    return;
}



// ***testcases*** Make sure that medicine_id is present
if (!isset($_GET['medicine_id'])) {
    $_SESSION['error'] = "Missing medicine_id";
    header('Location: main.php');
    return;
}



//---------select a row with where medicine id matches for displaying--------
$stmt = $pdo->prepare("SELECT * FROM stock where medicine_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['medicine_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for medicine id';
    header('Location: main.php');
    return;
}
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
    <title>Delete Medicine</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        <h3>Hey <?php echo $_SESSION['name'] ?>! Are you sure? </h3>


        <!-- --------buttons--------  -->
        <div class="form-group">
            <form method="post">
                <!-- hidden -->
                <input type="hidden" name="medicine_id" value="<?php echo $_GET['medicine_id'] ?>">
                <button type="submit" class="btn btn-success" name="Delete">Yes</button>
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>

        <div class="card mb-3">
            <h3 class="card-header">Medicine Details</h3>
            <div class="card-body">
                <h5 class="card-title"><span class="text-primary"> Name: </span><?php echo ($row['name']); ?></h5>
                <h6 class="card-subtitle text-muted"><span class="text-primary"> Category: </span> <?php echo ($row['category']); ?></h6>
            </div>
        </div>

        <p class="text-muted">Note:All information related to medicine will be deleted.</p>
    </div>
</body>
<?php
session_start();
require_once "pdo.php";

//if dont want to signup in
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}
$salt = 'XyZzy12*_';

//executed when form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //-------- php validation--------
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $pass = test_input($_POST['pass']);


    if (empty($name)) {
        $_SESSION['error'] = "Error:Name is required";
        header("Location: signup.php");
        return;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Name";
            header("Location: signup.php");
            return;
        }
    }

    if (empty($_POST["email"])) {
        $_SESSION['error'] = "Error:Email is required";
        header("Location: signup.php");
        return;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Error:Invalid email format";
            header("Location: signup.php");
            return;
        }
    }

    if (empty($_POST["pass"])) {
        $_SESSION['error'] = "Error:Password is required";
        header("Location: signup.php");
        return;
    } else {
        if (strlen(trim($pass)) < 8) {
            $_SESSION['error'] = "Error:Password must be of length 8 minimum";
            header("Location: signup.php");
            return;
        }
    }
    //--------end php validation--------



    $en_pass = hash('md5', $salt . $pass);

    $sql = 'INSERT INTO users (name,email,password) VALUES (:name,:email, :pass)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $name,
        ':email' => $email,
        ':pass' => $en_pass
    ));

    header("Location: login.php");
    return;
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Sign Up</title>
</head>

<body>
    <div class="container">
        <h1>Please Sign Up</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p class="alert alert-dismissible alert-danger col-sm-4" >' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>



        <!-- --------signup form--------  -->
        <div class="form-group">
            <form method="POST">
                <input type="text" class="form-control col-sm-4" placeholder="Name" name="name"><br>
                <input type="text" class="form-control col-sm-4" placeholder="you@example.com" name="email"><br>
                <input type="password" class="form-control col-sm-4" placeholder="Enter 8 characters or more" name="pass" id="id_1723"><br>
                <button type="submit" class="btn btn-success">Sign Up</button>
                <button type="submit" class="btn  btn-outline-danger" name="cancel">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>
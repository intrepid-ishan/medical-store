<?php
//start in each file where you need session variable
session_start();
require_once "pdo.php";

//if dont want to login in
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}
$salt = 'XyZzy12*_'; //default salt value


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

    $email = test_input($_POST['email']);
    $pass = test_input($_POST['pass']);


    if (empty($_POST["email"])) {
        $_SESSION['error'] = "Error:Email is required";
        header("Location: login.php");
        return;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Error:Invalid email format";
            header("Location: login.php");
            return;
        }
    }

    if (empty($_POST["pass"])) {
        $_SESSION['error'] = "Error:Password is required";
        header("Location: login.php");
        return;
    } else {
        if (strlen(trim($pass)) < 8) {
            $_SESSION['error'] = "Error:Password must be 8characters";
            header("Location: login.php");
            return;
        }
    }
    //--------end php validation--------


    $check = hash('md5', $salt . $pass);
    //check for email and password entered in database table
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $email, ':pw' => $check));

    //fetch as associative array, coloum name as key
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //if no such array found then will return ***false***

    //if found
    if ($row == true) {
        //for that user store its name and user_id
        $_SESSION['name'] = $row['name']; //set
        $_SESSION['user_id'] = $row['user_id']; //set
        // Redirect the browser to index.php ###alternateoption### new php file to avoid if statement in index.php
        header("Location: main.php");
        return;
    } //if not
    else {
        $_SESSION['error'] = "Not Matched";
        //redirect to same page to break post submission again
        header("Location: login.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h1>Please Login In</h1>

        <!-- --------flash message box for error-------- -->
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p class="alert alert-dismissible alert-danger col-sm-4" >' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>

        <div class="form-group">
            <form method="POST">
                <input type="text" class="form-control col-sm-4" placeholder="you@example.com" name="email"><br>
                <input type="password" class="form-control col-sm-4" placeholder="Enter 8 characters or more" name="pass" id="id_1723"><br>
                <button type="submit" class="btn btn-success">Login</button>
                <button type="submit" class="btn  btn-outline-danger" name="cancel">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>
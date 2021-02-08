<?php
session_start();

require_once "pdo.php";

//***testcases**** 
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['cancel'])) {
    header('Location: main.php');
    return;
}





//--------updation in table where medicine id matches--------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id = $_GET['medicine_id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $mfg_company = $_POST['mgf_company'];
    $price = $_POST['price'];
    $current_stock = $_POST['current_stock'];
    $chemical_comp = $_POST['chemical_comp'];
    $super_stockist = $_POST['super_stockist'];
    $date_m = $_POST['date_m'];
    $side_effects = $_POST['side_effects'];
    $storage_condition = $_POST['storage_condition'];
    $warning = $_POST['warning'];

    $_SESSION['medicine_id'] = $id; //IMP


    if (empty($name)) {
        $_SESSION['error'] = "Error:Medicine Name is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $name = test_input($name);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Medicine Name";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }

    if (empty($category)) {
        $_SESSION['error'] = "Error:Category is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $category = test_input($category);
        if (!preg_match("/^[a-zA-Z ]*$/", $category)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Category";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }

    if (empty($mfg_company)) {
        $_SESSION['error'] = "Error:Mfg Company is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $mfg_company = test_input($mfg_company);
        if (!preg_match("/^[a-zA-Z ]*$/", $mfg_company)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Mfg Company";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }

    if (empty($price)) {
        $_SESSION['error'] = "Error:Price is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        if (is_numeric($price)) {
            $price = test_input($price);
            if ($price > 0) {
                $price = test_input($price);
            } else {
                $_SESSION['error'] = "Error:Price must be non-negative";
                header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
                return;
            }
        } else {
            $_SESSION['error'] = "Error:Price must be numeric";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }

    if (empty($current_stock)) {
        $_SESSION['error'] = "Error:Current Stock is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        if (is_numeric($current_stock)) {
            if ($current_stock > 0) {
                $current_stock = test_input($current_stock);
            } else {
                $_SESSION['error'] = "Error:Quantity must be non-negative";
                header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
                return;
            }
        } else {
            $_SESSION['error'] = "Error:Quantity must be numeric";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }

    if (empty($chemical_comp)) {
        $_SESSION['error'] = "Error:Chemical Company is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $chemical_comp = test_input($chemical_comp);
    }

    if (empty($super_stockist)) {
        $_SESSION['error'] = "Error:Super Stockist is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $super_stockist = test_input($super_stockist);
        if (!preg_match("/^[a-zA-Z(), ]*$/", $super_stockist)) {
            $_SESSION['error'] = "Error:Numbers no allowed in Super Stockist";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }


    if (empty($side_effects)) {
        $_SESSION['error'] = "Error:Side Effects is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $side_effects = test_input($side_effects);
        if (!preg_match("/^[a-zA-Z, ]*$/", $side_effects)) {
            $_SESSION['error'] = "Error:Only letters and white space and comman allowed in side effects";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }


    if (empty($storage_condition)) {
        $_SESSION['error'] = "Error:Storage Condition is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $storage_condition = test_input($storage_condition);
        if (!preg_match("/^[a-zA-Z ]*$/", $storage_condition)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Storage Condition";
            header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
            return;
        }
    }


    if (empty($date_m)) {
        $_SESSION['error'] = "Error:Date is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $date_m = test_input($date_m);
    }


    if (empty($warning)) {
        $_SESSION['error'] = "Error:Warning/Additional info is required";
        header('Location:edit.php?medicine_id=' . $_SESSION['medicine_id'] . '');
        return;
    } else {
        $warning = test_input($warning);
    }



    if (!isset($_SESSION['error'])) {
        $sql = "UPDATE stock 
            SET  name = :name,
            category = :category,
            mgf_company = :mgf_company,
            price = :price,
            current_stock = :current_stock,
            chemical_comp = :chemical_comp,
            super_stockist = :super_stockist,
            date_m = :date_m,
            side_effects = :side_effects,
            storage_condition = :storage_condition,
            warning = :warning,
            medicine_id = :medicine_id
            WHERE medicine_id = :medicine_id";


        $stmt = $pdo->prepare($sql);

        $stmt->execute(
            array(
                ':name' => $name,
                ':category' => $category,
                ':mgf_company' => $mfg_company,
                ':price' => $price,
                ':current_stock' => $current_stock,
                ':chemical_comp' => $chemical_comp,
                ':super_stockist' => $super_stockist,
                ':date_m' => $date_m,
                ':side_effects' => $side_effects,
                ':storage_condition' => $storage_condition,
                ':warning' => $warning,
                ':medicine_id' => $_GET['medicine_id'] //--------update in row with similar medicine id
            )
        );
        // success redirection
        $_SESSION['success'] = 'Record updated';
        header('Location: main.php');
        return;
    }
}



//***testcase***Make sure that medicine_id is present
if (!isset($_GET['medicine_id'])) {
    $_SESSION['error'] = "Missing medicine_id";
    header('Location: main.php');
    return;
}




//---------select a row with where medicine id matches for displaying--------
$stmt = $pdo->prepare("SELECT * FROM stock where medicine_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['medicine_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);




//***testcase*** if database changed 
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    // header('Location: main.php');
    return;
}
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Edit Profile</title>
</head>

<body>
    <div class="container">
        <h2>Hey <?php echo $_SESSION['name'] ?>!</h2>
        <!-- --------flash message box-------- -->
        <p class="text-muted">Note:all fields are compalsary. Write "NA" to avoid validation of non numerical values</p>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p class="alert alert-dismissible alert-danger col-sm-4" >' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>


        <!-- --------simple form-------- with value field set -->
        <div class="form-group">
            <form method="post">
                Name<input type="text" class="form-control col-sm-8" placeholder="Name of medicine" name="name" value="<?php echo $row['name'] ?>"><br>
                Category<input type="text" class="form-control col-sm-8" placeholder="Category(Painkiller,antibiotic ..)" name="category" value="<?php echo $row['category'] ?>"><br>
                MFG Company<input type="text" class="form-control col-sm-8" placeholder="Manufacturing Company Name" name="mgf_company" value="<?php echo $row['mgf_company'] ?>"><br>
                Price<input type="text" class="form-control col-sm-8" placeholder="Price of 1 medicine" name="price" value="<?php echo $row['price'] ?>"><br>
                Quantity<input type="text" class="form-control col-sm-8" placeholder="Quantity" name="current_stock" value="<?php echo $row['current_stock'] ?>"><br>
                Chemical Composition<input type="text" class="form-control col-sm-8" placeholder="Chemical Composition" name="chemical_comp" value="<?php echo $row['chemical_comp'] ?>"><br>
                Super Stockist<input type="text" class="form-control col-sm-8" placeholder="Super Stockist" name="super_stockist" value="<?php echo $row['super_stockist'] ?>"><br>
                Side Effects<input type="text" class="form-control col-sm-8" placeholder="Side Effects(Separated with comma,)" name="side_effects" value="<?php echo $row['side_effects'] ?>"><br>
                Storage Condition<input type="text" class="form-control col-sm-8" placeholder="Storage Condition(Room Temperature,Cold Storage Condition,Fridge Storage Condition...)" name="storage_condition" value="<?php echo $row['storage_condition'] ?>"><br>
                Stock Updated on <input type="date" value="12-12-2000" class="form-control col-sm-4" name="date_m" value="<?php echo $row['date_m'] ?>"><br>
                Other Information<textarea class="form-control col-sm-8" placeholder="Other Information/Warning" rows="5" name="warning"><?php echo $row['warning'] ?></textarea><br>
                <button type="submit" class="btn btn-info">Save</button>
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>
      
    </div>
</body>

</html>
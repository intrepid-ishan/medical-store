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


//--------addition in table with validation--------

require_once "pdo.php";
//check of post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = $_POST['name'];
    $category = $_POST['category'];
    $mfg_company = $_POST['mfg_company'];
    $price = $_POST['price'];
    $current_stock = $_POST['current_stock'];
    $chemical_comp = $_POST['chemical_comp'];
    $super_stockist = $_POST['super_stockist'];
    $date_m = $_POST['date_m'];
    $side_effects = $_POST['side_effects'];
    $storage_condition = $_POST['storage_condition'];
    $warning = $_POST['warning'];



    if (empty($name)) {
        $_SESSION['error'] = "Error:Medicine Name is required";
        header("Location: add.php");
        return;
    } else {
        $name = test_input($name);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Medicine Name";
            header("Location: add.php");
            return;
        }
    }

    if (empty($category)) {
        $_SESSION['error'] = "Error:Category is required";
        header("Location: add.php");
        return;
    } else {
        $category = test_input($category);
        if (!preg_match("/^[a-zA-Z ]*$/", $category)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Category";
            header("Location: add.php");
            return;
        }
    }

    if (empty($mfg_company)) {
        $_SESSION['error'] = "Error:Mfg Company is required";
        header("Location: add.php");
        return;
    } else {
        $mfg_company = test_input($mfg_company);
        if (!preg_match("/^[a-zA-Z ]*$/", $mfg_company)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Mfg Company";
            header("Location: add.php");
            return;
        }
    }

    if (empty($price)) {
        $_SESSION['error'] = "Error:Price is required";
        header("Location: add.php");
        return;
    } else {
        if (is_numeric($price)) {
            if ($price > 0) {
                $price = test_input($price);
            } else {
                $_SESSION['error'] = "Error:Price must be non-negative";
                header("Location: add.php");
                return;
            }
        } else {
            $_SESSION['error'] = "Error:Price must be numeric";
            header("Location: add.php");
            return;
        }
    }

    if (empty($current_stock)) {
        $_SESSION['error'] = "Error:Current Stock is required";
        header("Location: add.php");
        return;
    } else {
        if (is_numeric($current_stock)) {
            if ($current_stock > 0) {
                $current_stock = test_input($current_stock);
            } else {
                $_SESSION['error'] = "Error:Quantity must be non-negative";
                header("Location: add.php");
                return;
            }
        } else {
            $_SESSION['error'] = "Error:Quantity must be numeric";
            header("Location: add.php");
            return;
        }
    }

    if (empty($chemical_comp)) {
        $_SESSION['error'] = "Error:Chemical Company is required";
        header("Location: add.php");
        return;
    } else {
        $chemical_comp = test_input($chemical_comp);
    }

    if (empty($super_stockist)) {
        $_SESSION['error'] = "Error:Super Stockist is required";
        header("Location: add.php");
        return;
    } else {
        $super_stockist = test_input($super_stockist);
        if (!preg_match("/^[a-zA-Z(), ]*$/", $super_stockist)) {
            $_SESSION['error'] = "Error:Numbers no allowed in Super Stockist";
            header("Location: add.php");
            return;
        }
    }


    if (empty($side_effects)) {
        $_SESSION['error'] = "Error:Side Effects is required";
        header("Location: add.php");
        return;
    } else {
        $side_effects = test_input($side_effects);
        if (!preg_match("/^[a-zA-Z, ]*$/", $side_effects)) {
            $_SESSION['error'] = "Error:Only letters and white space and comman allowed in side effects";
            header("Location: add.php");
            return;
        }
    }


    if (empty($storage_condition)) {
        $_SESSION['error'] = "Error:Storage Condition is required";
        header("Location: add.php");
        return;
    } else {
        $storage_condition = test_input($storage_condition);
        if (!preg_match("/^[a-zA-Z ]*$/", $storage_condition)) {
            $_SESSION['error'] = "Error:Only letters and white space allowed in Storage Condition";
            header("Location: add.php");
            return;
        }
    }


    if (empty($date_m)) {
        $_SESSION['error'] = "Error:Date is required";
        header("Location: add.php");
        return;
    } else {
        $date_m = test_input($date_m);
    }


    if (empty($warning)) {
        $_SESSION['error'] = "Error:Warning/Additional info is required";
        header("Location: add.php");
        return;
    } else {
        $warning = test_input($warning);
    }


    $stmt = $pdo->prepare('INSERT INTO stock (user_id,name, category, mgf_company, price, current_stock,chemical_comp,super_stockist,date_m,side_effects,storage_condition,warning) VALUES 
                                                    (:user_id, :name, :category, :mgf_company, :price, :current_stock,:chemical_comp,:super_stockist,:date_m,:side_effects,:storage_condition,:warning)');

    $stmt->execute(
        array(
            ':user_id' => $_SESSION['user_id'],
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
            ':warning' => $warning
        )
    );
    $_SESSION['success'] = "New Record added.";
    header("Location: main.php");
    return;
}


?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Add Profile</title>
</head>

<body>
    <div class="container">
        <h1><?php echo $_SESSION['name'] ?>, you can add medicine details </h1>
        <p class="text-muted">Note:all fields are compalsary. Write "NA" to avoid validation of non numerical values</p>
        <!-- --------flash message box-------- -->
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p class="alert alert-dismissible alert-danger col-sm-4" >' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>


        <div class="form-group">
            <form method="post">

                Name<input type="text" class="form-control col-sm-8" placeholder="Name of medicine" name="name"><br>
                Category<input type="text" class="form-control col-sm-8" placeholder="Category(Painkiller,antibiotic,steriods,antipsychotic,diuretics,antidepressants  ..)" name="category"><br>
                MFG Company<input type="text" class="form-control col-sm-8" placeholder="Manufacturing Company Name" name="mfg_company"><br>
                Price<input type="text" class="form-control col-sm-8" placeholder="Price of 1 medicine(Non Negative)" name="price"><br>
                Quantity<input type="text" class="form-control col-sm-8" placeholder="Quantity(Non Negative)" name="current_stock"><br>
                Chemical Composition<input type="text" class="form-control col-sm-8" placeholder="Chemical Composition" name="chemical_comp"><br>
                Super Stockist<input type="text" class="form-control col-sm-8" placeholder="Super Stockist" name="super_stockist"><br>
                Side Effects<input type="text" class="form-control col-sm-8" placeholder="Side Effects" name="side_effects"><br>
                Storage Condition<input type="text" class="form-control col-sm-8" placeholder="Storage Condition(Room Temperature,Cold Storage Condition,Fridge Storage Condition...)" name="storage_condition"><br>
                Stock Updated on <input type="date" value="12-12-2000" class="form-control col-sm-4" name="date_m"><br>
                Other Information<textarea class="form-control col-sm-8" placeholder="Other Information/Warning" rows="5" name="warning"></textarea><br>
                <button type="submit" class="btn btn-info">Add</button>

                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>
        
    </div>
</body>

</html>
<html>

<head>
    <title>Question Details</title>
    <?php require_once "bootstrap.php"; ?>
    <style>
        .column {
            float: left;
            width: 25%;
            padding: 0 10px;
        }

        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-3">CE651 – LAMP Technologies</h1>
            <p class="lead">Q. 1 Design system for storing stock related information for medicines at medical
                stores. This system should allow adding information of new medicines which
                should include fields like name, chemical components, company that produces,
                price, super stockiest details, quantity, category (antibiotic, pain killer, etc.), side
                effects, etc. Admin at medical store should be able to view stock of all the
                medicines. He should be able update stock through your system whenever new
                bulk order is deliver to store. On bill generation medicine should automatically get
                deducted from stock.</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="index.php" role="button">Back</a>
            </p>
        </div>
    </div>
</body>

</html>
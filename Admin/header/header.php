<?php 
include './config.php';
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon">
    <title>Admin | Management </title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="index.php">
                        
                        <h2 class="title">
                            <div class="logo"><img src="../logo.png" alt=""></div>
                        </h2>
                    </a>
                </li>

                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                        <i class="icon-home"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="users.php">
                        <span class="icon">
                        <i class="icon-users"></i>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>
                <li>
                    <a href="requests.php">
                        <span class="icon">
                        <i class="icon-bell"></i>
                        </span>
                        <span class="title">Requests</span>
                    </a>
                </li>
                <li>
                    <a href="products.php">
                        <span class="icon">
                        <i class="icon-tag"></i>
                        </span>
                        <span class="title">Products</span>
                    </a>
                </li>
                <li>
                    <a href="./log_out.php">
                        <span class="icon">
                        <i class="icon-log-out"></i>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <i class="icon-menu"></i>
                </div>

            
                <div class="user">
                    <i class="icon-bell"></i>
                    <span class="notifications">
                    <?php 
                             $statement =$con->prepare("SELECT id  FROM requests");
                             $statement->execute(array());
                             $counter = $statement->rowCount();
                             echo $counter;
                    ?>
                    </span>
                </div>
            </div>

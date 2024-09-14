<?php
	include 'config.php';
	session_start();
    ob_start();
if(isset($_SESSION['user_email'])){
    $client_email = $_SESSION['user_email'];    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon">
    <title>AGS</title>
    <link rel="stylesheet" href="./Css/styles.css">
    <link rel="stylesheet" href="./Css/style.css">
</head>
<body>
    <div class="container">
            <!--===============================================================
            ====================== Started Header Section =====================
            ================================================================-->
        <header>
            <div class="logo"><img src="../logo.png" alt=""></div>
            <div class="short">
            <div id="iconUser" class="profile">
                    <i class="icon-user" ></i>
                 <div class="customer-info" id="profile" style="display: none;" >
                 <div class="profile-card">
                    <div class="image"><img src="./icon/user-icon.png" alt="" class="profile-pic"></div>
                                <?php 
                                    $statement = $con-> prepare("SELECT * FROM clients WHERE email = :email");
                                    $statement->execute(array(':email' => $client_email));
                                    $client_data = $statement->fetch(PDO::FETCH_ASSOC);
                                ?>
                    <div class="data">
                    <div class="user-stat">
                        <span>
                            <?php if ($client_data['stat'] > 0) {
                                    echo '<span class="green"><i class="icon-check-circle"></i> Active</span>';
                                }else{
                                    echo '<span class="red"><i class="icon-x-circle"></i> Non Active</span>';
                                }
                             ?>
                        </span>
                        </div>
                        <div class="user-data">
                        <i class="icon-user" ></i><span><?php echo $client_data['name'];?></span>
                        </div>
                        <div class="user-data">
                        <i class="icon-mail" ></i><span><?php echo $client_data['email']?></span>
                        </div>
                        <div class="user-data">
                        <i class="icon-phone" ></i><span><?php echo $client_data['number']?></span>
                        </div>
                    </div>
                    <div class="buttons"><a href="./log_out.php" class="btn"><i class="icon-log-out"></i></a></div>
                </div>
                 </div>
                </div>
                <div class="iconCart">
                <i class="icon-shopping-cart"></i>
                <div class="totalQuantity">
                <?php
                    $counter_requests = $client_data['id'];
                    $statement =$con->prepare("SELECT client_id  FROM requests WHERE client_id = ? ");
                    $statement->execute(array($counter_requests));
                    $counter = $statement->rowCount();
                    echo $counter;
                ?>
                </div>
            </div>
            </div>
        </header>
            <!--===============================================================
            ====================== Started Products Section ===================
            ================================================================-->
            <?php             
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if ($client_data['stat'] === 0) {  
                        echo '<div class="red">You need to active your account</div>';
                    }else{  
                    $my_amount = $_POST["my_amount"];
                    if (isset($_POST["id_x"])) {
                        $id_x = $_POST["id_x"];  // 'id_x' key exists, access it safely
                    } 
                    if (empty($my_amount)) {                                       
                    $statement = $con-> prepare("SELECT * FROM products where product_id = $id_x");
                    $statement->execute();
                    $statement = $statement->fetchAll();
                foreach ($statement as $row) {    
                    echo '<div class="add-to-cart" id="confirmOrder"><i id="iconX" class="icon-x"></i>
                    <form class="form" action="'.$_SERVER['PHP_SELF'].'" method="POST">';
                    echo '<div class="your-order">';
                    echo '<img src="./image/'. $row["img"].'">
                    <div>
                    <h1>'. $row["title"].'</h1>
                    <h4>'. $row["description"].'</h4>
                    <h5>'. $row["price"].'</h5>
                    <span>'. $row["amount"].'</span>
                    </div>';

                    echo '</div>';   
                    echo '<div class="group">';
                    echo '<input type="text" name="client_id" value="'.$client_data['id'].'"style="display: none;">';
                    echo '<input type="text" name="client_email" value="'.$client_data['email'].'"style="display: none;">';
                    echo '<input type="text" name="client_name" value="'.$client_data['name'].'"style="display: none;">';
                    echo '<input type="text" name="client_number" value="'.$client_data['number'].'"style="display: none;">';
                    echo '<input type="number" name="my_amount" max="'. $row["amount"].'" min="1" placeholder="This needs to be between 1 And '. $row["amount"].'" required>';
                    echo '<input type="text" name="my_comment" max="50"  value="" placeholder="Message">';
                    echo '</div>'; 

                    echo '<div class="group"style="display: none;">';
                    echo '<input type="text" name="product_id" value="'. $row["product_id"].'"style="display: none;">';
                    echo '<input type="text" name="product_img" value="'. $row["img"].'"style="display: none;">';
                    echo'<input type="text" name="product_title" value="'. $row["title"].'"style="display: none;">';
                    echo '<input type="text" name="product_price" value="'. $row["price"].'"style="display: none;">';
                    echo '<input type="text" name="product_amount" value="'. $row["amount"].'"style="display: none;">';
                    echo '</div>';
                    
                    echo '<div class="group"><div class="buttons">';
                    echo'<button id="addItem">Add</button>';
                    echo'</div></div></form></div><div class="cashX" id="cash"></div>';
                    }};
                };
                if (!empty($my_amount)) {
                    $client_id = $_POST["client_id"];
                    $client_email = $_POST["client_email"];
                    $client_name = $_POST["client_name"];
                    $client_number = $_POST["client_number"];
                
                    $my_amount = $_POST["my_amount"];
                    $my_comment = $_POST['my_comment'];
                
                    $product_id = $_POST["product_id"];
                    $product_img = $_POST["product_img"];
                    $product_title = $_POST["product_title"];
                    $product_price = $_POST["product_price"];
                    $product_amount = $_POST["product_amount"];
                
                    // Check if there's an existing request with the same product_id for the current client
                    $existing_statement = $con->prepare("SELECT * FROM requests WHERE product_id = :product_id AND client_id = :client_id");
                    $existing_statement->execute(array(':product_id' => $product_id, ':client_id' => $client_id));
                    $existing_request = $existing_statement->fetch(PDO::FETCH_ASSOC);
                
                    if ($existing_request) {
                        // If an existing request is found, update it
                        $new_amount = $existing_request['amount'] + $my_amount;
                
                        $update_statement = $con->prepare("UPDATE requests SET amount = :new_amount WHERE product_id = :product_id AND client_id = :client_id");
                        $update_statement->execute(array(':new_amount' => $new_amount, ':product_id' => $product_id, ':client_id' => $client_id));
                         // Update product amount in products table
                         $newAmount = $product_amount - $my_amount;
                         $updateStatement = $con->prepare("UPDATE products SET amount = :newAmount WHERE product_id = :product_id");
                         $updateStatement->execute(array(
                             'newAmount' => $newAmount,
                             'product_id' => $product_id));
                              // Redirect to the current page to reload
                            header("Location: {$_SERVER['PHP_SELF']}");
                            exit();
                    } else {
                        // If no existing request is found, insert a new one
                        $insert_statement = $con->prepare("INSERT INTO requests (img, product_id, title, price, amount, client_id, client_email, client_name, client_number, comment, date)
                            VALUES (:img, :product_id, :title, :price, :amount, :client_id, :client_email, :client_name, :client_number, :my_comment, now())");
                        $insert_statement->execute(array(
                            'img' => $product_img,
                            'product_id' => $product_id,
                            'title' => $product_title,
                            'price' => $product_price,
                            'amount' => $my_amount,
                            'client_id' => $client_id,
                            'client_email' => $client_email,
                            'client_name' => $client_name,
                            'client_number' => $client_number,
                            'my_comment' => $my_comment
                        ));
                            // Update product amount in products table
                        $newAmount = $product_amount - $my_amount;
                        $updateStatement = $con->prepare("UPDATE products SET amount = :newAmount WHERE product_id = :product_id");
                        $updateStatement->execute(array(
                            'newAmount' => $newAmount,
                            'product_id' => $product_id
                        ));
                    
                        // Redirect to the current page to reload
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                    };
                } 
            };
            ?>
            <div class="search">
                <i class="icon-search"></i>
            <input type="text" class="searchItem" id="searchInput" placeholder="Search here">
            </div>
        <div class="listProduct">
        <?php
            $statement = $con-> prepare("SELECT * FROM products WHERE amount > 0");
            $statement->execute();
            $statement = $statement->fetchAll();
            foreach ($statement as $row) {
                echo '<form class="item" action="'.$_SERVER['PHP_SELF'].'"method="POST">';
                    echo '<img src="image/'. $row["img"].'" alt="">';
                    echo '<h2>'.$row["title"].'</h2>';
                    echo '<p class="">'.$row["description"].'</p>';
                    echo '<span class="price">'.$row["price"].'UMR</span>';
                    echo '<span class="amount">'.$row["amount"].'</span>';
                    echo '<input style="display: none; type="number" name="id_x" value="'.$row['product_id'].'">';
                    echo '<input type="number" name="my_amount" value="" style="display: none;">';
                    echo '<div class="add"><button ><i class="icon-shopping-cart"></i></button></div>';
                echo '</form>';
            };?>
            <?php
               
                ?>
        </div>
    </div>
            <!--===============================================================
            ====================== Start Cart Section =========================
            ================================================================-->

    <div class="cart" style="right: -100%;">
        <h2>CART</h2>
        <div class="listCart">
        <div class="requests">
                <!-- Requests displayed here -->
                <?php
                 // Initialize total price variable
                     $totalPrice = 0;
                if ($counter == 0) {
                    echo 'Your basket is empty';
                } else {
                    $cart_requests = $client_data['id'];
                    $statement = $con->prepare("SELECT * FROM requests WHERE client_id = ?");
                    $statement->execute([$cart_requests]);
                    $requests = $statement->fetchAll();
                    foreach ($requests as $row) {
                        // Add the price of each request to the total price
                        $totalPrice += $row['price'] * $row['amount'];

                        echo '<div class="item">';
                        echo '<img src="image/' . $row['img'].'">';
                        echo '<div class="content">';
                        echo '<div class="name">' . $row['title'] . '</div>';
                        echo '<div class="price"><span>' . $row['price'].'MUR</span></div>';
                        echo '<div class="price">' . $row['date'] . '</div>';
                        echo '<input type="text" name="my_comment" max="50" style="display: none;">';
                        echo '</div>';
                        echo '<div class="quantity">';
                        echo '<span class="value">' . $row['amount'] . '</span>';
                        if ($row['stat'] == 0) {
                            echo '<a href="?do=checkOut&id='.$row['id'].'" class="check"><i class="icon-check"></i></a>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }?>
                    <div class="total"><span><?php 
                 echo 'Total :'.$totalPrice.'MUR';?>
                 </span></div>
                    <?php 
                    // Pay Action [Request]
                    if (isset($_GET["do"]) && $_GET["do"] == "checkOut") {
                        if (isset($_GET["id"])) {
                            $requestId = $_GET["id"];
                            // Prepare and execute the update statement
                                $updateStatement = $con->prepare("UPDATE requests SET stat = 1 WHERE id = :id");
                                $updateStatement->bindParam(':id', $requestId);
                                $updateStatement->execute();
                                // Redirect to the current page to reload
                                header("Location: {$_SERVER['PHP_SELF']}");
                                exit();
                        }
                    }
                }
                ?>
            </div>
            
        <?php
                // Delete Action
                if (isset($_GET["do"]) && $_GET["do"] == "Delete") {
                    // Get the client ID
                    $cart_requests = $client_data['id'];

                    // Fetch all requests to calculate the total amount to be subtracted from products
                    $statement = $con->prepare("SELECT * FROM requests WHERE client_id = ?");
                    $statement->execute([$cart_requests]);
                    $requests = $statement->fetchAll();

                    // Initialize total amount to subtract from products
                    $totalAmountToSubtract = 0;

                    // Loop through requests to calculate the total amount to be subtracted from products
                    foreach ($requests as $request) {
                        if ($request['stat'] === 1) {
                            // If status is 1, just delete the request without updating product amount
                            $statement = $con->prepare("DELETE FROM requests WHERE id = ?");
                            $statement->execute([$request['id']]);
                        } else {
                            // If status is 0, update product amount and then delete the request
                            $totalAmountToSubtract += $request['amount'];
                            $statement = $con->prepare("UPDATE products 
                                                        SET amount = amount + ? 
                                                        WHERE product_id = ?");
                            $statement->execute([$request['amount'], $request['product_id']]);
                            $statement = $con->prepare("DELETE FROM requests WHERE id = ?");
                            $statement->execute([$request['id']]);
                        }
                    };
                        // Delete all requests associated with the client
                        $statement = $con->prepare("DELETE FROM requests WHERE client_id = ?");
                        $statement->execute([$cart_requests]);
                    // Redirect to the current page to reload
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                };
            ?>
                
    </div>
                <?php
                if ($counter >0) {
                    ?>
                    <div class="buttons">
                    <button class="print-invoice" onclick="printInvoice()"><i class="icon-eye"></i></button>
                    <a class="delete-all" href="?do=Delete&id=<?php echo $client_data['id']; ?>"><i class="icon-trash"></i></a>
                    </div>
                    <?php
                } 
                ?>
</div>
    <script src="./JS/app.js"></script>
    <script>
        function printInvoice() {
            // Customize the URL to match your file structure and naming conventions
            window.open('invoice.php?client_id=<?php echo $client_data['id']; ?>', '_blank');
            };
            document.getElementById("searchInput").addEventListener("keyup", filterItems);
                function filterItems() {
                    var input, filter, items, item, title, i;
                    input = document.getElementById("searchInput");
                    filter = input.value.toUpperCase();
                    items = document.getElementsByClassName("item");

                    // Loop through all items, and hide those that don't match the search query
                    for (i = 0; i < items.length; i++) {
                        title = items[i].getElementsByTagName("h2")[0];
                        if (title) {
                            if (title.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                items[i].style.display = "";
                            } else {
                                items[i].style.display = "none";
                            }
                        }
                    }
                }
    </script>
</body>
</html>
<?php 

}else{
    header("Location:../index.php");
    exit();
}
ob_end_flush();
?>
<?php
session_start();
include('./header/header.php');
if(isset($_SESSION['admin_email'])){
 $admin_email = $_SESSION['admin_email']; 
?>
<!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <a href="products.php">
                    <div>
                        <div class="numbers">
                        <?php 
                             $statement =$con->prepare("SELECT product_id  FROM Products");
                             $statement->execute(array());
                             $counter = $statement->rowCount();
                             echo $counter;
                        ?>
                        </div>
                        <div class="cardName">Products</div>
                    </div>

                    <div class="iconBx">
                        <i class="icon-tag"></i>
                    </div>
                    </a>
                </div>

                <div class="card">
                    <a href="requests.php">
                    <div>
                        <div class="numbers">
                            <?php 
                             $statement =$con->prepare("SELECT id  FROM requests");
                             $statement->execute(array());
                             $counter = $statement->rowCount();
                             echo $counter;
                            ?>
                        </div>
                        <div class="cardName">Requests</div>
                    </div>

                    <div class="iconBx">
                    <i class="icon-bell"></i>
                    </div>
                    </a>
                </div>

                <div class="card">
                    <a href="users.php">
                    <div>
                        <div class="numbers">
                        <?php 
                             $statement =$con->prepare("SELECT id  FROM clients");
                             $statement->execute(array());
                             $counter = $statement->rowCount();
                             echo $counter;
                        ?>
                        </div>
                        <div class="cardName">Users</div>
                    </div>

                    <div class="iconBx">
                        <i class="icon-users"></i>
                    </div></a>
                </div>

                <div class="card">
                <a href="#">
                    <div>
                        <div class="numbers">
                        <?php 
                            $amount = 0;
                             $statement =$con->prepare("SELECT product_id  FROM Products WHERE amount = 0");
                             $statement->execute(array());
                             $counter = $statement->rowCount();
                             echo $counter;
                        ?>
                        </div>
                        <div class="cardName">Empty products</div>
                    </div>

                    <div class="iconBx">
                        <i class="icon-shopping-cart"></i>
                    </div>
                </a>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                        <div><div class="div"></div>
                        <input type="text" id="searchInput" placeholder="Search here" onclick="filterTable()">
                        <a href="#" class="btn"><i class="icon-search"></i></a></div>
                    
                    </div>
                    <table >
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Number</td>
                                <td>Controls</td>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php 
                            $statement = $con-> prepare("SELECT * FROM clients");
                            $statement->execute();
                            $statement = $statement->fetchAll();
                            foreach ($statement as $row) {
                                echo'<tr>';
                                echo'<td>'.$row['name'].'</td>';
                                echo'<td>'.$row['email'].'</td>';
                                echo'<td>'.$row['number'].'</td>';
                                echo'<td class="controls">
                                <a href="?do=EditClient&id='.$row['id'].'" title="Edit"><i class="icon-user-plus"></i></a>
                                <a href="?do=DeleteClient&id='.$row['id'].'"title="Delete"><i class="icon-user-minus"></i></a>
                                <a href="?do=ActiveClient&id='.$row['id'].'"title="Active"><i class="icon-user-check"></i></a>
                                <a href="?do=NonActiveClient&id='.$row['id'].'"title="NActive"><i class="icon-user-x"></i></a>
                                </td>';
                            }?>
                        </tbody>
                    </table>
            </div>
                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Products</h2>
                        <div><div class="div"></div>
                        <a href="?do=InsertProduct" class="btn"><i class="icon-plus"></i></a>
                        </div>
                    </div>
                    <table>
                        <thead><tr>
                            <td>Image</td>
                            <td>Title</td>
                            <td>Price</td>
                            <td>Amount</td>
                            <td>Controls</td>
                        </tr></thead>
                        <tbody>
                    <?php 
                            $statement = $con-> prepare("SELECT * FROM products");
                            $statement->execute();
                            $statement = $statement->fetchAll();
                            foreach ($statement as $row) {
                                echo'<tr><td width="60px">';
                                echo'<div class="imgBx"><img src="../image/'.$row['img'].'" alt=""></div></td>';
                                echo'<td><h4>'.$row['title'].'</h4></td>';
                                echo'<td>'.$row['price'].'</td>';
                                echo'<td>'.$row['amount'].'</td>';
                                echo'<td class="controls">
                                <a href="?do=EditProduct&id='.$row['product_id'].'" title="Edit"><i class="icon-edit-3"></i></a>
                                <a href="?do=DeleteProduct&id='.$row['product_id'].'"title="Delete"><i class="icon-trash"></i></a>
                                </td></tr>';
                            }?>
                        </tbody>
                           </table>
                </div>
            </div>
        </div>
    </div>
    <?php
                    // Delete Action [Client]
                    if (isset($_GET["do"]) && $_GET["do"] == "DeleteClient") {
                        if (isset($_GET["id"])) {
                            $clientId = $_GET["id"];
                            $statement = $con->prepare("DELETE FROM clients WHERE id = :id");
                            $statement->bindParam(':id', $clientId);
                            $statement->execute();
                            // Redirect to the current page to reload
                            header("Location: {$_SERVER['PHP_SELF']}");
                            exit();
                        }
                    }
                    // Edit Action [Client]
                    if (isset($_GET["do"]) && $_GET["do"] == "EditClient") {
                        if (isset($_GET["id"])) {
                            $clientId = $_GET["id"];
                            $statement = $con->prepare("SELECT * FROM clients WHERE id = :id");
                            $statement->bindParam(':id', $clientId);
                            $statement->execute();
                            $client = $statement->fetch(PDO::FETCH_ASSOC);
                            
                            // Display edit form
                            echo '<form class="form" id="FormEdit" action="'.$_SERVER['PHP_SELF'].'?do=EditClient&id='.$clientId.'" method="POST">';
                            echo '<i id="iconX" class="icon-x"></i>';
                            echo '<div class="group" style="display:;">';
                            echo '<input type="text" name="name" value="'.$client["name"].'" style="display: ;">';
                            echo '<input type="text" name="email" value="'.$client["email"].'" style="display: ;">';
                            echo '<input type="text" name="number" value="'.$client["number"].'" style="display: ;">';
                            echo '</div>';
                            echo '<div class="group">';
                            echo '<div class="buttons">';
                            echo '<button id="addItem">Edit</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</form><div class="cashX" id="cash"></div>';
                             // Check if form is submitted
                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Update client information
                                $name = $_POST['name'];
                                $email = $_POST['email'];
                                $number = $_POST['number'];
                                $stat = 1;
                                    $updateStatement = $con->prepare("UPDATE clients SET name = :name, email = :email, number = :number, stat = :stat WHERE id = :id");
                                    $updateStatement->bindParam(':name', $name);
                                    $updateStatement->bindParam(':email', $email);
                                    $updateStatement->bindParam(':number', $number);
                                    $updateStatement->bindParam(':stat', $stat);
                                    $updateStatement->bindParam(':id', $clientId);
                                    $updateStatement->execute();
                                    echo "Client information updated successfully.";
                                    // Redirect to the current page to reload
                                    header("Location: {$_SERVER['PHP_SELF']}");
                                    exit();
                            };
                        };
                    };
                    // Active Action [Client]
                    if (isset($_GET["do"]) && $_GET["do"] == "ActiveClient") {
                        if (isset($_GET["id"])) {
                            $clientId = $_GET["id"];
                            // Prepare and execute the update statement
                                $updateStatement = $con->prepare("UPDATE clients SET stat = 1 WHERE id = :id");
                                $updateStatement->bindParam(':id', $clientId);
                                $updateStatement->execute();
                                // Redirect to the current page to reload
                                header("Location: {$_SERVER['PHP_SELF']}");
                                exit();
                        }
                    }
                    // Non Active Action [Client]
                    if (isset($_GET["do"]) && $_GET["do"] == "NonActiveClient") {
                        if (isset($_GET["id"])) {
                            $clientId = $_GET["id"];
                            // Prepare and execute the update statement
                                $updateStatement = $con->prepare("UPDATE clients SET stat = 0 WHERE id = :id");
                                $updateStatement->bindParam(':id', $clientId);
                                $updateStatement->execute();
                                // Redirect to the current page to reload
                                header("Location: {$_SERVER['PHP_SELF']}");
                                exit();
                        }
                    }
                    // Delete Action [Product]
                    if (isset($_GET["do"]) && $_GET["do"] == "DeleteProduct") {
                        if (isset($_GET["id"])) {
                            $productId = $_GET["id"];
                            // Delete Product 
                            $statement = $con->prepare("DELETE FROM products WHERE product_id = :id");
                            $statement->bindParam(':id', $productId);
                            $statement->execute();

                            $statement = $con->prepare("DELETE FROM requests WHERE product_id = :id");
                            $statement->bindParam(':id', $productId);
                            $statement->execute();
                           // Redirect to the current page to reload
                            header("Location: {$_SERVER['PHP_SELF']}");
                            exit();
                        }
                    }
                    // Edit Action [Product]
                    if (isset($_GET["do"]) && $_GET["do"] == "EditProduct") {
                        if (isset($_GET["id"])) {
                            $productId = $_GET["id"];
                            $statement = $con->prepare("SELECT * FROM products WHERE product_id = :id");
                            $statement->bindParam(':id', $productId);
                            $statement->execute();
                            $product = $statement->fetch(PDO::FETCH_ASSOC);
                            
                            // Display edit form
                            echo '<form class="form form-edit" id="FormEdit" action="'.$_SERVER['PHP_SELF'].'?do=EditProduct&id='.$productId.'" method="POST">';
                            echo '<i id="iconX" class="icon-x"></i>';
                            echo '<div class="product-img">
                            <div><img src="../image/'.$product["img"].'" ><h6>Old Image</h6></div>
                            <div><div id="newImg"></div><h6>New Image</h6></div>
                            </div>';
                            echo '<div class="group" style="display:;">';
                            echo '<input type="file" name="img" id="imgInput" value="'.$product["img"].'" placeholder="IMG">';
                            echo '<input type="text" name="title" value="'.$product["title"].'" placeholder="Titre">';
                            echo '<input type="text" name="description" value="'.$product["description"].'" placeholder="Description">';
                            echo '<input type="text" name="price" value="'.$product["price"].'" placeholder="Prix">';
                            echo '<input type="text" name="amount" value="'.$product["amount"].'" placeholder="Quantiter">';
                            echo '</div>';
                            echo '<div class="group">';
                            echo '<div class="buttons">';
                            echo '<button id="addItem">Edit Product</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</form><div class="cashX" id="cash"></div>';
                        }
                    }
                    // Check if form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["do"]) && $_GET["do"] == "EditProduct") {
                        if (isset($_POST["title"]) && isset($_POST["img"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["amount"])) {
                            $title = $_POST['title'];
                            $img = $_POST['img'];
                            $price = $_POST['price'];
                            $description = $_POST['description'];
                            $amount = $_POST['amount'];
                            
                            // Update Product information
                            $updateStatement = $con->prepare("UPDATE products SET img = :img, title = :title, price = :price, amount = :amount, description = :description WHERE product_id = :id");
                            $updateStatement->bindParam(':title', $title);
                            $updateStatement->bindParam(':img', $img);
                            $updateStatement->bindParam(':price', $price);
                            $updateStatement->bindParam(':amount', $amount);
                            $updateStatement->bindParam(':description', $description);
                            $updateStatement->bindParam(':id', $productId);
                            $updateStatement->execute();
                            echo "Product information updated successfully.";
                            // Redirect to the current page to reload
                            header("Location: {$_SERVER['PHP_SELF']}");
                            exit();
                        } else {
                            // Redirect to the current page to reload
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                        }
                    }
                   // Insert Action [Product]
                   if (isset($_GET["do"]) && $_GET["do"] == "InsertProduct") {
                        // Display edit form
                        echo '<form class="form form-edit" id="FormEdit" action="'.$_SERVER['PHP_SELF'].'?do=InsertProduct" method="POST">';
                        echo '<i id="iconX" class="icon-x"></i>';
                        echo '<div class="product-img">
                        <div><div id="newImg"></div><h6>New Image</h6></div>
                        </div>';
                        echo '<div class="group" style="display:;">';
                        echo '<input type="file" name="img" id="imgInput" value="">';
                        echo '<input type="text" name="title" value="" placeholder="Titre">';
                        echo '<input type="text" name="description" value="" placeholder="Description">';
                        echo '<input type="text" name="price" value="" placeholder="Prix">';
                        echo '<input type="text" name="amount" value="" placeholder="Quantiter">';
                        echo '</div>';
                        echo '<div class="group">';
                        echo '<div class="buttons">';
                        echo '<button id="addItem">Edit Product</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form><div class="cashX" id="cash"></div>';
                    }
                // Check if form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["do"]) && $_GET["do"] == "InsertProduct") {
                    if (isset($_POST["title"]) && isset($_POST["img"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["amount"])) {
                        $title = $_POST['title'];
                        $img = $_POST['img'];
                        $price = $_POST['price'];
                        $description = $_POST['description'];
                        $amount = $_POST['amount'];
                        
                        // Insert Product information into the database
                        $Statement = $con->prepare("INSERT INTO products (title, img, description, price, amount) VALUES (:title, :img, :description, :price, :amount)");
                        $Statement->bindParam(':title', $title);
                        $Statement->bindParam(':img', $img);
                        $Statement->bindParam(':description', $description);
                        $Statement->bindParam(':price', $price);
                        $Statement->bindParam(':amount', $amount);
                        $Statement->execute();
                        // Redirect to the current page to reload
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                    } else {
                        // Redirect to the current page to reload
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                    }
                };
                                     ?>
    <?php
    include('./footer/footer.php')
     ?>
</body>
</html>
<?php 

}else{
    header("Location:./index.php");
    exit();
}
ob_end_flush();
?>
<?php
include('./header/header.php');
?>
<div class="details-products">
    <div class="products">
                    <div class="cardHeader">
                        <h2>Products</h2>
                        <div class="div"></div>
                        <a href="?do=InsertProduct" class="btn"><i class="icon-plus"></i></a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Title</td>
                                <td>Price</td>
                                <td>Amount</td>
                                <td>Controls</td>
                            </tr>
                        </thead>
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
                                echo'<td>'.$row['description'].'</td>';
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
<?php 
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
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo "Please fill in all fields.";
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
                // echo "Product information Inserted successfully.";
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            } else {
                echo "Please fill in all fields.";
            }
            }
include('./footer/footer.php');
?>
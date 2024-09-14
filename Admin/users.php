<?php
include('./header/header.php');
?>
            <div class="details-users">
            <div class="users">
                <div class="cardHeader" id="1">
                        <h2>Recent Orders</h2>
                        <div class="search">
                        <input type="text" id="searchInput" placeholder="Search here">
                        <a href="#" class="btn"><i class="icon-search"></i></a>
                    </div>
                    </div>
                    <table>
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
                                <a href="?do=NonActiveClient&id='.$row['id'].'"title="NActive"><i class="icon-user-x"></i></a>                                </td>';
                            }?>
                        </tbody>
                    </table>
                    </div>
            </div>
            <?php
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
                    // Delete Action [Client]
                    if (isset($_GET["do"]) && $_GET["do"] == "DeleteClient") {
                        if (isset($_GET["id"])) {
                            $clientId = $_GET["id"];
                            $statement = $con->prepare("DELETE FROM clients WHERE id = :id");
                            $statement->bindParam(':id', $clientId);
                            $statement->execute();
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
                                header("Location: {$_SERVER['PHP_SELF']}");
                                exit();
                        }
                    }
                    include('./footer/footer.php')
                                     ?>
<?php 
include('./header/header.php');
?>
<div class="details-products">
    <div class="products">
                    <div class="cardHeader">
                        <h2>Products</h2>
                        <div class="div"></div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Title</td>
                                <td>Client Name</td>
                                <td>Client Email</td>
                                <td>Client Number</td>
                                <td>Price</td>
                                <td>Amount</td>
                                <td>Message</td>
                                <td>Stat</td>
                            </tr>
                        </thead>
                        <tbody>
                    <?php 
                            $statement = $con-> prepare("SELECT * FROM requests");
                            $statement->execute();
                            $statement = $statement->fetchAll();
                            foreach ($statement as $row) {
                                echo'<tr>';
                                echo'<td width="60px"><div class="imgBx"><img src="../image/'.$row['img'].'" alt=""></div></td>';
                                echo'<td>'.$row['title'].'</td>';
                                echo'<td>'.$row['client_name'].'</td>';
                                echo'<td>'.$row['client_email'].'</td>';
                                echo'<td>'.$row['client_number'].'</td>';
                                echo'<td>'.$row['price'].'</td>';
                                echo'<td>'.$row['amount'].'</td>';
                                echo'<td>'.$row['comment'].'</td>';
                                echo'<td>';
                                if ($row['stat'] == 1) {
                                    echo '<span><i class="icon-check-circle"></i></span>';
                                }else{
                                    echo '<span><i class="icon-clock"></i></span>';        
                                }
                            }
                            
                            
                             // Delete Action
            if (isset($_GET["do"]) && $_GET["do"] == "Delete") {                
                 // Delete all requests associated with the client
                 $statement = $con->prepare("DELETE FROM requests WHERE client_id = ?");
                 $statement->execute();
                 // Redirect to the current page to reload
                 header("Location: {$_SERVER['PHP_SELF']}");
                 exit();
                };
                            ?>
                        </tbody>
                           </table>
    </div>
</div>


<?php 
include('./footer/footer.php')
?>
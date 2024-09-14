<?php
    	include 'config.php';
        session_start();
        if(isset($_SESSION['user_email'])){
            $client_email = $_SESSION['user_email'];
            $statement = $con-> prepare("SELECT * FROM clients WHERE email = :email");
            $statement->execute(array(':email' => $client_email));
            $client_data = $statement->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./Css/invoice.css">
    <link rel="stylesheet" href="./Css/style.css">
    <title>Facture</title>
</head>
<body>
    <div class="logo">
    <img src="../logo.png" alt="">
    </div>
    <h2>Facture</h2>
    <?php        
    // Fetch user information (assuming it's stored in $client_data)
    $client_name = $client_data['name']; // Adjust this according to your data structure

    // Fetch requests associated with the client
    $cart_requests = $client_data['id'];
    $statement = $con->prepare("SELECT * FROM requests WHERE client_id = ?");
    $statement->execute([$cart_requests]);
    $requests = $statement->fetchAll();

    // Initialize variables for total price and date of the invoice
    $totalPrice = 0;
    $invoiceDate = date('Y-m-d'); // Current date, you can customize this

    // Display user information
    echo "<p><strong>Client Name:</strong> $client_name</p>";

    // Display invoice table header
    echo "<table>";
    echo "<tr><th>Product Title</th><th>Price</th><th>Number of Requests</th></tr>";

    // Iterate through requests to display product details
    foreach ($requests as $request) {
        $product_title = $request['title'];
        $price = $request['price'];
        $num_requests = $request['amount'];

        // Calculate total price for this product
        $productTotal = $price * $num_requests;
        $totalPrice += $productTotal;

        // Display product details in the table
        echo "<tr>";
        echo "<td>$product_title</td>";
        echo "<td>$price</td>";
        echo "<td>$num_requests</td>";
        echo "</tr>";
    }

    // Display total price and date of the invoice
    echo "<tr><td colspan='2'><strong>Total Price:</strong></td><td>$totalPrice</td></tr>";
    echo "<tr><td colspan='2'><strong>Date of Invoice:</strong></td><td>$invoiceDate</td></tr>";
    echo "</table>";
    echo "<button type='submit' onclick='printPage()'><i class='icon-printer'></i></button>";
    ?>

<script>
        function printPage() {
            window.print();
        }
</script>
</body>
</html>
<?php
}else{
    echo 'You cant browse this page directory';
}?>

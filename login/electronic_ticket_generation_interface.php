<!-- electronic_ticket_generation_interface.php -->

<?php
session_start();

// Check if the payment was successful
if (!isset($_SESSION['payment_success']) || !$_SESSION['payment_success']) {
    // Redirect to the credit card information page if payment was not successful
    header("Location: credit_info.php");
    exit();
}

// Placeholder function for generating electronic tickets
function generateElectronicTickets($cart) {
    
    $tickets = [];

    foreach ($cart as $ticket) {
        $tickets[] = [
            'name' => $ticket['name'],
            'quantity' => $ticket['quantity'],
            'total_amount' => $ticket['price'] * $ticket['quantity'],
            'confirmation_number' => uniqid(),
        ];
    }

    return $tickets;
}

// Check if the 'cart' session variable exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Your database credentials
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "demo"; // Replace with your actual database name
$deport = 3308;

// Create a connection to the database
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $deport);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your purchase information retrieval logic here (adjust as needed)
$sql = "SELECT * FROM purchase ORDER BY purchase_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $purchase = $result->fetch_assoc();
    $purchaseDate = $purchase['purchase_date'];
    $totalPrice = $purchase['total_price'];

    // Generate electronic tickets
    $electronicTickets = generateElectronicTickets($cart);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here (e.g., title, stylesheets) -->
</head>
<body>
    <!-- Your HTML content for displaying electronic tickets goes here -->

    <h2>Electronic Ticket Generation Interface</h2>

    <?php
    if (!empty($electronicTickets)) {
        echo '<h3>Your Electronic Tickets</h3>';

        foreach ($electronicTickets as $ticket) {
            echo '<div class="ticket">';
            echo '<p>Ticket: ' . $ticket['name'] . '</p>';
            echo '<p>Quantity: ' . $ticket['quantity'] . '</p>';
            echo '<p>Total Amount: $' . $ticket['total_amount'] . '</p>';
            echo '<p>Confirmation Number: ' . $ticket['confirmation_number'] . '</p>';
            echo '</div>';
        }

        echo '<p>Total Purchase Amount: $' . $totalPrice . '</p>';
        echo '<p>Purchase Date: ' . $purchaseDate . '</p>';
    } else {
        echo '<p>No electronic tickets available.</p>';
    }
    ?>

    <!-- Add your scripts if needed -->

</body>
</html>

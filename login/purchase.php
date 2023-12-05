
<?php
session_start();

// Placeholder function for fake payment processing
function processPayment($creditCardInfo) {
    
    // Hardcoded credit card information for testing (replace with your actual data)
    $storedCreditCard = [
        'number' => '1234567890123456',
        'expiration' => '12/23',
        'cvv' => '123',
        'cardholder' => 'John Doe', // Updated with cardholder's name
    ];

    // Check if provided credit card information matches the stored information
    return (
        $creditCardInfo['number'] === $storedCreditCard['number'] &&
        $creditCardInfo['expiration'] === $storedCreditCard['expiration'] &&
        $creditCardInfo['cvv'] === $storedCreditCard['cvv'] &&
        $creditCardInfo['cardholder'] === $storedCreditCard['cardholder']
    );
}

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

// Handle form submission for payment processing
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve payment information from the form
    $cardNumber = isset($_POST['cardNumber']) ? $_POST['cardNumber'] : "";
    $cardHolder = isset($_POST['cardHolder']) ? $_POST['cardHolder'] : "";
    $expirationDate = isset($_POST['expirationDate']) ? $_POST['expirationDate'] : "";
    $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";

    // Validate payment information
    if (empty($cardNumber) || empty($cardHolder) || empty($expirationDate) || empty($cvv)) {
        echo '<div class="alert alert-danger mt-3" role="alert">Please fill in all the required fields.</div>';
    } else {
        // Process payment
        $paymentInfo = [
            'number' => $cardNumber,
            'expiration' => $expirationDate,
            'cvv' => $cvv,
            'cardholder' => $cardHolder,
        ];

        if (processPayment($paymentInfo)) {
            // Payment successful, redirect to the electronic ticket generation page
            $_SESSION['payment_success'] = true;
            header("Location: electronic_ticket_generation_interface.php");
            exit();
        } else {
            // Payment failed, display an error message
            echo '<div class="alert alert-danger mt-3" role="alert">Payment failed. Please check your payment information and try again.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Credit Card Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
    <div class="container mt-5">
        <h2>Credit Card Information</h2>

        <!--  collecting credit card information  -->
        <form method="post" action="">
            <div class="form-group">
                <label for="cardNumber">Card Number:</label>
                <input type="text" name="cardNumber" id="cardNumber" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="cardHolder">Cardholder Name:</label>
                <input type="text" name="cardHolder" id="cardHolder" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="expirationDate">Expiration Date:</label>
                <input type="text" name="expirationDate" id="expirationDate" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" name="cvv" id="cvv" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Proceed to Electronic Ticket Generation</button>
        </form>

        <!-- Add your scripts if needed -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

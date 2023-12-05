<?php

function generateAutoNumbers() {
    $autoSelectedNumbers = [];

    // Generate five unique random numbers between 1 and 50
    while (count($autoSelectedNumbers) < 5) {
        $randomNumber = rand(1, 50);

        // Ensure the number is not already in the array
        if (!in_array($randomNumber, $autoSelectedNumbers)) {
            $autoSelectedNumbers[] = $randomNumber;
        }
    }

    return $autoSelectedNumbers;
}
// Start the session to access cart information
session_start();

// Check if the 'cart' session variable exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Replace these database credentials with your actual credentials
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "demo"; // Replace with your actual database name
$deport = 3308;

// Create a connection to the database
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $deport);
$autoSelect = isset($_POST['autoSelect']) && $_POST['autoSelect'] == 1;
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding tickets to the cart
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and process ticket information
    $ticketId = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0; // Ensure the quantity is an integer

    // Check if auto-select is enabled
   

    // Array to store manually selected numbers
    $manualNumbers = [];

    // If auto-select is not enabled, get manually selected numbers
    if (!$autoSelect) {
        if ($autoSelect) {
            $autoSelectedNumbers = generateAutoNumbers();
            echo '<div class="auto-selected-numbers">Auto-selected Numbers: ' . implode(', ', $autoSelectedNumbers) . '</div>';
        }
    }

    // Check if essential information is provided
    if ($ticketId !== null) {
        // Retrieve ticket information from the database
        $sql = "SELECT id, name, drawing_date, price, potential_winnings FROM tickets WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Create an array to represent the ticket with quantity
            $ticket = [
                'id' => $row['id'],
                'name' => $row['name'],
                'drawing_date' => $row['drawing_date'],
                'price' => $row['price'],
                'potential_winnings' => $row['potential_winnings'],
               
            ];

            // If the cart is empty or the ticket is not in the cart, add the ticket
            if (empty($cart) || !in_array($ticket, $cart)) {
                // Add the ticket to the cart
                $_SESSION['cart'][] = $ticket;
                $ticket['quantity'] = $quantity;
                // Provide feedback to the user
                echo '<div class="alert alert-success" role="alert">';
                echo 'Ticket added to the cart successfully.';
                echo '</div>';
            } else {
                // Provide feedback that the ticket is already in the cart
                echo '<div class="alert alert-warning" role="alert">';
                echo 'Ticket is already in the cart.';
                echo '</div>';
            }
        } else {
            // Handle the case where ticket information is not found
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Ticket information not found. Please try again.';
            echo '</div>';
        }

        $stmt->close();
    } else {
        // Handle the case where essential information is not provided
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Essential information is not provided. Please try again.';
        echo '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ticket Purchase Interface</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            padding-top: 80px; /* Add padding to the top of the body to accommodate the fixed navbar */
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .auto-selected-numbers {
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a href="index.html" class="navbar_brand mb-0 h1">
            <img src="Texas_Lottery-logo-.png" width="80" height="80" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="tickets.php" class="nav-link">Browse Lottery Tickets</a>
                </li>
                <li class="nav-item active">
                    <a href="winning_numbers.html" class="nav-link">Browse Previous Winning Numbers</a>
                </li>
                <li class="nav-item active">
                    <a href="profile.html" class="nav-link">Profile</a>
                </li>
                <li class="nav-item active">
                    <a href="orderhistory.html" class="nav-link">Order History</a>
                </li>
                <li class="nav-item active">
                    <a href="search.html" class="nav-link">Search for a Specific Ticket</a>
                </li>
                <li class="nav-item active">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input type="search" class="form-control mr-sm-2" placeholder="Search for Tickets" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Ticket Purchase Interface</h2>

        <?php
        if (!empty($cart)) {
            echo '<form action="ticket_purchase_interface.php" method="post">';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">Ticket Name</th>';
            echo '<th scope="col">Price</th>';
            echo '<th scope="col">Quantity</th>'; // Add a new column for quantity
            // Add more columns as needed
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($cart as $ticket) {
                echo '<tr>';
                echo '<td>' . $ticket['name'] . '</td>';
                echo '<td>$' . $ticket['price'] . '</td>';
                echo '<td>' . $ticket['quantity'] . '</td>'; // Display the quantity
                // Add more columns as needed
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Add form elements for quantity, lottery numbers, and payment information
            echo '<div class="form-group">';
            echo '<label for="quantity">Quantity (max 10):</label>';
            echo '<input type="number" name="quantity" id="quantity" class="form-control" min="1" max="10" required>';
            echo '</div>';

            // Checkbox for auto-select numbers
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" value="1" name="autoSelect" id="autoSelect">';
            echo '<label class="form-check-label" for="autoSelect">Auto-select numbers</label>';
            echo '</div>';

            // Display input fields for manual selection
            for ($i = 1; $i <= 5; $i++) {
                echo '<label for="number' . $i . '">Number ' . $i . ':</label>';
                echo '<input type="number" name="manualNumbers[]" id="number' . $i . '" class="form-control" min="1" max="50" required>';
            }

            echo '<button type="submit" class="btn btn-primary">Proceed to Payment</button>';
            echo '</form>';
           
            echo '<script>';
            echo 'document.getElementById("purchaseForm").addEventListener("submit", function() {';
            echo '    window.location.href = "purchase.php";';
            echo '});';
            echo '</script>';


        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>

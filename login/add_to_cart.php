<?php
// Start the session to store cart information
session_start();

// Check if the ticket ID is provided
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ticket_id = $_GET['id'];
    
    // Fetch ticket details based on the ID (similar to ticket_details.php)
    // Replace these database credentials with your actual credentials
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "demo";
    $deport = 3308;

    // Create a connection to the database
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $deport);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch ticket details from the database based on the ID
    $sql = "SELECT * FROM tickets WHERE id = $ticket_id";
    $result = $conn->query($sql);

    // Check if the ticket is found
    if ($result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
        
        // Add the ticket to the cart (assuming a session variable 'cart' exists)
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $_SESSION['cart'][] = [
            'id' => $ticket['id'],
            'name' => $ticket['name'],
            'price' => $ticket['price'],
            // Add more details as needed
        ];

        // Redirect to the Ticket Purchase Interface
        header("Location: ticket_purchase_interface.php");
        exit();
    } else {
        // If the ticket is not found, redirect to tickets.php
        header("Location: tickets.php");
        exit();
    }
} else {
    // If the ticket ID is not provided, redirect to tickets.php
    header("Location: tickets.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add to Cart</title>
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
        <h2>Add to Cart</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $ticket['name']; ?></h5>
                <p class="card-text">Price: $<?php echo $ticket['price']; ?></p>
                <!-- Add more details as needed -->

                <form action="add_to_cart.php?id=<?php echo $ticket['id']; ?>" method="post">
                    <label for="quantity">Quantity:</label>
                    <select name="quantity" id="quantity" class="form-control" required>
                        <?php
                        // Display options for quantity (adjust as needed)
                        for ($i = 1; $i <= 10; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>

                    <label for="lottery_numbers">Lottery Numbers:</label>
                    <input type="text" name="lottery_numbers" id="lottery_numbers" class="form-control" placeholder="Enter lottery numbers">

                    <!-- Add more input fields for payment information -->

                    <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
                </form>
            </div>
        </div>
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

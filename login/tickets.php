<?php
// Assuming you have a database connection established
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Browse Lottery Tickets</title>
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

        .ticket {
            margin-bottom: 20px;
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
        <h2>Browse Lottery Tickets</h2>

        <?php
        // Query to fetch ticket data from the database
        $sql = "SELECT id, name FROM tickets";
        $result = $conn->query($sql);

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            // Fetch data and display tickets
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card ticket">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                echo '<a href="ticket_details.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>';
                echo '<a href="add_to_cart.php?id=' . $row['id'] . '" class="btn btn-success ml-2">Add to Cart</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No tickets found.";
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

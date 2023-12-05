<?php
session_start();

// Other PHP code and HTML content below
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            padding-top: 50px; /* Add some padding to the top of the body to accommodate the fixed navbar */
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .content {
            margin-top: 80px; /* Add margin to the content to prevent it from being hidden behind the fixed navbar */
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

    <div class="container content">
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

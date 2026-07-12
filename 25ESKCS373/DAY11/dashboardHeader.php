<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$headerUserFile = 'profile.jpg';
if (!empty($_SESSION['user_id'])) {
    include_once('db_connect.php');
    $headerUserId = intval($_SESSION['user_id']);
    $headerResult = mysqli_query($conn, "SELECT myFile FROM user WHERE id = $headerUserId");
    if ($headerResult) {
        $headerRow = mysqli_fetch_assoc($headerResult);
        if (!empty($headerRow['myFile'])) {
            $headerUserFile = $headerRow['myFile'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my website</title>
    

    <!-- bootstrap css -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">

            <!-- logo -->
             <img src="https://www.vhv.rs/dpng/d/549-5499076_hd-logo-design-transparent-background-hd-png-download.png" alt="Logo" class="logo-img" style="width: 80px; height: 50px;">
                    <div class="logo">
                    <h1 class="m-0">My Website</h1>
                </div>
                <!-- navigation menu -->
                    <ul class="nav">
                        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                        <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
                        <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                    </ul>
                </nav>
                <!-- profile button -->
                <a href="profile.php" class="btn btn-primary" style="background-color: white; border-color: white; color: black;">
                    <img src="<?php echo htmlspecialchars($headerUserFile); ?>" alt="Profile" class="img-fluid" style="width:32px;height:32px;object-fit:cover;border-radius:50%;">
                </a>
                <!-- logout button -->
                <a href="logout.php"><button type="button" class="btn btn-primary">Log Out </button></a>
            </div>
        </div>
    </header>

<?php 
include ('db_connect.php');
$error = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
        echo $error;
    } else {
        $selectQuery = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        if ($user && $user['password'] === $password) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['username'] ?? $user['name'] ?? '';
            $_SESSION['username'] = $user['username'] ?? $user['name'] ?? $user['email'] ?? '';
            $_SESSION['user_file'] = $user['myFile'] ?? '';
            if($user['role'] == 'admin') {
                    header("Location: adminDashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
            exit();
        } else {
            echo "Invalid email or password.";
            echo "Error: " . mysqli_error($conn);
        }
    }
}

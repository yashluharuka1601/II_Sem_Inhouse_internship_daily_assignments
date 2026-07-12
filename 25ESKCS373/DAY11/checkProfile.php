<?php 

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include ('db_connect.php');

$name = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    if (empty($name) && empty($email) && empty($_FILES["myFile"]["name"])) {
        echo "Please fill in at least one field.";
    } else {
        if (empty($_SESSION['user_id'])) {
            echo "User session not found.";
        } else {
            $user_id = intval($_SESSION['user_id']);

            $selectQuery = "SELECT * FROM user WHERE id = $user_id";
            $result = mysqli_query($conn, $selectQuery);
            $user = mysqli_fetch_assoc($result);

            $name_safe = empty($name) ? $user['username'] : mysqli_real_escape_string($conn, $name);
            $email_safe = empty($email) ? $user['email'] : mysqli_real_escape_string($conn, $email);
            $file_safe = $user['myFile'];

            if (!empty($_FILES["myFile"]["name"])) {
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }
                $uploadPath = "uploads/" . basename($_FILES["myFile"]["name"]);
                if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $uploadPath)) {
                    $file_safe = mysqli_real_escape_string($conn, $uploadPath);
                } else {
                    echo "Failed to upload profile image.";
                }
            }

            $updateQuery = "UPDATE user SET username = '$name_safe', email = '$email_safe', myFile = '$file_safe' WHERE id = $user_id";
            mysqli_query($conn, $updateQuery);

            $_SESSION['user_name'] = $name_safe;
            $_SESSION['user_email'] = $email_safe;
            $_SESSION['user_file'] = $file_safe;

            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

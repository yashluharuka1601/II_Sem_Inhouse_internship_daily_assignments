<?php
include ('db_connect.php');
session_start();
$error = "";
$name = $email = $password = $confirm_password = "";
if ( $_SERVER["REQUEST_METHOD"] == "POST"){

$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);
$confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);


if ($username == "" || $email == "" || $password == "" || $confirm_password == ""){
$error = "All fields are required.";
echo $error;
} else {
if ($password !== $confirm_password) {
$error = "Passwords do not match.";
echo $error;
} else {
$safe_password = mysqli_real_escape_string($conn, $password);
$sql = "INSERT INTO `user` (`id`, `username`, `email`, `password`, `time`) VALUES (NULL, '$username', '$email', '$safe_password', current_timestamp())";


if (mysqli_query($conn, $sql)) {
    $_SESSION['user_id'] = mysqli_insert_id($conn);
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $username;
    $_SESSION['username'] = $username;

    echo "New record created successfully";
} else {

echo "Error: " . $sql . "<br>" . mysqli_error($conn);

}
header("Location: success.php");
exit();
}
}
}
?>

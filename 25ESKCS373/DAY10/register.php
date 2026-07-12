<?php
session_start();

include "db_connect.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $college  = trim($_POST['college']);
    $branch   = trim($_POST['branch']);

    if (empty($name) || empty($email) || empty($password) || empty($college) || empty($branch)) {

        $error = "Please fill all fields.";

    } elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters.";

    } else {

        // Check email
        $stmt = mysqli_prepare($conn, "SELECT id FROM students WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {

            $error = "Email already registered.";

        } else {

            $stmt = mysqli_prepare($conn,
            "INSERT INTO students(name,email,password,college,branch)
            VALUES(?,?,?,?,?)");

            mysqli_stmt_bind_param(
                $stmt,
                "sssss",
                $name,
                $email,
                $password,
                $college,
                $branch
            );

            if (mysqli_stmt_execute($stmt)) {

                $success = "Registration Successful!";

            } else {

                $error = "Registration Failed.";

            }
        }

        mysqli_stmt_close($stmt);
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#0d6efd,#4e73df);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.register-box{

    width:500px;
    background:white;
    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,.3);
    overflow:hidden;

}

.header{

    background:#0d6efd;
    color:white;
    text-align:center;
    padding:25px;

}

.form-control{

    border-radius:10px;

}

.btn-register{

    border-radius:10px;
    font-weight:bold;

}

.footer{

    text-align:center;
    color:#777;
    padding:15px;

}

</style>

</head>

<body>

<div class="register-box">

<div class="header">

<h2>🎓 Student Registration</h2>

<p class="mb-0">
Student Management System
</p>

</div>

<div class="p-4">

<?php
if($error!=""){
?>

<div class="alert alert-danger">
<?= htmlspecialchars($error); ?>
</div>

<?php
}
?>

<?php
if($success!=""){
?>

<div class="alert alert-success">

<?= htmlspecialchars($success); ?>

<br><br>

<a href="login.php" class="btn btn-success btn-sm">
Go to Login
</a>

</div>

<?php
}
?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Full Name
</label>

<input
type="text"
name="name"
class="form-control"
required
value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

</div>

<div class="mb-3">

<label class="form-label">
Email Address
</label>

<input
type="email"
name="email"
class="form-control"
required
value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

</div>

<div class="mb-3">

<label class="form-label">
Password
</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
College
</label>

<input
type="text"
name="college"
class="form-control"
required
value="<?= htmlspecialchars($_POST['college'] ?? '') ?>">

</div>

<div class="mb-3">

<label class="form-label">
Branch
</label>

<input
type="text"
name="branch"
class="form-control"
required
value="<?= htmlspecialchars($_POST['branch'] ?? '') ?>">

</div>

<button class="btn btn-primary w-100 btn-register">

Register

</button>

</form>

<hr>

<div class="text-center">

Already have an account?

<a href="login.php">

Login Here

</a>

</div>

</div>

<div class="footer">

© 2026 Student Management System

</div>

</div>

</body>
</html>

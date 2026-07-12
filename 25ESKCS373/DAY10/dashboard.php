<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db_connect.php";

// Total students
$countQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$totalStudents = mysqli_fetch_assoc($countQuery)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f7fc;
}

.navbar{
    background:linear-gradient(90deg,#0d6efd,#4e73df);
}

.dashboard-title{
    font-weight:bold;
    color:#0d6efd;
}

.card{
    border:none;
    border-radius:15px;
}

.card:hover{
    transform:translateY(-5px);
    transition:.3s;
}

.table th{
    background:#0d6efd;
    color:white;
}

footer{
    background:#212529;
    color:white;
}

.badge-branch{
    background:#20c997;
}

.badge-email{
    background:#6c757d;
}
</style>

</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark shadow">
<div class="container">

<a class="navbar-brand fw-bold" href="#">
🎓 Student Management System
</a>

<div class="d-flex align-items-center">

<span class="text-white me-3">
Welcome,
<b><?= htmlspecialchars($_SESSION['user_name']) ?></b>
</span>

<a href="logout.php" class="btn btn-light btn-sm">
Logout
</a>

</div>

</div>
</nav>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">

<h2 class="dashboard-title">
Dashboard
</h2>

<div class="text-muted">
<?= date("d M Y | h:i A"); ?>
</div>

</div>

<!-- Success Alert -->
<div class="alert alert-success shadow-sm">
✅ <strong>Login Successful!</strong> Welcome back,
<b><?= htmlspecialchars($_SESSION['user_name']) ?></b>.
</div>

<!-- Cards -->
<div class="row mb-4">

<div class="col-md-4">

<div class="card shadow">

<div class="card-body text-center">

<h1>👨‍🎓</h1>

<h5>Total Students</h5>

<h2 class="text-primary">
<?= $totalStudents ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow">

<div class="card-body text-center">

<h1>👤</h1>

<h5>User Role</h5>

<h2 class="text-success">
Admin
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow">

<div class="card-body text-center">

<h1>🔐</h1>

<h5>Session</h5>

<h2 class="text-info">
Active
</h2>

</div>

</div>

</div>

</div>

<!-- Student Table -->

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">
📋 Student Directory
</h4>

</div>

<div class="card-body">

<?php

$students=mysqli_query($conn,"SELECT * FROM students ORDER BY id DESC");

if(mysqli_num_rows($students)>0){

?>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>#</th>

<th>Name</th>

<th>Email</th>

<th>Branch</th>

</tr>

</thead>

<tbody>

<?php
$i=1;

while($row=mysqli_fetch_assoc($students)){
?>

<tr>

<td><?= $i++; ?></td>

<td>
<b><?= htmlspecialchars($row['name']); ?></b>
</td>

<td>

<span class="badge badge-email">

<?= htmlspecialchars($row['email']); ?>

</span>

</td>

<td>

<span class="badge badge-branch">

<?= htmlspecialchars($row['branch']); ?>

</span>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

<?php
}
else{
?>

<div class="alert alert-warning text-center">

No student records found.

</div>

<?php
}
?>

</div>

</div>

</div>

<!-- Footer -->

<footer class="text-center py-3 mt-5">

<div class="container">

<p class="mb-1">

© 2026 Student Management System

</p>

<small>

Logged in as:
<b><?= htmlspecialchars($_SESSION['user_email']); ?></b>

</small>

</div>

</footer>

</body>

</html>


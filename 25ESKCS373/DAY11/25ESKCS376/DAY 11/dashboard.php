<?php 
session_start();

$userName = $_SESSION['username'] ?? $_SESSION['user_name'] ?? $_SESSION['user_email'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? $_SESSION['email'] ?? '';
$userFile = !empty($_SESSION['user_file']) ? $_SESSION['user_file'] : 'profile.jpg';

if (empty($_SESSION['user_id']) && empty($_SESSION['user_name']) && empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include ('dashboardHeader.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamal Jethwani</title>
    <style>
        /* Sets the overall page font, outer spacing, and background color */
         body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        /* Creates a centered card-like box for the main content */
        /*.container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Centers the profile section content */
        .profile-header {
            text-align: center;
        }

        /* Styles the profile name heading */
        .profile-header h1 {
            color: #333;
            margin: 10px 0;
        }

        /* Makes the profile image circular and properly sized */
        .profile-header img {
            border-radius: 50%;
            width: 250px;
            height: 250px;
            object-fit: cover;
            border: 3px solid #ddd;
        }

        /* Adds a horizontal divider line with spacing */
        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        /* Styles normal links */
        a {
            color: #007bff;
            text-decoration: none;
        }

        /* Underlines links when the mouse hovers over them */
        a:hover {
            text-decoration: underline;
        }

        /* Adds left indentation for unordered and ordered lists */
        ul, ol {
            margin-left: 20px;
        }

        /* Adds vertical spacing between list items */
        li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1><?php echo htmlspecialchars($userName); ?></h1>
            <img src="<?php echo htmlspecialchars($userFile); ?>" alt="<?php echo htmlspecialchars($userName); ?> Profile Picture">
        </div>
        <hr>

        <?php if (!empty($userEmail)) { ?>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
        <?php } ?>

        <form method="post" class="mt-4">
            <h4>Skills / Abilities</h4>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill1" class="form-control" placeholder="Skill 1">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill2" class="form-control" placeholder="Skill 2">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill3" class="form-control" placeholder="Skill 3">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill4" class="form-control" placeholder="Skill 4">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill5" class="form-control" placeholder="Skill 5">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill6" class="form-control" placeholder="Skill 6">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill7" class="form-control" placeholder="Skill 7">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill8" class="form-control" placeholder="Skill 8">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill9" class="form-control" placeholder="Skill 9">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="skill10" class="form-control" placeholder="Skill 10">
                </div>
            </div>
             <button type="submit" class="btn btn-primary mt-3">Submit</button>

            <h4 class="mt-3">Interests</h4>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" name="interest1" class="form-control" placeholder="Interest 1">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" name="interest2" class="form-control" placeholder="Interest 2">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" name="interest3" class="form-control" placeholder="Interest 3">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>

        <div class="mt-3">
            <a href="updatePassword.php" class="btn btn-primary">Update Password</a>
            <a href="updateProfile.php" class="btn btn-primary">Update Profile</a>
        </div>
    </div>
</body>
<!--
<form>
    <p>Name: <input type="text" name="name"></p>
    <p>Email: <input type="email" name="email"></p>
    <p>Message: <textarea name="message"></textarea></p>
</form>-->
</html>


<?php include ('dashboardVerticalcontent.php'); ?>

<?php
include('dashboardFooter.php');
?>

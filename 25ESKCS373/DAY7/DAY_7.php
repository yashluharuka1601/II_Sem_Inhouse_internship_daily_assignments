<?php
$fullname = $email = $experience = $position = $shift = $coverletter = "";
$errors = [];
$photoDataUrl = "";

if(isset($_POST['apply']))
{
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $experience = trim($_POST['experience']);
    $position = $_POST['position'];
    $shift = isset($_POST['shift']) ? $_POST['shift'] : "";
    $coverletter = trim($_POST['coverletter']);

    // 1. Full Name Validation
    if($fullname == "") {
        $errors[] = "Full Name is required.";
    } else if(preg_match('/[0-9]/', $fullname)) {
        $errors[] = "Full Name cannot contain numeric values.";
    }

    // 2. Email Validation
    if($email == "") {
        $errors[] = "Email address is required.";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email format.";
    }

    // 3. Experience Validation (Must be numbers only)
    if($experience == "") {
        $errors[] = "Years of experience is required.";
    } else if(!preg_match('/^[0-9]+$/', $experience)) {
        $errors[] = "Years of experience must be a whole number.";
    }

    // 4. Position Dropdown Validation
    if($position == "") {
        $errors[] = "Please choose a targeted job position.";
    }

    // 5. Shift Radio Button Validation
    if($shift == "") {
        $errors[] = "Please select your preferred work shift.";
    }

    // 6. Cover Letter Textarea Validation
    if($coverletter == "") {
        $errors[] = "Cover letter introductory message is required.";
    } else if(strlen($coverletter) < 15) {
        $errors[] = "Cover letter must provide some substance (at least 15 characters).";
    }

    // 7. Profile Photo File Processing (Converts file directly to safe displayable string)
    if(count($errors) == 0 && isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileType = $_FILES['avatar']['type'];
        
        // Convert the file content to binary base64 string safely
        $fileData = file_get_contents($fileTmpPath);
        $base64 = base64_encode($fileData);
        $photoDataUrl = 'data:' . $fileType . ';base64,' . $base64;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Application Desk</title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2f7;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .app-card {
            width: 720px;
            margin: 50px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.08);
        }
        h2 {
            color: #1e3a8a;
            text-align: center;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .error-summary {
            background: #fff5f5;
            color: #c53030;
            border-left: 4px solid #c53030;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        .success-summary {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 25px;
            border-radius: 8px;
        }
        .preview-avatar {
            margin-top: 12px;
            border: 3px solid #e2e8f0;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="app-card">

    <?php
    // If submission is checked and no tracking errors exist, render dashboard profile printout
    if(isset($_POST['apply']) && count($errors) == 0)
    {
    ?>
        <div class="success-summary">
            <h2>Application Transmitted Successfully</h2>
            <hr>
            <p><b>Applicant Name:</b> <?php echo htmlspecialchars($fullname); ?></p>
            <p><b>Contact Email:</b> <?php echo htmlspecialchars($email); ?></p>
            <p><b>Relevant Experience:</b> <?php echo htmlspecialchars($experience); ?> Year(s)</p>
            <p><b>Targeted Position:</b> <?php echo htmlspecialchars($position); ?></p>
            <p><b>Preferred Shift:</b> <?php echo htmlspecialchars($shift); ?></p>
            <p><b>Cover Letter Summary:</b><br><?php echo nl2br(htmlspecialchars($coverletter)); ?></p>

            <?php if($photoDataUrl != "") { ?>
                <p><b>Uploaded Profile Identity Photo:</b></p>
                <img src="<?php echo $photoDataUrl; ?>" width="160" height="160" class="preview-avatar" alt="Applicant Photo">
            <?php } ?>
            
            <br><br>
            <a href="" class="btn btn-primary d-inline-block">Submit Another Application</a>
        </div>
    <?php
    }
    else
    {
    ?>
        <h2>Job Application Form</h2>

        <!-- Render errors block if validation catches anything -->
        <?php if(count($errors) > 0) { ?>
            <div class="error-summary">
                <strong>Please correct the following blockers before submission:</strong>
                <ul class="mt-2 mb-0">
                    <?php
                    foreach($errors as $err) {
                        echo "<li>" . htmlspecialchars($err) . "</li>";
                    }
                    ?>
                </ul>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            
            <!-- Full Name Text Input -->
            <div class="mb-3">
                <label class="form-label font-weight-bold">Full Name</label>
                <input type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
            </div>

            <!-- Email Address Input -->
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <!-- Experience Numeric Input -->
            <div class="mb-3">
                <label class="form-label">Years of Experience</label>
                <input type="text" class="form-control" name="experience" value="<?php echo htmlspecialchars($experience); ?>" placeholder="e.g. 3">
            </div>

            <!-- Profile Photo File Upload -->
            <div class="mb-3">
                <label class="form-label">Applicant Photo (JPEG/PNG)</label>
                <input type="file" class="form-control" name="avatar">
            </div>

            <!-- Shift Selection Radio Array -->
            <div class="mb-3">
                <label class="form-label d-block">Preferred Shift</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shift" value="Day" <?php if($shift == "Day") echo "checked"; ?>>
                    <label class="form-check-label">Day Shift</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shift" value="Night" <?php if($shift == "Night") echo "checked"; ?>>
                    <label class="form-check-label">Night Shift</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shift" value="Remote" <?php if($shift == "Remote") echo "checked"; ?>>
                    <label class="form-check-label">Flexible / Remote</label>
                </div>
            </div>

            <!-- Position Target Option Select Dropdown -->
            <div class="mb-3">
                <label class="form-label">Target Role</label>
                <select class="form-select" name="position">
                    <option value="">Select Targeted Department</option>
                    <option value="Software Engineer" <?php if($position == "Software Engineer") echo "selected"; ?>>Software Engineer</option>
                    <option value="Data Analyst" <?php if($position == "Data Analyst") echo "selected"; ?>>Data Analyst</option>
                    <option value="UI/UX Designer" <?php if($position == "UI/UX Designer") echo "selected"; ?>>UI/UX Designer</option>
                    <option value="Project Manager" <?php if($position == "Project Manager") echo "selected"; ?>>Project Manager</option>
                </select>
            </div>

            <!-- Pitch/Cover Letter Textarea Block -->
            <div class="mb-4">
                <label class="form-label">Cover Letter / Personal Statement</label>
                <textarea class="form-control" name="coverletter" rows="4" placeholder="Tell us briefly why you are a great fit..."><?php echo htmlspecialchars($coverletter); ?></textarea>
            </div>

            <!-- Submission Form Trigger Tools -->
            <div class="text-center">
                <button type="submit" name="apply" class="btn btn-primary px-5 me-2">Submit Application</button>
                <button type="reset" class="btn btn-outline-secondary px-5">Clear Form</button>
            </div>

        </form>
    <?php
    }
    ?>

</div>

</body>
</html>

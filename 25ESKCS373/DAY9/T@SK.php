<?php
$ownerName = $email = $phone = $vehicleType = $servicePackage = $specialInstructions = $bookingDate = "";
$errors = [];
$documentPath = "";

if(isset($_POST['book_service']))
{
    $ownerName = trim($_POST['ownerName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $vehicleType = isset($_POST['vehicleType']) ? $_POST['vehicleType'] : "";
    $servicePackage = $_POST['servicePackage'];
    $specialInstructions = trim($_POST['specialInstructions']);
    $bookingDate = $_POST['bookingDate'];

    // 1. Owner Name Validation
    if($ownerName == "") {
        $errors[] = "Owner Name is required.";
    } else if(!preg_match("/^[a-zA-Z ]+$/", $ownerName)) {
        $errors[] = "Owner Name should contain only alphabets and spaces.";
    }

    // 2. Email Validation
    if($email == "") {
        $errors[] = "Email address is required.";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email format.";
    }

    // 3. Phone Validation
    if($phone == "") {
        $errors[] = "Phone Number is required.";
    } else if(!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone Number must be exactly 10 numeric digits.";
    }

    // 4. Vehicle Type Radio Validation
    if($vehicleType == "") {
        $errors[] = "Please select your vehicle classification type.";
    }

    // 5. Service Package Select Validation
    if($servicePackage == "") {
        $errors[] = "Please choose a target service package tier.";
    }

    // 6. Special Instructions Validation
    if($specialInstructions == "") {
        $errors[] = "Special instructions or notes are required.";
    }

    // 7. Booking Date Field Validation
    if($bookingDate == "") {
        $errors[] = "Please pick a scheduled service arrival date.";
    }

    // 8. Vehicle Registration Document / Image Upload Validation
    if($_FILES['rc_doc']['name'] == "") {
        $errors[] = "Please upload a copy of your vehicle registration image.";
    } else {
        // Build path using uploads directory and prefixing with timestamp
        $targetDir = "service_uploads";
        if(!file_exists($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }

        $documentPath = $targetDir . "/" . time() . "_" . basename($_FILES['rc_doc']['name']);
        $extension = strtolower(pathinfo($documentPath, PATHINFO_EXTENSION));

        if($extension != "jpg" && $extension != "jpeg" && $extension != "png") {
            $errors[] = "Only JPG, JPEG, and PNG image extensions are accepted.";
        }

        // If validation steps clear completely, move the file resource out of temp storage
        if(count($errors) == 0) {
            move_uploaded_file($_FILES["rc_doc"]["tmp_name"], $documentPath);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Care Service Desk</title>
    <!-- Bootstrap 5 CSS Framework Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container-box {
            width: 740px;
            margin: 50px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #198754;
            font-weight: 600;
        }
        .error-box {
            background: #fff5f5;
            border-left: 4px solid #dc3545;
            padding: 15px;
            border-radius: 6px;
            color: #b91c1c;
            margin-bottom: 20px;
        }
        .success-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 30px;
            border-radius: 10px;
        }
        .success-box h2 {
            color: #166534;
        }
        .img-preview {
            border-radius: 8px;
            border: 2px solid #cbd5e1;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container-box">

<?php
// Scenario A: Form submitted safely without errors -> Render Table Display Summary
if(isset($_POST['book_service']) && count($errors) == 0)
{
?>
    <div class="success-box">
        <h2>Service Slot Booked Successfully</h2>
        <p class="text-muted text-center">Your request has been filed. Review details below:</p>
        
        <table class="table table-bordered bg-white mt-4">
            <tr>
                <th class="w-25">Vehicle Photo/Doc</th>
                <td><img src="<?php echo htmlspecialchars($documentPath); ?>" width="180" class="img-preview" alt="Registration Document"></td>
            </tr>
            <tr>
                <th>Owner Name</th>
                <td><?php echo htmlspecialchars($ownerName); ?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>Contact Phone</th>
                <td><?php echo htmlspecialchars($phone); ?></td>
            </tr>
            <tr>
                <th>Scheduled Date</th>
                <td><?php echo htmlspecialchars($bookingDate); ?></td>
            </tr>
            <tr>
                <th>Vehicle Type</th>
                <td><?php echo htmlspecialchars($vehicleType); ?></td>
            </tr>
            <tr>
                <th>Service Tier</th>
                <td><?php echo htmlspecialchars($servicePackage); ?></td>
            </tr>
            <tr>
                <th>Special Instructions</th>
                <td><?php echo nl2br(htmlspecialchars($specialInstructions)); ?></td>
            </tr>
        </table>

        <div class="text-center mt-4">
            <a href="" class="btn btn-success px-4">Book Another Vehicle</a>
        </div>
    </div>
<?php
}
else
{
// Scenario B: Form initialization or state recovery after failed runtime verification checks
?>
    <h2>Auto Care Service Booking Form</h2>

    <?php if(count($errors) > 0) { ?>
        <div class="error-box">
            <strong>Please resolve the following system blockers:</strong>
            <ul class="mt-2 mb-0">
                <?php
                foreach($errors as $e) {
                    echo "<li>" . htmlspecialchars($e) . "</li>";
                }
                ?>
            </ul>
        </div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <!-- Owner Name Input -->
        <div class="mb-3">
            <label class="form-label">Owner Full Name</label>
            <input type="text" class="form-control" name="ownerName" value="<?php echo htmlspecialchars($ownerName); ?>">
        </div>

        <!-- Contact Email Input -->
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
        </div>

        <!-- Phone Input -->
        <div class="mb-3">
            <label class="form-label">Contact Phone Number</label>
            <input type="text" class="form-control" name="phone" maxlength="10" placeholder="e.g. 9876543210" value="<?php echo htmlspecialchars($phone); ?>">
        </div>

        <!-- File Upload Field -->
        <div class="mb-3">
            <label class="form-label">Vehicle Document / Image (JPG/PNG)</label>
            <input type="file" class="form-control" name="rc_doc" accept=".jpg,.jpeg,.png">
        </div>

        <!-- Target Booking Date Field -->
        <div class="mb-3">
            <label class="form-label">Target Service Appointment Date</label>
            <input type="date" class="form-control" name="bookingDate" value="<?php echo htmlspecialchars($bookingDate); ?>">
        </div>

        <!-- Vehicle Type Radio Array Input -->
        <div class="mb-3">
            <label class="form-label d-block">Vehicle Type</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vehicleType" value="Sedan/Hatchback" <?php if($vehicleType == "Sedan/Hatchback") echo "checked"; ?>>
                <label class="form-check-label">Sedan / Hatchback</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vehicleType" value="SUV/Crossover" <?php if($vehicleType == "SUV/Crossover") echo "checked"; ?>>
                <label class="form-check-label">SUV / Crossover</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="vehicleType" value="Motorcycle/Scooter" <?php if($vehicleType == "Motorcycle/Scooter") echo "checked"; ?>>
                <label class="form-check-label">Motorcycle / Scooter</label>
            </div>
        </div>

        <!-- Service Tier Select Dropdown Menu Option -->
        <div class="mb-3">
            <label class="form-label">Select Service Package</label>
            <select class="form-select" name="servicePackage">
                <option value="">Choose Package Level</option>
                <option value="Basic Inspection" <?php if($servicePackage == "Basic Inspection") echo "selected"; ?>>Basic Inspection Package</option>
                <option value="Standard Tuning & Oil Change" <?php if($servicePackage == "Standard Tuning & Oil Change") echo "selected"; ?>>Standard Tuning &amp; Oil Change</option>
                <option value="Premium Deep Clean & Detail" <?php if($servicePackage == "Premium Deep Clean & Detail") echo "selected"; ?>>Premium Deep Clean &amp; Detail</option>
            </select>
        </div>

        <!-- Textarea Block for Custom Notes -->
        <div class="mb-4">
            <label class="form-label">Special Diagnostic Notes / Issues</label>
            <textarea class="form-control" name="specialInstructions" rows="4" placeholder="Describe any current performance anomalies..."><?php echo htmlspecialchars($specialInstructions); ?></textarea>
        </div>

        <!-- Process Actions Panel Controls -->
        <div class="text-center">
            <button type="submit" name="book_service" class="btn btn-success px-5 me-2">Confirm Booking</button>
            <button type="reset" class="btn btn-secondary px-5">Reset Fields</button>
        </div>

    </form>
<?php
}
?>

</div>

</body>
</html>

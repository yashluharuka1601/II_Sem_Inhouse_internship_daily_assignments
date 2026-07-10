<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Review Console</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            background: #198754;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        form {
            width: 480px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type=submit] {
            background: #198754;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        input[type=submit]:hover {
            background: #146c43;
        }

        .card {
            width: 500px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        .card h2 {
            text-align: center;
            color: #198754;
        }

        .card table {
            border-collapse: collapse;
        }

        .card td {
            border: 1px solid #dee2e6;
        }

        .error {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
        }

        footer {
            background: #198754;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
        }
    </style>
</head>

<body>

<h1>Employee Performance Review Console</h1>

<?php
// Initialize all tracked variable containers 
$empName = "";
$empEmail = "";
$department = "";
$projectCount = "";
$score = "";
$ratingTier = "";
$errorMessage = "";

// Track form processing events
if(isset($_POST["evaluate"]))
{
    // Gather and hold data immediately to preserve inputs across postbacks
    $empName = $_POST["empName"];
    $empEmail = $_POST["empEmail"];
    $department = $_POST["department"];
    $projectCount = $_POST["projectCount"];
    $score = $_POST["score"];

    // Basic complete verification check
    if($empName == "" || $empEmail == "" || $department == "" || $projectCount == "" || $score == "")
    {
        $errorMessage = "All data inputs are required. Evaluation stopped.";
    }
    else
    {
        // Metric Logic calculation maps a performance rating tier
        if($score >= 95)
            $ratingTier = "Elite Performer (Tier 1)";
        elseif($score >= 80)
            $ratingTier = "Exceeds Standards (Tier 2)";
        elseif($score >= 65)
            $ratingTier = "Meets Standards (Tier 3)";
        elseif($score >= 50)
            $ratingTier = "Needs Improvement (Tier 4)";
        else
            $ratingTier = "Unsatisfactory (Tier 5)";
    }
}
?>

<!-- Input Form Collection Block -->
<form method="POST">
    <table>
        <tr>
            <td>Employee Name</td>
            <td><input type="text" name="empName" value="<?php echo htmlspecialchars($empName); ?>"></td>
        </tr>

        <tr>
            <td>Work Email</td>
            <td><input type="email" name="empEmail" value="<?php echo htmlspecialchars($empEmail); ?>"></td>
        </tr>

        <tr>
            <td>Department</td>
            <td>
                <select name="department">
                    <option value="">Select Division</option>
                    <option value="Engineering" <?php if($department == "Engineering") echo "selected"; ?>>Engineering</option>
                    <option value="Marketing" <?php if($department == "Marketing") echo "selected"; ?>>Marketing</option>
                    <option value="Operations" <?php if($department == "Operations") echo "selected"; ?>>Operations</option>
                    <option value="Human Resources" <?php if($department == "Human Resources") echo "selected"; ?>>Human Resources</option>
                    <option value="Finance" <?php if($department == "Finance") echo "selected"; ?>>Finance</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Projects Completed</td>
            <td><input type="number" name="projectCount" value="<?php echo htmlspecialchars($projectCount); ?>"></td>
        </tr>

        <tr>
            <td>Evaluation Score (1-100)</td>
            <td><input type="number" step="1" name="score" value="<?php echo htmlspecialchars($score); ?>"></td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="evaluate" value="Generate Metrics Summary">
            </td>
        </tr>
    </table>
</form>

<?php
// Renders warnings safely when triggered
if($errorMessage != "")
{
    echo "<p class='error'>" . htmlspecialchars($errorMessage) . "</p>";
}

// Renders the profile card table upon successful criteria mapping
if($ratingTier != "")
{
    echo "<div class='card'>";
    echo "<h2>Review For: " . htmlspecialchars($empName) . "</h2>";
    echo "<table>";
    echo "<tr><td><b>Name</b></td><td>" . htmlspecialchars($empName) . "</td></tr>";
    echo "<tr><td><b>Email</b></td><td>" . htmlspecialchars($empEmail) . "</td></tr>";
    echo "<tr><td><b>Department</b></td><td>" . htmlspecialchars($department) . "</td></tr>";
    echo "<tr><td><b>Projects Handled</b></td><td>" . htmlspecialchars($projectCount) . "</td></tr>";
    echo "<tr><td><b>Raw Score</b></td><td>" . htmlspecialchars($score) . "/100</td></tr>";
    echo "<tr><td><b>Assigned Tier Rating</b></td><td><b>" . htmlspecialchars($ratingTier) . "</b></td></tr>";
    echo "<tr><td><b>Processed On</b></td><td>" . date("d-m-Y") . "</td></tr>";
    echo "</table>";
    echo "</div>";
}
?>

<footer>
    Corporate Performance Desk Console © <?php echo date("Y"); ?>
</footer>

</body>
</html>

<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include "dbconn.php";

if (!isset($_GET['id'])) {
    die("Error: Subject ID not provided.");
}

$subjectID = intval($_GET['id']);
$sql = "SELECT * FROM subjects WHERE SubjectID = $subjectID";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    die("Error: Subject not found.");
}
$subject = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Subject</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        h1 { color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], select, textarea {
            width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;
        }
        .btn {
            background-color: #0066cc; color: white;
            padding: 10px 20px; border: none; border-radius: 5px;
            cursor: pointer; margin-right: 10px;
        }
        .btn:hover { background-color: #004a99; }
        .cancel-btn {
            background-color: #888;
        }
        .cancel-btn:hover {
            background-color: #666;
        }
        .delete-btn {
            background-color: #cc0000;
        }
        .delete-btn:hover {
            background-color: #990000;
        }
    </style>
</head>
<body>
<h1>Edit Subject</h1>

<form method="POST" action="updatesubject.php">
    <input type="hidden" name="SubjectID" value="<?= $subject['SubjectID'] ?>">

    <div class="form-group">
        <label>Case Number:</label>
        <select name="InvestigationID" required>
            <?php
            $cases = $conn->query("SELECT InvestigationID, CaseNumber FROM investigations ORDER BY CaseNumber");
            while ($row = $cases->fetch_assoc()) {
                $selected = ($row['InvestigationID'] == $subject['InvestigationID']) ? 'selected' : '';
                echo "<option value='{$row['InvestigationID']}' $selected>{$row['CaseNumber']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Employee (or leave blank for unknown):</label>
        <select name="EmployeeID">
            <option value="">Unknown Subject</option>
            <?php
            $emps = $conn->query("SELECT employeeID, FirstName, LastName FROM employees ORDER BY FirstName, LastName");
            while ($emp = $emps->fetch_assoc()) {
                $fullName = "{$emp['employeeID']} - {$emp['FirstName']} {$emp['LastName']}";
                $selected = ($emp['employeeID'] == $subject['EmployeeID']) ? 'selected' : '';
                echo "<option value='{$emp['employeeID']}' $selected>{$fullName}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Role:</label>
        <select name="Role" required>
            <?php
            $roles = ["Suspect", "Witness", "Complainant", "Victim", "Other"];
            foreach ($roles as $role) {
                $selected = ($subject['Role'] == $role) ? "selected" : "";
                echo "<option value='$role' $selected>$role</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Notes:</label>
        <textarea name="Notes"><?= htmlspecialchars($subject['Notes']) ?></textarea>
    </div>

    <input type="submit" value="Update Subject" class="btn">
    <a href="subjects.php" class="btn cancel-btn">Cancel</a>
    <a href="delsubject.php?id=<?= $subjectID ?>" class="btn delete-btn"
       onclick="return confirm('Are you sure you want to delete this subject?');">Delete</a>
</form>

</body>
</html>

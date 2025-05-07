<?php 

include 'dbconn.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        h1 { color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], select, textarea {
            width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type="submit"], .btn {
            background-color: #0066cc; color: white; padding: 10px 20px;
            border: none; border-radius: 5px; cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #004a99;
        }
        .cancel-btn {
            background-color: #888;
        }
        .cancel-btn:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
<h1>Add Subject</h1>

<form action="submitsubject.php" method="POST">
    <div class="form-group">
        <label>Case Number:</label>
        <select name="InvestigationID" required>
            <option value="">Select a case</option>
            <?php
            $cases = $conn->query("SELECT InvestigationID, CaseNumber FROM investigations ORDER BY CaseNumber");
            while ($row = $cases->fetch_assoc()) {
                echo "<option value='{$row['InvestigationID']}'>{$row['CaseNumber']}</option>";
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
                echo "<option value='{$emp['employeeID']}'>{$fullName}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Role:</label>
        <select name="Role" required>
            <option value="">Select Role</option>
            <option value="Suspect">Suspect</option>
            <option value="Witness">Witness</option>
            <option value="Complainant">Complainant</option>
            <option value="Victim">Victim</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="form-group">
        <label>Notes:</label>
        <textarea name="Notes"></textarea>
    </div>

    <input type="submit" value="Add Subject" class="btn">
    <a href="subjects.php" class="btn cancel-btn">Cancel</a>
</form>

</body>
</html>

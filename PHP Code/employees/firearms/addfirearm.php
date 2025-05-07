<?php
include "dbconn.php";

$officers = $conn->query("SELECT employeeID, CONCAT(FirstName, ' ', LastName) AS name FROM employees WHERE EmploymentType = 'Uniform'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Firearm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }
        h1 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], select {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 18px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #004a99;
        }
    </style>
</head>
<body>

<h1>Add Firearm</h1>

<form method="post" action="submitfirearm.php">
    <div class="form-group">
        <label>Officer:</label>
        <select name="EmployeeID" required>
            <option value="">-- Select Officer --</option>
            <?php while ($o = $officers->fetch_assoc()) { ?>
                <option value="<?= $o['employeeID'] ?>"><?= htmlspecialchars($o['name']) ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Make:</label>
        <input type="text" name="Make" required>
    </div>

    <div class="form-group">
        <label>Model:</label>
        <input type="text" name="Model" required>
    </div>

    <div class="form-group">
        <label>Serial Number:</label>
        <input type="text" name="SerialNumber" required>
    </div>

    <div class="form-group">
        <label>Date Added:</label>
        <input type="date" name="DateAdded" required>
    </div>

    <div class="form-group">
        <label>Qualification Date:</label>
        <input type="date" name="QualificationDate" required>
    </div>

    <div class="form-group">
        <label>Status:</label>
        <select name="Status" required>
            <option value="Active">Active</option>
            <option value="Surrendered">Surrendered</option>
            <option value="Confiscated">Confiscated</option>
            <option value="Lost">Lost</option>
        </select>
    </div>

    <button type="submit" class="btn">Submit </button>
    <a href="firearms.php" class="btn">Cancel</a>
</form>

</body>
</html>

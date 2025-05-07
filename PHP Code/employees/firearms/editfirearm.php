<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "dbconn.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM firearms WHERE firearmID = $id");
$data = $result->fetch_assoc();
$officers = $conn->query("SELECT employeeID, CONCAT(FirstName, ' ', LastName) AS name FROM employees WHERE EmploymentType = 'Uniform'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Firearm</title>
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

<h1>Edit Firearm</h1>

<form method="post" action="updatefirearm.php">
    <input type="hidden" name="firearmID" value="<?= $data['firearmID'] ?>">

    <div class="form-group">
        <label>Officer:</label>
        <select name="EmployeeID" required>
            <?php while ($o = $officers->fetch_assoc()) {
                $selected = $o['employeeID'] == $data['EmployeeID'] ? "selected" : "";
                echo "<option value='{$o['employeeID']}' $selected>" . htmlspecialchars($o['name']) . "</option>";
            } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Make:</label>
        <input type="text" name="Make" value="<?= htmlspecialchars($data['Make']) ?>" required>
    </div>

    <div class="form-group">
        <label>Model:</label>
        <input type="text" name="Model" value="<?= htmlspecialchars($data['Model']) ?>" required>
    </div>

    <div class="form-group">
        <label>Serial Number:</label>
        <input type="text" name="SerialNumber" value="<?= htmlspecialchars($data['SerialNumber']) ?>" required>
    </div>

    <div class="form-group">
        <label>Date Added:</label>
        <input type="date" name="DateAdded" value="<?= $data['DateAdded'] ?>" required>
    </div>

    <div class="form-group">
        <label>Qualification Date:</label>
        <input type="date" name="QualificationDate" value="<?= $data['QualificationDate'] ?>" required>
    </div>

    <div class="form-group">
        <label>Status:</label>
        <select name="Status" required>
            <?php foreach (['Active', 'Surrendered', 'Confiscated', 'Lost'] as $status): ?>
                <option value="<?= $status ?>" <?= $status == $data['Status'] ? "selected" : "" ?>>
                    <?= $status ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn">Update </button>
    <a href="firearms.php" class="btn">Cancel</a>
</form>

</body>
</html>

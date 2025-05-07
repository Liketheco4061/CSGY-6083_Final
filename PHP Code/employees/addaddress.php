<?php
include "dbconn.php";


$sql = "SELECT employeeID, FirstName, LastName FROM employees ORDER BY LastName, FirstName";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Address</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px; }
        h1 { color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type='text'], select {
            width: 300px; padding: 8px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        .btn {
            padding: 10px 18px; background-color: #0066cc;
            color: white; border: none; border-radius: 5px;
            text-decoration: none; cursor: pointer;
        }
        .btn:hover { background-color: #004a99; }
        .msg { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h1>Add New Address</h1>

<?php if (!empty($_GET['msg'])): ?>
    <p class="msg"><?= htmlspecialchars($_GET['msg']) ?></p>
<?php endif; ?>

<form method="POST" action="submitaddress.php">
    <div class="form-group">
        <label>Street:</label>
        <input type="text" name="Street" required>
    </div>

    <div class="form-group">
        <label>City:</label>
        <input type="text" name="City" required>
    </div>

    <div class="form-group">
        <label>State (2-letter):</label>
        <input type="text" name="State" maxlength="2" required>
    </div>

    <div class="form-group">
        <label>Zip Code:</label>
        <input type="text" name="ZipCode" required>
    </div>

    <div class="form-group">
        <label>Assign to Employee:</label>
        <select name="EmployeeID" required>
            <option value="">-- Select Employee --</option>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['employeeID'] ?>">
                    <?= "{$row['employeeID']} - {$row['LastName']}, {$row['FirstName']}" ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <input type="submit" class="btn" value="Add Address">
    <a href="addresses.php" class="btn">Cancel</a>
</form>

</body>
</html>

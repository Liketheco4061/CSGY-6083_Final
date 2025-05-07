<?php
//no cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['addressID']) || !is_numeric($_GET['addressID'])) {
        echo "<p style='color:red;'>Invalid address ID parameter.</p>";
        exit();
    }

    $addressID = intval($_GET['addressID']);

    $stmt = $conn->prepare("SELECT * FROM addresses WHERE AddressID = ?");
    $stmt->bind_param("i", $addressID);
    $stmt->execute();
    $result = $stmt->get_result();
    $address = $result->fetch_assoc();
    $stmt->close();

    if (!$address) {
        echo "<p style='color:red;'>Address with ID $addressID not found.</p>";
        exit();
    }

    $empResult = $conn->query("SELECT employeeID, FirstName, LastName FROM employees ORDER BY LastName, FirstName");

} else {
    echo "<p style='color:red;'>Invalid request method.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Address</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background-color: #f9f9f9; }
        h1 { margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], select {
            width: 300px; padding: 8px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        .btn {
            padding: 10px 18px; background-color: #0066cc;
            color: white; border: none; border-radius: 5px;
            text-decoration: none; cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover { background-color: #004a99; }
    </style>
</head>
<body>

<h1>Edit Address</h1>

<form method="POST" action="updateaddress.php">
    <input type="hidden" name="AddressID" value="<?= htmlspecialchars($address['AddressID']) ?>">

    <div class="form-group">
        <label>Street:</label>
        <input type="text" name="Street" value="<?= htmlspecialchars($address['Street']) ?>" required>
    </div>

    <div class="form-group">
        <label>City:</label>
        <input type="text" name="City" value="<?= htmlspecialchars($address['City']) ?>" required>
    </div>

    <div class="form-group">
        <label>State (2-letter):</label>
        <input type="text" name="State" maxlength="2" value="<?= htmlspecialchars($address['State']) ?>" required>
    </div>

    <div class="form-group">
        <label>Zip Code:</label>
        <input type="text" name="ZipCode" value="<?= htmlspecialchars($address['ZipCode']) ?>" required>
    </div>

    <div class="form-group">
        <label>Assign to Employee:</label>
        <select name="EmployeeID" required>
            <option value="">-- Select Employee --</option>
            <?php while ($emp = $empResult->fetch_assoc()): ?>
                <option value="<?= $emp['employeeID'] ?>"
                    <?= $emp['employeeID'] == $address['employees_employeeID'] ? "selected" : "" ?>>
                    <?= "{$emp['employeeID']} - {$emp['LastName']}, {$emp['FirstName']}" ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <input type="submit" class="btn" value="Update Address">
    <a href="addresses.php" class="btn">Cancel</a>
</form>

</body>
</html>

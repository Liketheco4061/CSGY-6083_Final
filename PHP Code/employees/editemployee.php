<?php
include "dbconn.php";

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

if (!isset($_GET['employeeID']) || !is_numeric($_GET['employeeID'])) {
    echo "Invalid employee ID.";
    exit();
}

$employeeID = intval($_GET['employeeID']);

$stmt = $conn->prepare("
    SELECT e.*, a.AddressID, a.Street, a.City, a.State, a.ZipCode 
    FROM employees e 
    LEFT JOIN addresses a ON e.AddressID = a.AddressID 
    WHERE e.employeeID = ?
");
$stmt->bind_param("i", $employeeID);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    echo "Employee ID $employeeID not found.";
    exit();
}

//get department list
$departments = [];
$dResult = $conn->query("SELECT DepartmentID, DepartmentName FROM departments ORDER BY DepartmentID");
while ($row = $dResult->fetch_assoc()) {
    $departments[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 25px; }
        h2, h3 { margin-bottom: 5px; }
        input, select {
            margin-bottom: 12px; padding: 6px; width: 250px;
        }
        label { display: block; margin-top: 8px; }
    </style>
    <script>
        function toggleShieldField(type) {
            const field = document.getElementById("shieldNumber");
            if (type === "Civilian") {
                field.value = "none";
                field.readOnly = true;
            } else {
                field.readOnly = false;
            }
        }

        window.onload = function() {
            toggleShieldField("<?= $employee['EmploymentType'] ?>");
        };
    </script>
</head>
<body>
    <h2>Edit Employee: <?= htmlspecialchars($employee['FirstName'] . ' ' . $employee['LastName']) ?></h2>

    <form method="post" action="upemployee.php">
        <input type="hidden" name="employeeID" value="<?= $employee['employeeID'] ?>">
        <input type="hidden" name="AddressID" value="<?= $employee['AddressID'] ?>">

        <h3>Employee Info</h3>

        <label>First Name:
            <input type="text" name="firstName" value="<?= htmlspecialchars($employee['FirstName']) ?>" required>
        </label>
        <label>Last Name:
            <input type="text" name="lastName" value="<?= htmlspecialchars($employee['LastName']) ?>" required>
        </label>
        <label>Birth Date:
            <input type="date" name="birthDate" value="<?= $employee['BirthDate'] ?>" required>
        </label>
        <label>Start Date:
            <input type="date" name="startDate" value="<?= $employee['StartDate'] ?>" required>
        </label>
        <label>Phone Number:
            <input type="text" name="phoneNumber" value="<?= htmlspecialchars($employee['PhoneNumber']) ?>" required>
        </label>

        <label>Department:
            <select name="departmentID" required>
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['DepartmentID'] ?>" <?= $dept['DepartmentID'] == $employee['DepartmentID'] ? "selected" : "" ?>>
                        <?= htmlspecialchars($dept['DepartmentID'] . ' - ' . $dept['DepartmentName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>Employment Type:
            <select name="employmentType" onchange="toggleShieldField(this.value)" required>
                <option value="Uniform" <?= $employee['EmploymentType'] == "Uniform" ? "selected" : "" ?>>Uniform</option>
                <option value="Civilian" <?= $employee['EmploymentType'] == "Civilian" ? "selected" : "" ?>>Civilian</option>
            </select>
        </label>

        <label>Employment Status:
            <select name="employmentStatus" required>
                <option value="Active" <?= $employee['EmploymentStatus'] == "Active" ? "selected" : "" ?>>Active</option>
                <option value="Inactive" <?= $employee['EmploymentStatus'] == "Inactive" ? "selected" : "" ?>>Inactive</option>
            </select>
        </label>

        <label>Shield Number:
            <input type="text" name="shieldNumber" id="shieldNumber" value="<?= htmlspecialchars($employee['ShieldNumber']) ?>">
        </label>

        <label>SSN:
            <input type="text" name="ssn" value="<?= htmlspecialchars($employee['SSN']) ?>" required>
        </label>

        <label>Gender:
            <select name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male" <?= $employee['Gender'] == "Male" ? "selected" : "" ?>>Male</option>
                <option value="Female" <?= $employee['Gender'] == "Female" ? "selected" : "" ?>>Female</option>
                <option value="Non-Binary" <?= $employee['Gender'] == "Non-Binary" ? "selected" : "" ?>>Non-Binary</option>
            </select>
        </label>

        <h3>Address Info</h3>
        <label>Street:
            <input type="text" name="street" value="<?= htmlspecialchars($employee['Street'] ?? '') ?>" required>
        </label>
        <label>City:
            <input type="text" name="city" value="<?= htmlspecialchars($employee['City'] ?? '') ?>" required>
        </label>
        <label>State:
            <input type="text" name="state" value="<?= htmlspecialchars($employee['State'] ?? '') ?>" required>
        </label>
        <label>ZIP Code:
            <input type="text" name="zip" value="<?= htmlspecialchars($employee['ZipCode'] ?? '') ?>" required>
        </label>

        <br>
        <input type="submit" value="Update Employee">
    </form>
</body>
</html>

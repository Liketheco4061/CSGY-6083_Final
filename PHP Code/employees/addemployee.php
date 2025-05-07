<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "dbconn.php";

$departments = [];
$result = $conn->query("SELECT DepartmentID, DepartmentName FROM departments ORDER BY DepartmentID");
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $street = $_POST['street'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $zip = $_POST['zip'] ?? '';

    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $birthDate = $_POST['birthDate'] ?? '';
    $startDate = $_POST['startDate'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $departmentID = $_POST['departmentID'] ?? '';
    $employmentType = $_POST['employmentType'] ?? '';
    $employmentStatus = $_POST['employmentStatus'] ?? '';
    $shieldNumber = $_POST['shieldNumber'] ?? '';
    $ssn = $_POST['ssn'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if ($employmentType === 'Civilian') {
        $shieldNumber = 'none';
    }


    $stmt = $conn->prepare("INSERT INTO employees 
        (FirstName, LastName, BirthDate, StartDate, PhoneNumber, DepartmentID, EmploymentType, EmploymentStatus, ShieldNumber, SSN, Gender) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", 
        $firstName, $lastName, $birthDate, $startDate, $phoneNumber, 
        $departmentID, $employmentType, $employmentStatus, $shieldNumber, $ssn, $gender);
    $stmt->execute();
    $employeeID = $stmt->insert_id;
    $stmt->close();

    // Insert address
    $stmt = $conn->prepare("INSERT INTO addresses 
        (Street, City, State, ZipCode, employees_employeeID) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $street, $city, $state, $zip, $employeeID);
    $stmt->execute();
    $addressID = $stmt->insert_id;
    $stmt->close();


    $stmt = $conn->prepare("UPDATE employees SET AddressID = ? WHERE employeeID = ?");
    $stmt->bind_param("ii", $addressID, $employeeID);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    header("Location: employees.php?added=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e8e8e8;
            padding: 40px;
        }
        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #0066cc;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #004a99;
        }
    </style>
    <script>
        function handleEmploymentTypeChange() {
            const empType = document.getElementById("employmentType").value;
            const shield = document.getElementById("shieldNumber");
            if (empType === "Civilian") {
                shield.value = "none";
                shield.readOnly = true;
            } else {
                shield.value = "";
                shield.readOnly = false;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Add New Employee</h2>
        <form method="post" action="addemployee.php">
            <h3>Employee Info</h3>

            <label>First Name:</label>
            <input type="text" name="firstName" value="Test" required>

            <label>Last Name:</label>
            <input type="text" name="lastName" value="User 1" required>

            <label>Birth Date:</label>
            <input type="date" name="birthDate" value="1990-01-01" required>

            <label>Start Date:</label>
            <input type="date" name="startDate" value="2025-01-01" required>

            <label>Phone Number:</label>
            <input type="text" name="phoneNumber" value="9175551234" required>

            <label>Department:</label>
            <select name="departmentID" required>
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['DepartmentID'] ?>">
                        <?= htmlspecialchars($dept['DepartmentID'] . ' - ' . $dept['DepartmentName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Employment Type:</label>
            <select name="employmentType" id="employmentType" onchange="handleEmploymentTypeChange()" required>
                <option value="Uniform">Uniform</option>
                <option value="Civilian">Civilian</option>
            </select>

            <label>Employment Status:</label>
            <select name="employmentStatus" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <label>Shield Number:</label>
            <input type="text" name="shieldNumber" id="shieldNumber" value="12345">

            <label>SSN:</label>
            <input type="text" name="ssn" value="123-45-6789">

            <label>Gender:</label>
            <select name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Non-Binary">Non-Binary</option>
            </select>

            <h3>Address Info</h3>

            <label>Street:</label>
            <input type="text" name="street" value="123 Test St" required>

            <label>City:</label>
            <input type="text" name="city" value="New York" required>

            <label>State:</label>
            <input type="text" name="state" value="NY" required>

            <label>ZIP Code:</label>
            <input type="text" name="zip" value="10001" required>

            <button type="submit" class="btn">Add Employee</button>
        </form>
    </div>
</body>
</html>

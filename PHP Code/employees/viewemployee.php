<?php
include "dbconn.php";

$employeeID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$employee = null;

if ($employeeID > 0) {
    $stmt = $conn->prepare("
        SELECT 
            e.employeeID,
            get_employee_fullname(e.employeeID) AS FullName,
            e.BirthDate,
            e.StartDate,
            e.PhoneNumber,
            e.EmploymentType,
            e.EmploymentStatus,
            e.ShieldNumber,
            e.Gender,
            e.DepartmentID,
            d.DepartmentName,
            a.Street,
            a.City,
            a.State,
            a.ZipCode
        FROM employees e
        LEFT JOIN departments d ON e.DepartmentID = d.DepartmentID
        LEFT JOIN addresses a ON e.AddressID = a.AddressID
        WHERE e.employeeID = ?
    ");
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 40px;
        }

        h1 {
            color: #333;
        }

        .info-box {
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            padding: 20px;
            width: 600px;
        }

        .label {
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #004a99;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 15px auto;
            border: 2px solid #ccc;
        }

        .centered {
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Employee Details</h1>

<?php if ($employee): ?>
    <div class="info-box">
        <div class="centered">
            <img src="smiley.png" alt="Profile Picture" class="profile-pic">
            <h2><?= htmlspecialchars($employee['FullName']) ?></h2>
        </div>
        <p><span class="label">Employee ID:</span> <?= $employee['employeeID'] ?></p>
        <p><span class="label">Birth Date:</span> <?= $employee['BirthDate'] ?></p>
        <p><span class="label">Start Date:</span> <?= $employee['StartDate'] ?></p>
        <p><span class="label">Phone Number:</span> <?= $employee['PhoneNumber'] ?></p>
        <p><span class="label">Employment Type:</span> <?= $employee['EmploymentType'] ?></p>
        <p><span class="label">Employment Status:</span> <?= $employee['EmploymentStatus'] ?></p>
        <p><span class="label">Shield Number:</span> <?= $employee['ShieldNumber'] ?: "N/A" ?></p>
        <p><span class="label">Gender:</span> <?= $employee['Gender'] ?></p>
        <p><span class="label">Department:</span> <?= $employee['DepartmentID'] ?> - <?= $employee['DepartmentName'] ?></p>
        <p><span class="label">Address:</span> <?= "{$employee['Street']}, {$employee['City']}, {$employee['State']} {$employee['ZipCode']}" ?></p>
    </div>
<?php else: ?>
    <p>No employee found for the given ID.</p>
<?php endif; ?>

<a href="employees.php" class="btn">Back to Employees</a>

</body>
</html>

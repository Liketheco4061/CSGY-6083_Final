<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "dbconn.php";

if (!isset($_GET['employeeID']) || !is_numeric($_GET['employeeID'])) {
    echo "<p style='color:red;'>Invalid employee ID.</p>";
    exit();
}

$employeeID = intval($_GET['employeeID']);

$stmt = $conn->prepare("SELECT FirstName, LastName FROM employees WHERE employeeID = ?");
$stmt->bind_param("i", $employeeID);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    echo "<p style='color:red;'>Employee not found.</p>";
    exit();
}

//Log audit deletion
$changeNote = "Employee Deleted";

$logStmt = $conn->prepare("INSERT INTO employeeauditlog 
    (EmployeeID, FirstName, LastName, ValuesChanged, UpdatedAt)
    VALUES (?, ?, ?, ?, NOW())");

if ($logStmt) {
    $logStmt->bind_param("isss", $employeeID, $employee['FirstName'], $employee['LastName'], $changeNote);
    $logStmt->execute();
    $logStmt->close();
} else {
    echo "<p style='color:red;'>Audit logging failed: " . $conn->error . "</p>";
    exit();
}

$stmt = $conn->prepare("DELETE FROM employees WHERE employeeID = ?");
$stmt->bind_param("i", $employeeID);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: employees.php?deleted=1");
    exit();
} else {
    echo "<!DOCTYPE html>
    <html><head><style>
    body { font-family: Arial; padding: 25px; background-color: #f8f8f8; }
    .error { color: red; font-weight: bold; }
    .btn { margin-top: 20px; display: inline-block; padding: 10px 15px; background: #007BFF; color: white; text-decoration: none; border-radius: 5px; }
    .btn:hover { background: #0056b3; }
    </style></head><body>
    <p class='error'>Error: Unable to delete employee. This employee may be referenced elsewhere.</p>
    <a href='employees.php' class='btn'>Return to Employee List</a>
    </body></html>";
}
?>

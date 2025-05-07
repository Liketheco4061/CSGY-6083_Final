<?php
include "dbconn.php";

$investigationID = $_POST['InvestigationID'];
$employeeID = $_POST['EmployeeID'] ?: null;
$role = $_POST['Role'];
$notes = $_POST['Notes'];

$stmt = $conn->prepare("INSERT INTO subjects (InvestigationID, EmployeeID, Role, Notes) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $investigationID, $employeeID, $role, $notes);
$stmt->execute();
$stmt->close();

$conn->close();
header("Location: investigations.php");
exit();
?>

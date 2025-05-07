<?php
include "dbconn.php";

$sql = "INSERT INTO firearms (EmployeeID, Make, Model, SerialNumber, DateAdded, QualificationDate, Status)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", 
    $_POST['EmployeeID'],
    $_POST['Make'],
    $_POST['Model'],
    $_POST['SerialNumber'],
    $_POST['DateAdded'],
    $_POST['QualificationDate'],
    $_POST['Status']
);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: firearms.php");
exit();

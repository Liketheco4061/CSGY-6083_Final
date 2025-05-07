<?php
include "dbconn.php";

$sql = "UPDATE firearms SET 
        EmployeeID = ?, Make = ?, Model = ?, SerialNumber = ?, 
        DateAdded = ?, QualificationDate = ?, Status = ?
        WHERE firearmID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssi",
    $_POST['EmployeeID'],
    $_POST['Make'],
    $_POST['Model'],
    $_POST['SerialNumber'],
    $_POST['DateAdded'],
    $_POST['QualificationDate'],
    $_POST['Status'],
    $_POST['firearmID']
);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: firearms.php");
exit();

<?php
include "dbconn.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $addressID = $_POST['AddressID'] ?? null;
    $employeeID = $_POST['EmployeeID'] ?? null;

    if (!$addressID || !$employeeID || !is_numeric($addressID) || !is_numeric($employeeID)) {
        die("Invalid input.");
    }

    $street = $_POST['Street'] ?? '';
    $city = $_POST['City'] ?? '';
    $state = strtoupper($_POST['State'] ?? '');
    $zip = $_POST['ZipCode'] ?? '';


    $stmt = $conn->prepare("UPDATE addresses SET Street = ?, City = ?, State = ?, ZipCode = ?, employees_employeeID = ? WHERE AddressID = ?");
    $stmt->bind_param("ssssii", $street, $city, $state, $zip, $employeeID, $addressID);
    $stmt->execute();
    $stmt->close();

  
    $stmt = $conn->prepare("UPDATE employees SET AddressID = ? WHERE employeeID = ?");
    $stmt->bind_param("ii", $addressID, $employeeID);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    header("Location: addresses.php");
    exit();
} else {
    echo "Invalid request.";
}

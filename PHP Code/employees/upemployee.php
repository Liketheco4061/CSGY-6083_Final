<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include "dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeID = $_POST['employeeID'] ?? '';
    $addressID = $_POST['AddressID'] ?? '';
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

    if (!is_numeric($employeeID) || !is_numeric($addressID)) {
        echo "<p style='color:red;'>Invalid ID provided.</p>";
        exit;
    }

    
    $stmt = $conn->prepare("UPDATE employees SET FirstName=?, LastName=?, BirthDate=?, StartDate=?, PhoneNumber=?, DepartmentID=?, EmploymentType=?, EmploymentStatus=?, ShieldNumber=?, SSN=?, Gender=? WHERE employeeID=?");
    $stmt->bind_param("sssssssssssi", $firstName, $lastName, $birthDate, $startDate, $phoneNumber, $departmentID, $employmentType, $employmentStatus, $shieldNumber, $ssn, $gender, $employeeID);
    $stmt->execute();
    $stmt->close();

    
    $stmt = $conn->prepare("UPDATE addresses SET Street=?, City=?, State=?, ZipCode=? WHERE AddressID=?");
    $stmt->bind_param("ssssi", $street, $city, $state, $zip, $addressID);
    $stmt->execute();
    $stmt->close();

    header("Location: employees.php?updated=1");
    exit();
} else {
    echo "<p style='color:red;'>Invalid request method.</p>";
}
$conn->close();

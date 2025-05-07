<?php
include "dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $street = trim($_POST['Street']);
    $city = trim($_POST['City']);
    $state = strtoupper(trim($_POST['State']));
    $zip = trim($_POST['ZipCode']);
    $employeeID = isset($_POST['EmployeeID']) ? intval($_POST['EmployeeID']) : null;

    //check if employee already has address 
    if ($employeeID) {
        $check = $conn->prepare("SELECT AddressID FROM addresses WHERE employees_employeeID = ?");
        $check->bind_param("i", $employeeID);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $check->bind_result($existingAddressID);
            $check->fetch();
            echo "<script>alert('Employee already has address assigned, use Edit instead.');
                  window.location.href='editaddress.php?addressID=$existingAddressID';</script>";
            exit;
        }
        $check->close();
    }

    //insert address
    $stmt = $conn->prepare("INSERT INTO addresses (Street, City, State, ZipCode, employees_employeeID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $street, $city, $state, $zip, $employeeID);

    if ($stmt->execute()) {
        header("Location: addresses.php");
        exit;
    } else {
        echo "<p style='color:red;'>Error adding address: " . htmlspecialchars($stmt->error) . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p style='color:red;'>Invalid request method.</p>";
}
?>

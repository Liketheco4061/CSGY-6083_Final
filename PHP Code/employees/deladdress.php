<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "dbconn.php";

$addressID = $_GET['id'] ?? null;

if (!$addressID) {
    $errorMessage = "No address ID provided.";
} else {
    
    $stmt = $conn->prepare("SELECT employeeID FROM employees WHERE AddressID = ?");
    $stmt->bind_param("i", $addressID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errorMessage = "This address is still assigned to an employee. You must reassign or delete the employee before deleting this address.";
        $stmt->close();
    } else {
        $stmt->close();

        
        $stmt = $conn->prepare("DELETE FROM addresses WHERE AddressID = ?");
        $stmt->bind_param("i", $addressID);
        if ($stmt->execute()) {
            header("Location: addresses.php?deleted=1");
            exit;
        } else {
            $errorMessage = "Error deleting address: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 50px;
            text-align: center;
        }
        .error-box {
            background: #fff;
            border: 1px solid #d9534f;
            color: #d9534f;
            display: inline-block;
            padding: 20px;
            font-size: 16px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background: #0275d8;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn:hover {
            background: #025aa5;
        }
    </style>
</head>
<body>

<div class="error-box">
    <?= htmlspecialchars($errorMessage ?? "Unknown error.") ?>
    <br>
    <a href="addresses.php" class="btn">Back to Addresses</a>
</div>

</body>
</html>

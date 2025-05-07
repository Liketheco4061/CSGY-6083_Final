<?php
include "dbconn.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid investigation ID.");
}

$investigationID = (int)$_GET['id'];

//del subject first
$stmt = $conn->prepare("DELETE FROM subjects WHERE InvestigationID = ?");
$stmt->bind_param("i", $investigationID);
$stmt->execute();
$stmt->close();

//del investigation
$stmt = $conn->prepare("DELETE FROM investigations WHERE InvestigationID = ?");
$stmt->bind_param("i", $investigationID);

if ($stmt->execute()) {
    header("Location: investigations.php?updated=" . time());
    exit();
} else {
    echo "Error deleting investigation: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

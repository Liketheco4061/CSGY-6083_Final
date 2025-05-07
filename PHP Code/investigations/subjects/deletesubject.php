<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "dbconn.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: Subject ID not specified.");
}

$subjectID = intval($_GET['id']);

$fetch = $conn->prepare("SELECT * FROM subjects WHERE SubjectID = ?");
$fetch->bind_param("i", $subjectID);
$fetch->execute();
$result = $fetch->get_result();

if ($result->num_rows === 0) {
    die("Error: Subject not found.");
}

$subject = $result->fetch_assoc();
$fetch->close();

$log = $conn->prepare("
    INSERT INTO subjectauditlog 
        (EmployeeID, InvestigationID, Role, Notes, ActionTaken)
    VALUES (?, ?, ?, ?, 'Deleted')
");
$log->bind_param(
    "iiss",
    $subject['EmployeeID'],
    $subject['InvestigationID'],
    $subject['Role'],
    $subject['Notes']
);
$log->execute();
$log->close();

$stmt = $conn->prepare("DELETE FROM subjects WHERE SubjectID = ?");
$stmt->bind_param("i", $subjectID);

if ($stmt->execute()) {
    header("Location: subjects.php");
    exit();
} else {
    echo "Error deleting subject: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

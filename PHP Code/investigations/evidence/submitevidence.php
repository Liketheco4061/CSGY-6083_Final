<?php
include 'dbconn.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $investigationID = $_POST['InvestigationID'];
    $evidenceType    = $_POST['EvidenceType'];
    $description     = $_POST['Description'];
    $dateCollected   = $_POST['DateCollected'];
    $dateInvoiced    = $_POST['DateInvoiced'];
    $collectedBy     = $_POST['CollectedBy'];

    $check = $conn->prepare("SELECT InvestigationID FROM investigations WHERE InvestigationID = ?");
    $check->bind_param("i", $investigationID);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        echo "Error: Investigation ID $investigationID does not exist.";
        exit();
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO evidence 
        (investigations_InvestigationID, InvestigationID, EvidenceType, Description, DateCollected, DateInvoiced, CollectedBy) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssss", $investigationID, $investigationID, $evidenceType, $description, $dateCollected, $dateInvoiced, $collectedBy);

    if ($stmt->execute()) {
        
        //log
        $insertedID = $conn->insert_id;
        $summary = "INSERTED: Type=$evidenceType, Description=$description, DateCollected=$dateCollected, DateInvoiced=$dateInvoiced";
        $log = $conn->prepare("INSERT INTO evidenceauditlog (EvidenceID, InvestigationID, CollectedBy, ValuesChanged, UpdatedAt) 
                               VALUES (?, ?, ?, ?, NOW())");
        $log->bind_param("iiis", $insertedID, $investigationID, $collectedBy, $summary);
        $log->execute();
        $log->close();

        header("Location: evidence.php");
        exit();
    } else {
        echo "Error inserting evidence: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

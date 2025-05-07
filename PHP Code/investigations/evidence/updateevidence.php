<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'dbconn.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evidenceID = $_POST['evidenceID'];
    $investigationID = $_POST['InvestigationID'];
    $evidenceType = $_POST['EvidenceType'];
    $description = $_POST['Description'];
    $dateCollected = $_POST['DateCollected'];
    $dateInvoiced = $_POST['DateInvoiced'];
    $collectedBy = $_POST['CollectedBy'];

    //old values 
    $stmt = $conn->prepare("SELECT * FROM evidence WHERE evidenceID = ?");
    $stmt->bind_param("i", $evidenceID);
    $stmt->execute();
    $result = $stmt->get_result();
    $old = $result->fetch_assoc();
    $stmt->close();

    //COMPARE AND LOG
    $changes = [];

    if ($old['InvestigationID'] != $investigationID) {
        $changes[] = "InvestigationID: \"{$old['InvestigationID']}\" → \"$investigationID\"";
    }
    if ($old['EvidenceType'] != $evidenceType) {
        $changes[] = "EvidenceType: \"{$old['EvidenceType']}\" → \"$evidenceType\"";
    }
    if ($old['Description'] != $description) {
        $changes[] = "Description: \"{$old['Description']}\" → \"$description\"";
    }
    if ($old['DateCollected'] != $dateCollected) {
        $changes[] = "DateCollected: \"{$old['DateCollected']}\" → \"$dateCollected\"";
    }
    if ($old['DateInvoiced'] != $dateInvoiced) {
        $changes[] = "DateInvoiced: \"{$old['DateInvoiced']}\" → \"$dateInvoiced\"";
    }
    if ($old['CollectedBy'] != $collectedBy) {
        $changes[] = "CollectedBy: \"{$old['CollectedBy']}\" → \"$collectedBy\"";
    }

    $changesMade = implode(", ", $changes);

  
    $stmt = $conn->prepare("UPDATE evidence SET InvestigationID = ?, EvidenceType = ?, Description = ?, DateCollected = ?, DateInvoiced = ?, CollectedBy = ? WHERE evidenceID = ?");
    $stmt->bind_param("isssssi", $investigationID, $evidenceType, $description, $dateCollected, $dateInvoiced, $collectedBy, $evidenceID);
    $stmt->execute();
    $stmt->close();

    //LOG
    if (!empty($changesMade)) {
        $stmt = $conn->prepare("INSERT INTO evidenceauditlog (EvidenceID, InvestigationID, CollectedBy, ValuesChanged) VALUES (?, ?, ?, ?)");
        $log->bind_param("iiis", $evidenceID, $investigationID, $collectedBy, $ValuesChanged);
        $log->execute();
        $log->close();
    }

    header("Location: evidence.php");
    exit();
} else {
    echo "Invalid request.";
}
?>

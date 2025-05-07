<?php
include "dbconn.php";

if (!isset($_GET['id'])) {
    die("Error: Evidence ID not specified.");
}

$evidenceID = intval($_GET['id']);


$fetch = $conn->prepare("SELECT * FROM evidence WHERE evidenceID = ?");
$fetch->bind_param("i", $evidenceID);
$fetch->execute();
$result = $fetch->get_result();

if ($result->num_rows === 0) {
    die("Error: Evidence not found.");
}

$evidence = $result->fetch_assoc();
$fetch->close();

//Log deletion
$valuesChanged = "DELETED: Type={$evidence['EvidenceType']}, Description={$evidence['Description']}, DateCollected={$evidence['DateCollected']}, DateInvoiced={$evidence['DateInvoiced']}";

$log = $conn->prepare("INSERT INTO evidenceauditlog (EvidenceID, InvestigationID, CollectedBy, ValuesChanged, UpdatedAt) VALUES (?, ?, ?, ?, NOW())");
$log->bind_param("iiis", $evidenceID, $evidence['InvestigationID'], $evidence['CollectedBy'], $valuesChanged);
$log->execute();
$log->close();

$stmt = $conn->prepare("DELETE FROM evidence WHERE evidenceID = ?");
$stmt->bind_param("i", $evidenceID);

if ($stmt->execute()) {
    header("Location: evidence.php");
    exit();
} else {
    echo "Error deleting evidence: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

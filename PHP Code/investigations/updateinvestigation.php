<?php
include "dbconn.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $investigationID = $_POST['InvestigationID'];
    $startDate = $_POST['StartDate'];
    $endDate = $_POST['EndDate'] ?? null;
    $status = $_POST['CaseStatus'];
    $allegation = $_POST['PrimaryAllegation'];
    $investigatorID = $_POST['InvestigatorID'];
    $disposition = $_POST['Disposition'] ?? null;
    $dispositionDate = $_POST['DispositionDate'] ?? null;

    //current data
    $stmt = $conn->prepare("SELECT * FROM investigations WHERE InvestigationID = ?");
    $stmt->bind_param("i", $investigationID);
    $stmt->execute();
    $original = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    //update
    $stmt = $conn->prepare("UPDATE investigations SET StartDate=?, EndDate=?, CaseStatus=?, PrimaryAllegation=?, InvestigatorID=?, Disposition=?, DispositionDate=? WHERE InvestigationID=?");
    $stmt->bind_param("sssssssi", $startDate, $endDate, $status, $allegation, $investigatorID, $disposition, $dispositionDate, $investigationID);
    $stmt->execute();
    $stmt->close();


    $changes = [];
    foreach (['StartDate', 'EndDate', 'CaseStatus', 'PrimaryAllegation', 'InvestigatorID', 'Disposition', 'DispositionDate'] as $field) {
        if ($original[$field] != $$field) {
            $changes[$field] = ['from' => $original[$field], 'to' => $$field];
        }
    }

    if (!empty($changes)) {
        $changeText = json_encode($changes, JSON_PRETTY_PRINT);
        $stmt = $conn->prepare("INSERT INTO investigationauditlog (InvestigationID, InvestigatorID, CaseNumber, ValuesChanged) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $investigationID, $investigatorID, $original['CaseNumber'], $changeText);
        $stmt->execute();
        $stmt->close();
    }

   
    $conn->query("DELETE FROM investigation_subjects WHERE InvestigationID = $investigationID");

    if (!empty($_POST['subjects'])) {
        foreach ($_POST['subjects'] as $subjectID => $role) {
            $cleanRole = trim($role);
            if ($cleanRole !== '') {
                $stmt = $conn->prepare("INSERT INTO investigation_subjects (InvestigationID, EmployeeID, Role) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $investigationID, $subjectID, $cleanRole);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    header("Location: indexinvestigations.php");
    exit;
} else {
    echo "Invalid request.";
}
?>

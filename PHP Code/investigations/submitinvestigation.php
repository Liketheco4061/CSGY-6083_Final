<?php
include "dbconn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $investigationID = $_POST["investigationID"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"] ?? null;
    $caseStatus = $_POST["caseStatus"];
    $investigator = $_POST["assignedInvestigator"];
    $primaryAllegation = $_POST["primaryAllegation"];

    $disposition = ($caseStatus === "Closed") ? ($_POST["disposition"] ?? null) : null;
    $dispositionDate = ($caseStatus === "Closed") ? ($_POST["dispositionDate"] ?? null) : null;

    $stmt = $conn->prepare("UPDATE investigations 
        SET StartDate = ?, EndDate = ?, CaseStatus = ?, employees_employeeID = ?, 
            PrimaryAllegation = ?, Disposition = ?, DispositionDate = ? 
        WHERE InvestigationID = ?");
    $stmt->bind_param("sssssssi", 
        $startDate, $endDate, $caseStatus, $investigator, 
        $primaryAllegation, $disposition, $dispositionDate, $investigationID);
    $stmt->execute();
    $stmt->close();

    if (!empty($_POST["existingSubjects"])) {
        foreach ($_POST["existingSubjects"] as $subjectData) {
            $subjectID = $subjectData["subjectID"];
            $role = $subjectData["role"];
            $notes = $subjectData["notes"];

            if (isset($subjectData["remove"])) {
                $delStmt = $conn->prepare("DELETE FROM subjects WHERE SubjectID = ?");
                $delStmt->bind_param("i", $subjectID);
                $delStmt->execute();
                $delStmt->close();
            } else {
                $updateStmt = $conn->prepare("UPDATE subjects SET Role = ?, Notes = ? WHERE SubjectID = ?");
                $updateStmt->bind_param("ssi", $role, $notes, $subjectID);
                $updateStmt->execute();
                $updateStmt->close();
            }
        }
    }

 
    if (!empty($_POST["newSubjects"])) {
        $insertStmt = $conn->prepare("INSERT INTO subjects (InvestigationID, EmployeeID, Role, Notes) VALUES (?, ?, ?, ?)");
        foreach ($_POST["newSubjects"] as $newSubj) {
            $employeeID = $newSubj["employeeID"];
            $role = $newSubj["role"];
            $notes = $newSubj["notes"] ?? "";

            if (!empty($employeeID)) {
                $insertStmt->bind_param("iiss", $investigationID, $employeeID, $role, $notes);
                $insertStmt->execute();
            }
        }
        $insertStmt->close();
    }

    $conn->close();
    header("Location: investigations.php?updated=" . time());
    exit();
} else {
    echo "Invalid request.";
}
?>

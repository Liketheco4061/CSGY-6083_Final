<?php
include "dbconn.php";

$id = intval($_GET['id']);
$conn->query("DELETE FROM firearms WHERE firearmID = $id");
$conn->close();

header("Location: firearms.php");
exit();

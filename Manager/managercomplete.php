<?php
include '../database.php';
session_start();
$userid = $_SESSION['admin_id'];
$id_selection = $_GET ['id_selection'];
$sql = "UPDATE format_audit SET staudit = 'complete',finishdate = GETDATE() ,manager_complete = '$userid'WHERE ID = '$id_selection'";
$stmt  = sqlsrv_query($conn, $sql); 
header('Location:date_select.php');
?>
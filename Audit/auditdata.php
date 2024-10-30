<?php
include '../database.php';
session_start();
$admin = $_SESSION['admin'];
$adminid = $_SESSION['admin_id'];


$id_selection = $_SESSION['id_selection'];
$ID = $_POST['ID'];
if(isset($_POST['idcard'])){
    $employeeId = $_POST['idcard'];
    $check = $_POST['check'];
    $locker = $_POST['Lockernumber'];
    if($check === 'all'){
    $check1 = 1;
    $check2 = 1;
    $check3 = 1;
    $check4 = 1;
    $check5 = 1;
    $check6 = 1;
    $check7 = 1;
    $check8 = 1;
    $check9 = 1;
    $check10 =1;

}
else{
    $check1 = isset($_POST['check1'])?$_POST['check1']:'1';
    $check2 = isset($_POST['check2'])?$_POST['check2']:'1';
    $check3 = isset($_POST['check3'])?$_POST['check3']:'1';
    $check4 = isset($_POST['check4'])?$_POST['check4']:'1';
    $check5 = isset($_POST['check5'])?$_POST['check5']:'1';
    $check6 = isset($_POST['check6'])?$_POST['check6']:'1';
    $check7 = isset($_POST['check7'])?$_POST['check7']:'1';
    $check8 = isset($_POST['check8'])?$_POST['check8']:'1';
    $check9 = isset($_POST['check9'])?$_POST['check9']:'1';
    $check10 = isset($_POST['check10'])?$_POST['check10']:'1';
}
$sql = "SELECT * FROM locker_employee WHERE idcard = ? ";
$params = array($employeeId);
$stmt =sqlsrv_query($conn,$sql,$params);
while ($row =sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $sql2 = "UPDATE check_audit SET check1= ? ,check2= ? ,check3= ? ,check4= ? ,check5= ? ,check6= ? ,check7= ? ,
    check8 = ?,check9= ? ,other= ? WHERE ID ='$ID'";
    $params2 = array($check1,
    $check2,$check3,$check4,$check5,$check6,$check7,$check8,$check9,$check10);
    $stmt2 =sqlsrv_query($conn,$sql2,$params2);

    $sql2 = "UPDATE AuditData SET enddate = GETDATE(),auditname = '$admin',auditerid = '$adminid'WHERE ID ='$ID'";
    $stmt2 =sqlsrv_query($conn,$sql2);
    echo $check1.
$check2 .
$check3 .
$check4 .
$check5 .
$check6 .
$check7 .
$check8 .
$check9 .
$check10.
$ID;
}
if(isset($_POST["submit"])) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $filePath = $target_file;

        $sql = "INSERT INTO uploaded_files (file_name, file_path,format_id,lockernumber) VALUES (?, ?,?,?)";
        $params = array($_FILES["fileToUpload"]["name"], $filePath,$id_selection,$locker);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "Error: " . $sql . "<br>" . sqlsrv_errors();
        } else {
            echo "File uploaded successfully.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}
if(isset($_POST['comment'])){
$text = $_POST['comment'];
// $sql = "SELECT format_comment FROM format_audit WHERE ID = '$id_selection";
// $stmt = sqlsrv_query($conn, $sql);
// $row =sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// $text = $row['format_comment'].$text;
$sql = "UPDATE  format_audit SET  format_comment = ?  WHERE ID = '$ID'";
$params = array($text);
$stmt = sqlsrv_query($conn, $sql,$params);
echo $text.$ID;
}
sqlsrv_close($conn);
header("Location:auditShow.php?id_selection=$id_selection");
?>
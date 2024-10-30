<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table, th, td{
        border: 1px solid black;
        padding: 5px;
        border-collapse: collapse;
        text-align: center;
    }
    .header {
        text-align: center;
        margin-bottom: 5px;
        font-weight: bold;
    }
</style>
<?php
include '../database.php';

$headtext="";

if(isset($_GET['option1'])){
    $type =$_GET['option1'];
}
if(isset($_GET['option2'])){
    $build = $_GET['option2'];
}
if(isset($_GET['option3'])){
    $sex = $_GET['option3'];
}
?>
<body>
    <table width="100%">
        <thead>
            <tr>
                <th width="10%">รหัสล็อคเกอร์</th>
                <th width="10%">รหัสพนง.</th>
                <th width="30%" colspan="3">ชื่อ-นามสกุล</th>
                <th width="10%">รหัสแผนก</th>
                <th width="15%">แผนก</th>
                <th width="5%">เพศ</th>
                <th width="10%">ลงชื่อ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Data_locker WHERE LockerNumber IS NOT NULL ";
            if(!empty($_GET['option1'])){
                $sql.= "AND TypeLocker = '$type'";
            }
            if(!empty($_GET['option2'])){
                $sql .= "AND LockerNumber LIKE '$build%'";
            }
            if(!empty($_GET['option3'])){
                $sql .= "AND InitialT LIKE '$sex%'";
            }
            
            $sql .= " ORDER BY LockerNumber ASC";
            
            $stmt = sqlsrv_query($conn, $sql);
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {


                echo "<tr>";
                echo "<td>{$row['LockerNumber']}</td>";
                echo "<td>{$row['idcard']}</td>";
                
                echo "<td>{$row['InitialT']}</td>";
                echo "<td>{$row['namethai']}</td>";
                echo "<td>{$row['surnamethai']}</td>";
                if(trim($row['InitialT']) === 'นาย'){
                    $insex = 'ชาย';
                }
                else{
                    $insex = 'หญิง';
                }
                echo "<td>{$row['departmentno']}</td>";
                echo "<td>{$row['departmentname']}</td>";
                echo "<td>{$insex}</td>";
                echo "<td></td>";
                   
                
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
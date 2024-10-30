<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
    <script type="text/javascript">
    function ExcelReport() {
        var sheet_name = "report_customer_complaint";
        var elt = document.getElementById('data'); // ตั้งชื่อ id ให้เป็น 'data' เพื่อรับตารางข้อมูล

        var wb = XLSX.utils.table_to_book(elt, {
            sheet: sheet_name
        });

        /* เพิ่มช่องหมายเหตุ */
        var ws = wb.Sheets[sheet_name];
        var range = XLSX.utils.decode_range(ws['!ref']);
        range.e.r++; // เพิ่มหนึ่งแถวสำหรับช่องหมายเหตุ
        var new_cell_ref = XLSX.utils.encode_cell({r: range.e.r, c: 0}); // สร้างอ้างอิงเซลล์ใหม่
        ws[new_cell_ref] = { t: "s", v: "Comments:" }; // กำหนดข้อความในเซลล์

        XLSX.writeFile(wb, 'report_locker.xlsx');
    }
</script>
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
    <table width="100%" id ='data'>
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
    <script>
        ExcelReport();
        window.close();
    </script>
</body>
</html>
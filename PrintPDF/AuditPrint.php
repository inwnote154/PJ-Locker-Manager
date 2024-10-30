<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table{
        border: none;
        border-collapse: collapse;
    }
    th, td{
        border: 1px solid black;
        padding: 5px;
        border-collapse: collapse;
    }
    td{
        text-align: center;
    }
    .lposition{
        text-align: left;
    }
    .rotation{
        vertical-align: bottom;
    }
    .test{
        margin: 0;
        padding: 0;
    }
    .test th,.test tr{
        padding: 0;
        border: none;
    }
</style>
<body>
    <!-- <header name="header">
        sadasd
    </header> -->
    <!-- <footer name="footer">
        sadasdasdasd
    </footer> -->
    <!-- text-rotate="90" -->
    <table width="100%">
        <thead>
            <tr>
                <th width="7%">ลำดับที่</th>
                <th width="10%">หมายเลข ล็อคเกอร์</th>
                <th width="33%" class="lposition">รหัสแผนกและรหัสพนักงาน หรือ ชื่อนามสกุล พนักงานที่สุ่มตรวจ</th>
                <th text-rotate="90" width="5%" class="rotation">1. ไม่มีสัตว์พาหะอยู่ในล็อคเกอร์</th>
                <th text-rotate="90" width="5%" class="rotation">2. ห้ามติดสติกเกอร์ใดๆ ที่ตู้ล็อคเกอร์</th>
                <th text-rotate="90" width="5%" class="rotation">3. ห้ามนำจาน-ชามของบริษัทฯมาเก็บในตู้ล็อคเกอร์</th>
                <th width="5%" class="rotation">
                    <div class="test">
                        <table class="test" width="100%">
                            <tr text-rotate="90">
                                <th>4. ห้ามนำสิ่งของทุกชนิดมาเก็บไว้ในตู้ล็อคเกอร์ว่าง</th>
                                <th> </th>
                                <th>หรือตู้ล็อคเกอร์ของผู้อื่นโดยไม่ได้รับอนุญาต</th>
                            </tr>
                        </table>
                    </div>
                    <!-- 4. ห้ามนำสิ่งของทุกชนิดมาเก็บไว้ในตู้ล็อคเกอร์ว่าง หรือตู้ล็อคเกอร์ของผู้อื่นโดยไม่ได้รับอนุญาต -->
                </th>
                <th text-rotate="90" width="5%" class="rotation">5. ห้ามนำอาหารและเครื่องดื่มเข้ามาเก็บในตู้ล็อคเกอร์</th>
                <th text-rotate="90" width="5%" class="rotation">6. ห้ามรับประทานอาหารและเครื่องดื่มภายในห้องแต่งตัว</th>
                <th text-rotate="90" width="5%" class="rotation">7. ห้ามนำสินค้าทุกชนิดมาจำหน่ายในห้องแต่งตัว</th>
                <th text-rotate="90" width="5%" class="rotation">8. ห้ามงัดและเคลื่อนย้ายตู้ล็อคเกอร์</th>
                <th text-rotate="90" width="5%" class="rotation">9. สภาพตู้ล็อคเกอร์ไม่ชำรุด</th>
                <th text-rotate="90" width="5%" class="rotation">อื่นๆ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <?php
            include '../database.php';
            $count = 0;

            if (isset($_GET['id_selection'])) {
                $id_selection = $_GET['id_selection'];
            }
            $item = 15;
            $page = 1;
            $sql = "SELECT COUNT(*) AS total FROM AuditData1 
            WHERE format_id = '$id_selection'";
            $stmt = sqlsrv_query($conn,$sql);
            $totalitem = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            $totalpage  = ceil($totalitem['total']/$item);
            for ($i = 1; $i <= $totalpage; $i++) {
            $offset = ($page - 1) * $item;
            $sql3 = "SELECT AuditData1.*,building.* FROM AuditData1 
            LEFT JOIN building ON AuditData1.build = building.building_id 
            WHERE format_id = '$id_selection' 
            ORDER BY idcard OFFSET $offset ROWS FETCH NEXT $item ROWS ONLY "; 
            $stmt2 = sqlsrv_query($conn, $sql3);
            $row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
            $entryDate = $row['createdate'] !== null ? $row['createdate']->format('Y-m-d H:m:s') : ''; // ตรวจสอบ EntryDate ก่อนใช้ format()
            $exitDate = $row['enddate'] !== null ? $row['enddate']->format('Y-m-d H:m:s ') : ''; // ตรวจสอบ ExitDate ก่อนใช้ format()
            echo $entryDate.'-'.$exitDate .$row['typeaudit'].$row['sex'];
            $stmt3 = sqlsrv_query($conn,$sql3);
            $rowcount = 0;
                while ($row = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
                    $count++;
                    $entryDate = $row['startdate'] !== null ? $row['startdate']->format('Y-m-d ') : ''; // ตรวจสอบ EntryDate ก่อนใช้ format()
                    $exitDate = $row['enddate'] !== null ? $row['enddate']->format('Y-m-d ') : ''; // ตรวจสอบ ExitDate ก่อนใช้ format()
                    echo "<tr class='border-end border-start p-2'><td class='border-end border-start p-2'>" .$count . "</td>";
                    echo "<td class='border-end border-start p-2'>" . $row['lockernumber'] . "</td>";
                    echo "<td class='border-end border-start p-2'>" . $row['departmentno'] ." - ". $row['idcard'] . "</td>";
                    if($row['check1']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check1']===0 ){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check2']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check2']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check3']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check3']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check4']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check4']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check5']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check5']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check6']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check6']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check7']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check7']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check8']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check8']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['check9']===1){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['check9']===0){
                        echo"<td><center>X</center></td>";
                    }else{echo"<td><center></td>";}
                    if($row['other']==='1' || $row['other']=== ""){
                        echo"<td><center>/</center></td>";
                    }
                    elseif($row['other']){echo"<td><center>X</center></td>";}
                    else{
                        echo"<td></td>";
                    }
                    
                    $rowcount++;
                }
                if ($rowcount < $item) {
                    // สร้างตารางว่างเพิ่มเติมเพื่อครบ 15 บรรทัด
                    for ($j = 0; $j < ($item - $rowcount); $j++) {
                        echo "<tr><td> </td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td>"; // สร้างคอลัมน์ว่าง
                        echo "<td></td></tr>"; // สร้างคอลัมน์ว่าง

                        // ... สร้างคอลัมน์ว่างอื่นๆ ตามต้องการ
                    }
                }
                $page++;
                // แสดงลิงก์สำหรับการเปลี่ยนหน้า
            } 
                ?>
            </tr>
        </tbody>
    </table>
</body>
</html>
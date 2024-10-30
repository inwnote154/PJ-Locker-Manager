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

        XLSX.writeFile(wb, 'report_department.xlsx');
    }
</script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
        table, th, td{
            border: 1px solid black;
            padding: 5px;
            border-collapse: collapse;
            text-align: center;
        }
        .name{
            text-align: left;
        }
    </style>
</head>
<body>
    <!-- <header name="header">
        <div>รายชื่อพนักงานแผนก <?php echo $_GET['department_id'] ?> วันที่ ..................................................................... เวลา .....................................................................</div>
    </header> -->
    <?php
        include '../database.php';
    ?>

    <!-- <div class="header">asdsa</div> -->
    <table width="100%" id ='data'>
        <thead>
            <tr>
                <th width="6%">ลำดับ</th>
                <th width="16%">แผนก</th>
                <th width="7%">รหัส</th>
                <th width="8%">คำนำหน้า</th>
                <th width="22%" colspan="2">ชื่อ-นามสกุล</th>
                <th width="8%">ล็อคเกอร์</th>
                <th width="8%">บัดดี้</th>
                <th width="8%">กลับบ้าน</th>
                <th width="17%">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../database.php';
            $department_id = $_GET['department_id'];
            if(isset($_GET['employee_id'])){
                $employee_id = $_GET['employee_id'];
            }
            $sql = "SELECT 
            t.idcard,
            STUFF((SELECT ', ' + LockerNumber FROM ALL_employee_locker WHERE TypeLocker = 'buddy' AND idcard = t.idcard FOR XML PATH('')), 1, 2, '') AS buddys,
            STUFF((SELECT ', ' + LockerNumber FROM ALL_employee_locker WHERE TypeLocker = 'out' AND idcard = t.idcard FOR XML PATH('')), 1, 2, '') AS outs,
            STUFF((SELECT ', ' + LockerNumber FROM ALL_employee_locker WHERE TypeLocker = 'shirt' AND idcard = t.idcard FOR XML PATH('')), 1, 2, '') AS shirts, 
            t.namethai,
            t.surnamethai,
            t.departmentno,
            t.departmentname,
            t.linename,
            InitialT,
            t.startdate,
            stemployee
            FROM (SELECT DISTINCT idcard, namethai, surnamethai, departmentno, departmentname, linename,InitialT,startdate,stemployee FROM ALL_employee_locker) AS t
            WHERE stemployee ='ok' AND departmentno = ?
            "; 

            if(!empty($employee_id)){
                $selec = explode(',',$employee_id);
                $sql.= "AND idcard IN ('" . implode("','", $selec) . "') ";
            }
            
            $sql.= "ORDER BY idcard ASC";
            $params = array($department_id);
            $stmt = sqlsrv_query($conn, $sql, $params);

            // Display data in table format
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            $i=1;
            // echo calsex($row['InitialT'])."test";
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {


                echo "<tr>";
                echo "<td>{$i}</td>";
                echo "<td>{$row['departmentname']}</td>";
                echo "<td>{$row['idcard']}</td>";
                if(trim($row['InitialT'])=='นาย'){
                    $sex = 'ชาย';
                }
                else{
                    $sex = 'หญิง';
                }

                echo "<td>".$row['InitialT']."</td>";
                echo "<td class='name'>{$row['namethai']}</td>";
                echo "<td class='name'>{$row['surnamethai']}</td>";
                echo "<td>{$row['shirts']}</td>";
                echo "<td>{$row['buddys']}</td>";
                echo "<td>{$row['outs']}</td>";
                echo "<td></td>";
            
                   
                
                echo "</tr>";
                $i++;
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
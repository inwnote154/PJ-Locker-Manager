

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
  </head>
  <body class="bg-light">
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
    <script>
        function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
        {
            var sheet_name = "report_customer_complaint"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
            var elt = document.getElementById('mytable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

            /*------สร้างไฟล์ excel------*/
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: sheet_name
            });
            XLSX.writeFile(wb, 'report_customer_complaint.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
        }

        // function ExcelReport_month(idtable) //function สำหรับสร้าง ไฟล์ excel จากตาราง
        // {
        //     var sheet_name = "customer_complaint_monthly"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
        //     var elt = document.getElementById(idtable); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

        //     /*------สร้างไฟล์ excel------*/
        //     var wb = XLSX.utils.table_to_book(elt, {
        //         sheet: sheet_name
        //     });
        //     XLSX.writeFile(wb, 'customer_complaint_monthly.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
        // }
    </script>

    <form class="d-flex" action="lockerout.php" method="post">
      <div class="col" >
          <div class="d-flex">
            <?php
            // $admin = $_GET['admin'];
            include 'config.php';
            ?>
            <!-- <label for="" class="form-label">Inline Form</label> -->
              
          </div>
      </div>
    </form>
    <div class="d-flex">
      <div class="m-3 w-100">ที่เก็บรองเท้าภายนอก</div>
      <div class="m-2 d-flex w-25">
        <div class=" w-50 me-1"><button class="w-100 btn btn-outline-primary rounded-5" type = "button" onclick="javascript:ExcelReport();">?????</button></div>
        <div class=" w-50 ms-1"><a href="lockerout.php"><button class="w-100 btn btn-outline-danger rounded-5" type = "button">ย้อนกลับ</button></a></div>
      </div>
    </div>
    <?php
    
      include 'database.php';
      $selection = "";
      $build = "";
      $stat = "";
      $status = "";
      
if (isset($_POST['search'])){
    $selection = $_POST['search'];
    $build = $_POST["build"];
}
if (isset($_POST['status'])){
  $status = $_POST['status'];
}


      if( $conn ) {
          $sql = "SELECT locker_out.*,building.*
          FROM locker_out
          left JOIN building ON locker_out.build_id = building.building_id
          WHERE locker_out.out_number IS NOT NULL
              ";
          
          if($selection === ""){ 
              $stmt = sqlsrv_query($conn, $sql);
          }
          
          elseif ($selection !== NULL){
              $sql .= " AND out_number LIKE '%$selection'";     
              $stmt = sqlsrv_query($conn, $sql );
          }
          if ($build !== ""){
              $sql .= " AND build_id = ?";     
              $params = array($build);
              $stmt = sqlsrv_query($conn, $sql, $params );
          }
          if ($status === "ว่าง"){
            $sql .= " AND UsStatus = ?";     
            $params = array($stat);
            $stmt = sqlsrv_query($conn, $sql, $params );
          }
          elseif ($status === "ชำรุด"){
            $sql .= " AND UsStatus = ?";     
            $params = array($stat);
            $stmt = sqlsrv_query($conn, $sql, $params );
        }
          
          if ($stmt !== false) {
              echo '';
              $headerPrinted = false;
              echo "<table id='mytable' class='container-fluid ps-4 pe-4'>";
              echo "<tr class='text-center border'>
              <th class='w-25 border-end border-start p-2'>รหัสตู้</th>
              <th class='w-25 border-end border-start p-2'>จำนวนที่ว่าง</th>
              <th class='w-25 border-end border-start p-2'>สถานะ</th>
              <th class='w-25 border-end border-start p-2'>เจ้าของ</th>
              <th class='w-25 border-end border-start p-2'>อาคาร</th>
              <th class='w-25 border-end border-start p-2'> หมายเหตุ</th>
              </tr>";
              while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
                $name='';
                  echo "<tr>";
                  echo "<td class=' border-end border-start p-2'>" . $row['out_number'] . "</td>";
                  echo "<td class=' border-end border-start p-2'>" . $row['status_out'] . "</td>";
                  echo "<td class=' border-end border-start p-2'>" . $row['UsStatus'] . "</td>";
                  $sql2 = "SELECT Accesslog.*,locker_employee.*
                  FROM Accesslog
                  left JOIN locker_employee ON Accesslog.EmployeeID = locker_employee.idcard
                  WHERE Accesslog.StatusEm = 'active' AND Accesslog.LockerNumber = '$row[out_number]' AND Accesslog.TypeLocker = 'out'";
                  $stmt2 = sqlsrv_query($conn, $sql2);
                  echo"<td class=' border-end border-start p-2'>" ;
                  while ($row2 = sqlsrv_fetch_array($stmt2,SQLSRV_FETCH_ASSOC)){
                    $name .= $row2['namethai']." " .$row2['surnamethai'].",";
                  }
                  $new_name = substr($name,0,-1);
                  echo $new_name;
                  echo  "</td>";
                  echo "<td class=' border-end border-start p-2'>" . $row['building_name'];
                  echo "</td></tr>";
              }
              echo "</table>";
      } else {
              echo "ไม่สามารถดึงข้อมูลได้: " . print_r(sqlsrv_errors(), true);
          }

          // ปิดการเชื่อมต่อ
          sqlsrv_close($conn);
      } else {
          echo "การเชื่อมต่อไม่สำเร็จ";
      }
    ?>

  </body>
</html>

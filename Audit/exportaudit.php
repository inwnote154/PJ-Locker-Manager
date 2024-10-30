<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
  </head>
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
  <body class="bg-light">
    <?php
    include 'database.php';
    if (isset($_POST['selection'])){
        $selection = $_POST['selection'];
        $build = $_POST['build'];
        $type = $_POST['type'];
        $sex = $_POST['sex'];
    }
    if (isset($_GET['selection'])){
        $selection = $_GET['selection'];
        $build = $_GET['build'];
        $type = $_GET['type'];
        $sex = $_GET['sex'];
    }
    
    echo'<div class="d-flex">
        <form action="auditfinish.php" method="post">
            <input type="hidden" name="sex"         id="sex"          value='.$sex.'>
            <input type="hidden" name="type"        id="type"         value='.$type.'>
            <input type="hidden" name="build"       id="build"        value='.$build.'>
            <input type="hidden" name="selection"   id="selection"    value='.$selection.'>
            <button type="submit" class="mb-3 m-0 p-0 pe-2 ps-2 btn btn-outline-primary rounded-5">ยืนยันการตรวจสอบ</button>
        </form>';
    echo'
        <button type = "button" onclick="javascript:ExcelReport();" class="mb-3 m-0 p-0 pe-2 ps-2 btn btn-outline-primary rounded-5">ปริ้น</button>
    </div>
    ';
      $test = 0;
      $order = '';

      if( $conn ) {
        // echo $build;
          
              if ($type !== NULL){
                  if ($type === 'buddy'){
                    $sql ="SELECT locker_employee.*,buddy_locker.*,building.*,Accesslog.*,department.*
                    FROM buddy_locker
                    left JOIN Accesslog ON Accesslog.LockerNumber = buddy_locker.buddy_number
                    left JOIN locker_employee ON  Accesslog.EmployeeID= locker_employee.idcard
                    left JOIN building ON buddy_locker.build_id = building.building_id
                    left JOIN department ON locker_employee.departmentid = department.departmentno
                    WHERE  Accesslog.StatusEm = 'active' AND Accesslog.TypeLocker = 'buddy' ";
                    $order = 'ORDER BY buddy_number ASC';

                    
              }
                  elseif ($type === 'shirt'){
                    $sql ="SELECT locker_employee.*,locker_shirt.*,department.*,Accesslog.* ,building.*
                    FROM locker_shirt
                    left JOIN Accesslog ON Accesslog.LockerNumber = locker_shirt.shirt_number
                    left JOIN locker_employee ON  Accesslog.EmployeeID= locker_employee.idcard
                    left JOIN building ON locker_shirt.build_id = building.building_id
                    left JOIN department ON locker_employee.departmentid = department.departmentno
                    WHERE  Accesslog.StatusEm = 'active' AND Accesslog.TypeLocker = 'shirt'  ";
                    $order = 'ORDER BY shirt_number ASC';

                      
              }
                  elseif ($type === 'out'){
                    $sql ="SELECT locker_employee.*,locker_out.*,department.*,Accesslog.* ,building.*
                    FROM locker_out
                    left JOIN Accesslog ON Accesslog.LockerNumber = locker_out.out_number
                    left JOIN locker_employee ON  Accesslog.EmployeeID= locker_employee.idcard
                    left JOIN building ON locker_out.build_id = building.building_id
                    left JOIN department ON locker_employee.departmentid = department.departmentno
                    WHERE  Accesslog.StatusEm = 'active' AND Accesslog.TypeLocker = 'out'   ";
                    $order = 'ORDER BY out_number ASC';
          }
              
              }
              if ($build !== NULL){
                  $sql .="AND building_id = '$build'";
              }

              if ($sex !== NULL){
                  $sql .=" AND InitialT LIKE '$sex%' ";        
                  $params[] = '' ; 
              }
              $sql .= $order;
              $stmt = sqlsrv_query($conn, $sql );
          
          if ($stmt !== false) {
              echo '<table class="border">';
              $headerPrinted = false;
              echo "<table id='mytable' class='container-fluid ps-4 pe-4 border'>";
              echo "<tr class='text-center border'><th class='border-end border-start p-2'>idcard</th><th class='border-end border-start p-2'>buddy_number</th><th class='border-end border-start p-2'>InitialT</th><th class='border-end border-start p-2'>namethai</th><th class='border-end border-start p-2'>surnamethai</th>
              <th class='border-end border-start p-2'>departmentid</th><th class='border-end border-start p-2'>departmentname</th><th class='border-end border-start p-2'>lineid</th>
              <th class='border-end border-start p-2'>1. ไม่มีสัตว์พาหะอยู่ในล็อคเกอร์</th>
              <th class='border-end border-start p-2'>2. ห้ามติดสติกเกอร์ใดๆ ที่ตู้ล็อคเกอร์</th>
              <th class='border-end border-start p-2'>3. ห้ามนำจาน-ชามของบริษัทฯมาเก็บในตู้ล็อคเกอร์</th>
              <th class='border-end border-start p-2'>4. ห้ามนำสิ่งของทุกชนิดมาเก็บไว้ในตู้ล็อคเกอร์ว่าง หรือตู้ล็อคเกอร์ของผู้อื่นโดยไม่ได้รับอนุญาต</th>
              <th class='border-end border-start p-2'>5. ห้ามนำอาหารและเครื่องดื่มเข้ามาเก็บในตู้ล็อคเกอร์</th>
              <th class='border-end border-start p-2'>6. ห้ามรับประทานอาหารและเครื่องดื่มภายในห้องแต่งตัว</th>
              <th class='border-end border-start p-2'>7. ห้ามนำสินค้าทุกชนิดมาจำหน่ายในห้องแต่งตัว</th>
              <th class='border-end border-start p-2'>8. ห้ามงัดและเคลื่อนย้ายตู้ล็อคเกอร์</th>
              <th class='border-end border-start p-2'>9. สภาพตู้ล็อคเกอร์ไม่ชำรุด</th>
              <th class='border-end border-start p-2'>อื่นๆ</th>
              </tr>";
              while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td class='border-end border-start p-2'>" . $row['idcard'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['LockerNumber'] . "</td>";
                //echo "<td class='border-end border-start p-2'>" . $row['buddy_number'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['InitialT'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['namethai'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['surnamethai'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['departmentid'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['departmentname'] . "</td>";
                echo "<td class='border-end border-start p-2'>" . $row['lineid'] . "</td>";
                  
              
                
      
                echo "</tr>";
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
    
    
    <script>
        function showSubmit() {
            // Display the popup
            document.getElementById("popup-Submit").style.display = "block";
        }

        function hideSubmit() {
            // Hide the popup
            document.getElementById("popup-Submit").style.display = "none";
        }
        function showPopup() {
            // Display the popup
            document.getElementById("popup-container").style.display = "block";
        }

        function hidePopup() {
            // Hide the popup
            document.getElementById("popup-container").style.display = "none";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

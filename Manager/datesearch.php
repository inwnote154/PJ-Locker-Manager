<?php
// กำหนดค่าเชื่อมต่อกับฐานข้อมูล MSSQL
include '../database.php';

// เช็คการเชื่อมต่อ
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// กำหนดวันที่เริ่มต้นและสิ้นสุด
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$type = $_POST['type'];
$build = $_POST['building'];
$selection = $_POST['format'];
// สร้าง SQL query สำหรับการค้นหาข้อมูลในช่วงวันที่
$sql = "SELECT * FROM format_audit WHERE createdate BETWEEN ? AND ? AND selection = '$selection'AND typeaudit = '$type' AND (staudit = 'ok' or staudit='complete') ";
if(!empty($_POST['building'])){
    $sql.= "AND build = '$build'";
}


$sql.="ORDER BY ID DESC";
$params = array($startDate, $endDate);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// วนลูปแสดงผลลัพธ์
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    //echo "Column1: " . $row['createdate'] . "<br />";
    if($row['sex']==='นาย'){
        $intitail = 'ชาย';
    }
    elseif($row['sex']==='นาง'){
        $intitail = 'หญิง';
    }
    if($row['build'] === '1'){
        $buildname = 'A';
    }
    elseif($row['build'] === '2'){
        $buildname = 'B';
    }
    elseif($row['build'] === '3'){
        $buildname = 'C';
    }
    elseif($row['build'] === '4'){
        $buildname = 'D';
    }
    elseif($row['build'] === '5'){
        $buildname = 'E';
    }
    elseif($row['build'] === '6'){
        $buildname = 'F';
    }
    if($row['typeaudit']==='buddy'){
        $type = 'รองเท้าบัดดี้';
    }
    elseif($row['typeaudit']==='out'){
        $type = 'รองเท้าใส่นอกอาคาร';
    }
    elseif($row['typeaudit']==='shirt'){
        $type = 'ล็อคเกอร์เก็บของ';
    }
    if($row['staudit']==='ok'){
        echo'
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        วันที่ : '.$row['createdate']->format('Y-m-d').'<br>ตู้'.$type.'<br>
                        อาคาร : '.$buildname.'<br>เพศ : '.$intitail.'<br>วิธีการตรวจ : '.$row['auditchoose'].'
                        <a href="auditresult.php?id_selection='.$row['ID'].'"class="btn btn-success btn-icon-split btn-sm w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text w-75">ดูผล</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    elseif($row['staudit']==='complete'){
        echo'
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        วันที่ : '.$row['createdate']->format('Y-m-d').'<br>ตู้'.$type.'<br>
                        อาคาร : '.$buildname.'<br>เพศ : '.$intitail.'<br>วิธีการตรวจ : '.$row['auditchoose'].'
                        <a href="auditresult.php?id_selection='.$row['ID'].'"class="btn btn-info btn-icon-split btn-sm w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text w-75">ตรวจเสร็จแล้ว</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    else{
    echo'
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        วันที่ : '.$row['createdate']->format('Y-m-d').'<br>ตู้'.$type.'<br>
                        อาคาร : '.$buildname.'<br>เพศ : '.$intitail.'<br>วิธีการตรวจ : '.$row['auditchoose'].'
                        <a href="auditShow.php?id_selection='.$row['ID'].'"class="btn btn-warning btn-icon-split btn-sm w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text w-75">ตรวจสอบ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    // เพิ่มคอลัมน์ตามต้องการ
}

// ปิดการเชื่อมต่อ
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

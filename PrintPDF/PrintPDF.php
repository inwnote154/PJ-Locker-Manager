<?php
ini_set('memory_limit', '500M');
// require('../mpdf60/mpdf.php');
require_once __DIR__ . '/../vendor/autoload.php';
include "../database.php";
ob_clean();
// flush();
// $mpdf = new \Mpdf\Mpdf(
//     [
//         'mode' => 'th', // mode - default ''
//         'format' => 'A4', // format - A4, for example, default ''
//         'default_font_size' => 8, // font size - default 0
//         'default_font' => '', // default font family
//         'margin_left' => 5,
//         'margin_right' => 5,
//         'margin_top' => 10,
//         'margin_bottom' => 5,
//         'margin_header' => 2,
//         'margin_footer' => 9,
//         'orientation' => '', // 'L' for landscape, 'P' for portrait
//     ]
// );

$date = date('d/m/Y');
$time = date('H:i.น');
$text='';
$textfooter='';

// $html = file_get_contents("http://localhost/locker-main/PrintPDF/testcopy.php");
if (isset($_GET['lo'])) {
    $mpdf = new \Mpdf\Mpdf(
        [
            'mode' => 'th', // mode - default ''
            'format' => 'A4', // format - A4, for example, default ''
            'default_font_size' => 8, // font size - default 0
            'default_font' => '', // default font family
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 10,
            'margin_bottom' => 5,
            'margin_header' => 2,
            'margin_footer' => 9,
            'orientation' => '', // 'L' for landscape, 'P' for portrait
        ]
    );
    $location = $_GET['lo'];
    if ($location == 'fillter') {
        if(isset($_GET['option1'])){
            $type =$_GET['option1'];
            if($type==='buddy'){$intype='Buddy';}
            elseif($type==='out'){$intype='Out';}
            elseif($type==='shirt'){$intype='Shirt';}
            if($type===""){$text="รายชื่อพนักงานที่มีอยู่ในล็อคเกอร์ทั้งหมด";}
            else{
                if($type==="buddy"){$instype="รองเท้าบัดดี้";}
                elseif($type==="out"){$instype="รองเท้าภายนอก";}
                elseif($type==="shirt"){$instype="ห้องแต่งตัวพนักงาน";}
                $text="รายชื่อพนักงานที่มีอยู่ในตู้ล็อคเกอร์$instype";
            }
        }
        if(isset($_GET['option2'])){
            $build = $_GET['option2'];
            if($build===""){}
            else{
                $text.=" อาคาร $build";
            }
        }
        if(isset($_GET['option3'])){
            $sex = $_GET['option3'];
            if($sex === 'นาย'){
                $insex = 'Man' ;
                $inssex = 'ชาย';
                $text.=" เพศ $inssex";
            }
            else if($sex === 'นาง' || $sex === 'นางสาว'){
                $insex = 'Woman' ;
                $inssex = 'หญิง';
                $text.=" เพศ $inssex";
            }
        }
        $text .= " วันที่ ....................".$date."........................... เวลา ....................".$time."..........................";
        
        $html = file_get_contents("http://localhost/locker-main/PrintPDF/LockerPrint.php?option1=$type&option2=$build&option3=$sex");
        $printName="{$date}-Locker-{$intype}{$build}{$insex}";
    }
    if ($location == 'auditresult') {
        $mpdf = new \Mpdf\Mpdf(
            [
                'mode' => 'th', // mode - default ''
                'format' => 'A4', // format - A4, for example, default ''
                'default_font_size' => 9, // font size - default 0
                'default_font' => '', // default font family
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 32,
                'margin_bottom' => 75,
                'margin_header' => 2,
                'margin_footer' => 1,
                'orientation' => '', // 'L' for landscape, 'P' for portrait
            ]
        );
        if (isset($_GET['id_selection' ])) {
            $id_selection = $_GET['id_selection'];
        }
        $sql = "SELECT * FROM format_audit WHERE ID = '$id_selection'";
        $stmt = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $type = $row['typeaudit'];
        if($type==="buddy"){$instype="รองเท้าบัดดี้";}
        elseif($type==="out"){$instype="รองเท้าภายนอก";}
        elseif($type==="shirt"){$instype="ห้องแต่งตัวพนักงาน";}
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
        $sex = $row['sex'];
        if($sex === 'นาง' || $sex === 'นางสาว'){
            $woman = '/';
            $man = '';
        }
        elseif($sex === 'นาย'){
            $woman = '';
            $man = '/';
        }
        $choose = $row['auditchoose'];
        if($choose === 'ตรวจด้วยตนเอง'){
            $yourself = '/';
            $camera = '';
        }
        elseif($choose === 'ตรวจด้วยกล้องวงจรปิด'){
            $yourself = '';
            $camera = '/';
        }
        

        $textother = $row['format_comment'];
        $entryDate = $row['createdate'] !== null ? $row['createdate']->format('Y/m/d') : ''; // ตรวจสอบ EntryDate ก่อนใช้ format()
        $entryTime = $row['createdate'] !== null ? $row['createdate']->format('H:m') : ''; // ตรวจสอบ EntryDate ก่อนใช้ format()s
        $sql = "SELECT signature FROM locker_userlogin WHERE userid = (SELECT TOP 1 auditerid  FROM AuditData1 WHERE format_id = '$id_selection' AND staudit <> 'process')"; 
        $stmt = sqlsrv_query($conn, $sql);
        $row2 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $admin_signature = $row2['signature'];
        $sql = "SELECT *  FROM format_audit
        join locker_userlogin ON locker_userlogin.userid = format_audit.manager_complete
        WHERE ID = '$id_selection' AND staudit = 'complete' "; 
        $stmt = sqlsrv_query($conn, $sql);
        $row3 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $manager_signature = $row3['signature'];
        $completedate = $row3['finishdate'] !== null ? $row3['finishdate']->format('Y/m/d') : ''; // ตรวจสอบ EntryDate ก่อนใช้ format()
        if($admin_signature){
            $adminsignature='<img src="../signature/'.$admin_signature.'"width="15%" />';
        }else{$adminsignature='';}
        if($manager_signature){
            $managersignature='<img src="../signature/'.$manager_signature.'"width="15%" />';
        }else{$managersignature='';$completedate='_/______/_';}

        
        $text='
        <div>
            <div style="text-align: center;"><h2>ตารางบันทึกผลการตรวจตู้ล็อคเกอร์'.$instype.'</h2></div>
            <div style="margin: 0 auto;">
                <table width="100%" style="border:none; border-collapse: separate;">
                    <thead>
                        <tr>
                            <td style="text-align: right;border:none;" width="45%" colspan="4">'.$instype.'อาคาร ....................'.$buildname.'....................</td>
                            <td width="10%" style="border:none;"></td>
                            <td width="5%" colspan="1">'.$man.'</td>
                            <td width="17.5%" colspan="1" style="border:none; text-align: left;">ชาย</td>
                            <td width="5%" colspan="1">'.$woman.'</td>
                            <td width="17.5%" colspan="1" style="border:none; text-align: left;">หญิง</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;" width="45%" colspan="4">วันที่ตรวจ.......'.$entryDate.'.......   เวลาตรวจ.......'.$entryTime.'.......</td>
                            <td width="10%" style="border:none;"></td>
                            <td width="5%" colspan="1">'.$yourself.'</td>
                            <td width="17.5%" colspan="1" style="border:none; text-align: left;">ตรวจด้วยตนเอง</td>
                            <td width="5%" colspan="1">'.$camera.'</td>
                            <td width="17.5%" colspan="1" style="border:none; text-align: left;">ตรวจด้วยกล้องวงจรปิด</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        ';

        $textfooter='
        <div>
            <div>
                <table width="100%" style="border:none; margin:0;">
                    <thead>
                        <tr>
                            <td width="7%" colspan="1" style="border:none;"></td>
                            <td width="10%" colspan="1">/</td>
                            <td width="83%" colspan="1" style="border:none; text-align: left;">หมายถึง ปฏิบัติถูกต้องตามระเบียบและข้อปฏิบัติที่กำหนด</td>
                        </tr>
                        <tr>
                            <td width="7%" colspan="1" style="border:none;"></td>
                            <td width="10%" colspan="1">X</td>
                            <td width="83%" colspan="1" style="border:none; text-align: left;">หมายถึง ปฏิบัติไม่ถูกต้องตามระเบียบและข้อปฏิบัติที่กำหนด</td>
                        </tr>
                        <tr>
                            <td width="7%" colspan="1" style="border:none;"></td>
                            <td width="10%" colspan="1" style="border:none;"></td>
                            <td width="83%" colspan="1" style="border:none; text-align: left;">*กรณีพบพนักงานปฏิบัติไม่ถูกต้อง บันทึกรายละเอียดใน "หนังสือกล่าวโทษและพิจารณาดำเนินการทางวินัย"</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div>
                <div style="text-decoration:underline;">การดำเนินการ</div>
                <div>
                    '.$textother.'
                </div>
            </div>
            <div width="90%" style="margin: 0 auto;">
                <table width="100%" style="border:none; margin-top:10px;">
                    <thead>
                        <tr>
                            <td width="15%" style="border:none;">ผู้ตรวจ</td>
                            <td width="30%" style="border-left:1; border-top:1; border-right:1; padding:0;">
                            '.$adminsignature.'</td>
                            <td width="5%" style="border:none;"></td>
                            <td width="15%" style="border:none;">ผู้ทวนสอบ</td>
                            <td width="30%" style="border-left:1; border-top:1; border-right:1; padding:0;">
                            '.$managersignature.'</td>
                            <td style="border:none;"></td>
                        </tr>
                        <tr>
                            <td style="border:none;"></td>
                            <td style="border:none;">( เขียนชื่อตัวบรรจง )</td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;">___'.$completedate.'___</td>
                            <td style="border:none;"></td>
                        </tr>
                        <tr>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;" colspan="2">( รองหัวหน้า/หัวหน้าแผนกบุคคลและธุรการ )</td>
                        </tr>
                        <tr style="margin-top:10px;">
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;"></td>
                            <td style="border:none;padding-top:10px;text-align:right;"colspan="2">F-PH-026 / แก้ไขครั้งที่ : 2</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        ';
        $image='../signature/20240304102516.png';

        $html = file_get_contents("http://localhost/locker-main/PrintPDF/AuditPrint.php?id_selection=$id_selection");
        $printName="{$date}-Audit-{$id_selection}";
    }
    if ($location=='MainReport'){
        $mpdf = new \Mpdf\Mpdf(
            [
                'mode' => 'th', // mode - default ''
                'format' => 'A4', // format - A4, for example, default ''
                'default_font_size' => 8, // font size - default 0
                'default_font' => '', // default font family
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'margin_header' => 2,
                'margin_footer' => 9,
                'orientation' => '', // 'L' for landscape, 'P' for portrait
            ]
        );
        if (isset($_GET['department_id' ])) {
            $department_id = $_GET['department_id'];
            $sql = "SELECT * FROM department WHERE departmentno = '$department_id'";
            $stmt = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $depart_name = $row['departmentname'];
            $check1=false;
        }
        if (isset($_GET['employee_id' ])) {
            $employee_id = $_GET['employee_id'];
            $check1=true;
        }



        $text="
        <div>รายชื่อพนักงานแผนก $department_id  $depart_name วันที่ .........................".$date."................................ เวลา .........................".$time."...............................</div>
        ";

        if ($check1) {
            $html = file_get_contents("http://localhost/locker-main/PrintPDF/EmpPrint.php?department_id=$department_id&employee_id=$employee_id");
        }else{
            $html = file_get_contents("http://localhost/locker-main/PrintPDF/EmpPrint.php?department_id=$department_id");
        }
        $printName="{$date}-EmpDepartment-{$department_id}";
    }
}

// $mpdf->SetHTMLHeaderByName('header');
$mpdf->SetHTMLHeader($text);
$mpdf->SetHTMLFooter($textfooter);
$mpdf->AddPage('P');
$mpdf->WriteHTML($html);
$mpdf->SetTitle($printName);
$mpdf->Output();
// $mpdf->OutputHttpDownload($printName.".pdf");
// $mpdf->Output('output.pdf');
exit;
?>
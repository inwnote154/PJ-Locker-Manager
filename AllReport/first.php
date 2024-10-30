<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script>
$(document).ready(function(){
    $("#department").change(function(){
        var department_id = $(this).val();
        document.getElementById('PrintFile').innerHTML = `
            <a href="../PrintPDF/PrintPDF.php?lo=MainReport&department_id=`+department_id+`" 
            class="btn btn-primary p-1 w-100" target="_blank">
                <span class="text">Print PDF</span>
            </a>
        `
        document.getElementById('excel').innerHTML = `
            <a href="../PrintPDF/EmpPrint1.php?department_id=`+department_id+`" 
            class="btn btn-primary p-1 w-100" target="_blank">
                <span class="text">Export to Excel</span>
            </a>
        `
        $.ajax({
            url: "get_department.php",
            method: "POST",
            data: {department_id:department_id},
            dataType: "html",
            success: function(data){
                $("#employee").html(data);
                // Call function to display data based on selected department and employee
                displayData();
            }
        });
    });

    $("#employee").change(function(){
        displayData();
    });

    function displayData() {
        var department_id = $("#department").val();
        var employee_id = $("#employee").val();
        document.getElementById('PrintFile').innerHTML = `
            <a href="../PrintPDF/PrintPDF.php?lo=MainReport&department_id=`+department_id+`&employee_id=`+employee_id+`" 
            class="btn btn-primary btn-icon-split btn-sm w-100" target="_blank">
                <span class="icon text-white-50 w-25">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text w-75">Print PDF</span>
            </a>
        `
        document.getElementById('excel').innerHTML = `
            <a href="../PrintPDF/EmpPrint1.php?department_id=`+department_id+`&employee_id=`+employee_id+`" 
            class="btn btn-primary btn-icon-split btn-sm w-100" target="_blank">
                <span class="icon text-white-50 w-25">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text w-75">Export to Excel</span>
            </a>
        `
        $.ajax({
            url: "get_employeedepartment.php",
            method: "POST",
            data: {department_id:department_id, employee_id:employee_id},
            dataType: "html",
            success: function(data){
                $("#data").html(data);
            }
        });
    }
});
</script>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <table class="w-100">
            <tr>
                <td class="pl-2 pr-2" width="5%">แผนก</td>
                <td class="pl-2 pr-2" width="20%">
                    <select class="form-control form-control-sm selectpicker select3"  id="department" name="department" 
                    data-live-search="true">
                        <?php
                        include '../database.php';
                        $sql = "SELECT * FROM department_filter ";
                        $stmt = sqlsrv_query($conn, $sql, $params);
                        
                        // Populate dropdown with employees
                        if ($stmt === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        echo "<option value='' selected disabled>เลือกแผนก</option>";
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option value='".$row['departmentno']."'>".$row['departmentname']."</option>";
                        }
                        ?>
                    </select>
                </td>

                <td class="pl-2 pr-2" width="8%">รหัสพนักงาน</td>
                <td class="pl-2 pr-2" width="28%">
                    <select class="form-control form-control-sm selectpicker select2" multiple id="employee" name="employee[]">
                        <option value="" disabled>Select employee</option>
                        <!-- This will be populated based on the selection of department -->
                    </select>
                </td>  
                <td class="pl-2 pr-2" width="20%">
                    <div id="PrintFile">
                        <a class="btn btn-primary btn-icon-split btn-sm w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-download"></i>
                            </span>
                            <span class="text w-75">Print PDF</span>
                        </a>
                    </div>
                </td>
                <td class="pl-2 pr-2" width="20%">
                    <div id="excel">
                        <a class="btn btn-primary btn-icon-split btn-sm w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-download"></i>
                            </span>
                            <span class="text w-75">Export to Excel</span>
                        </a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="card-body" id="data">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>รหัสพนักงาน</th>
                        <th>คำนำหน้า</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>รหัสแผนก</th>
                        <th>แผนก</th>
                        <th>ไลน์ผลิต</th>
                        <th>กลับบ้าน</th>
                        <th>บัดดี้</th>
                        <th>ล็อคเกอร์</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

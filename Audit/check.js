document.addEventListener('DOMContentLoaded', function() {
    // ตรวจสอบสถานะของ checkbox และกำหนดค่าเริ่มต้น
    for (var i = 1; i <= 11; i++) {
        var checkbox = document.getElementById('checkbox' + i);
        var checked = localStorage.getItem('checkbox' + i);

        if (checked === 'true') {
            checkbox.checked = true;
        }

        checkbox.addEventListener('change', function() {
            localStorage.setItem(this.id, this.checked);
        });
    }
});

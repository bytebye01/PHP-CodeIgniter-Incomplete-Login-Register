<script>
$(document).ready(function () {
        // ฟังก์ชัน Ajax ออกจากระบบ
        $('#logoutBtn').on('click', function () {
            Swal.fire({
                title: 'คุณต้องการออกจากระบบหรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่',
            }).then((result) => {
                if (result.isConfirmed) {
                    // ทำการเรียกฟังก์ชัน logout จาก Controller
                    $.ajax({
                        url: '<?php echo site_url("user_login/logout"); ?>',
                        type: 'GET',
                        success: function (response) {
                            // หลังจากออกจากระบบเรียบร้อย
                            Swal.fire({
                                title: 'ออกจากระบบสำเร็จ',
                                icon: 'success',
                            }).then((result) => {
                                // Redirect หน้าไปที่หน้าหลักหลังจากแจ้งเตือน
                                window.location.href = '<?php echo site_url(""); ?>';
                            });
                        },
                        error: function () {
                            // กรณีเกิดข้อผิดพลาดในการออกจากระบบ
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        });
    });
</script>
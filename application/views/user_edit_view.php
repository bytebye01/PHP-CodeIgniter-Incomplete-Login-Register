<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <br>
            <h4>Form Edit Data a</h4>
            <hr>
            <?php if ($rsedit): ?>
                <form method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="editUser(); return false;">
                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Username</div>
                        <div class="col-sm-6">
                            <input type="text" name="u_username" required class="form-control" placeholder="Username" readonly value="<?php echo $rsedit->u_username; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">New Password</div>
                        <div class="col-sm-6">
                            <input type="text" name="u_password" required class="form-control" placeholder="New Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-6">
                            <input type="hidden" name="u_id" value="<?php echo $rsedit->u_id; ?>">
                            <button type="submit" class="btn btn-primary ">SAVE</button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <script>
                    // แสดง SweetAlert2 เมื่อไม่มีข้อมูล edit_view.php
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่พบข้อมูล',
                        text: 'ไม่พบข้อมูลหรือข้อมูลนี้ถูกลบไปแล้ว',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // ทำการ redirect หรือทำอย่างอื่นตามที่ต้องการ
                            window.location.href = '<?php echo base_url(); ?>';
                        }
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>
    // เมื่อมีการเลือกไฟล์
    document.querySelector('input[name="m_img"]').addEventListener('change', function(e) {
        // เลือกตำแหน่งที่ต้องการแสดงรูปภาพในฟอร์ม
        var imageContainer = document.querySelector('.col-sm-6 img');
        
        // เลือกไฟล์ที่เลือก
        var file = e.target.files[0];

        // ถ้ามีไฟล์ที่เลือก
        if (file) {
            // ใช้ FileReader เพื่ออ่านไฟล์เป็น URL
            var reader = new FileReader();
            
            reader.onload = function (e) {
                // กำหนด URL ของรูปภาพที่ได้อ่านได้
                imageContainer.src = e.target.result;
            };
            
            reader.readAsDataURL(file); // อ่านไฟล์เป็น URL
        } else {
            // ถ้าไม่มีไฟล์ที่เลือก
            imageContainer.src = ''; // ลบรูปภาพที่แสดงออก
        }
    });
</script>
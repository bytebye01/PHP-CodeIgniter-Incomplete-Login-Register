<div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <br>
                <h4>Form Add User</h4>
                <hr>
                <form id='adduser_form01'action="<?php echo site_url('admin/user_management/adduser_ajax');?>" method="post" class="form-horizontal" enctype="multipart/form-data" >
                <!-- insertdata/adding -->


                    <div class="form-group row">
                        <label for="ref_pid" class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-6">
                            <select name="ref_pid" class="form-control" required>
                                <option value=1>Admin</option>
                                <option value=2>Boss</option>
                                <option value=3>Staff</option>
                                <option value=4>Employee</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Username</div>
                        <div class="col-sm-6">
                            <input type="text" name="u_username" required class="form-control" placeholder="Username" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Password</div>
                        <div class="col-sm-6">
                            <input type="text" name="u_password" required class="form-control" placeholder="Password" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Firstname</div>
                        <div class="col-sm-6">
                            <input type="text" name="u_fname" required class="form-control" placeholder="Firstname" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Lastname</div>
                        <div class="col-sm-6">
                            <input type="text" name="u_lname" required class="form-control" placeholder="Lastname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Email</div>
                        <div class="col-sm-6">
                            <input type="email" name="u_email" required class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <br>
                    <div class="col-4 offset-md-3 example-image" style="position: relative;"">
                        <div style="width: 140px; height: 140px; overflow: hidden; border-radius: 50%; border: 5px solid #00AB31; position: relative;">
                            <img src="<?php echo base_url('img/blankuser.jpg'); ?>" alt="Example Photo" style="width: 100%; height: 100%; object-fit: cover; object-position: center center; border-radius: 50%;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; top: 0; background-color: #000; display: flex; opacity: 0; transition: opacity 0.3s ease-in-out; justify-content: center; align-items: center;">
                                <label for="fileInput" style="cursor: pointer; color: #fff;">
                                    <i class="fas fa-folder-open fa-fw" style="padding: 5px;"></i>
                                </label>
                                <input type="file" name="u_img" id="fileInput" required accept="image/jpeg, image/png" style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                    <br>

                    

                    <div class="form-group row">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-6">
                            <a class="btn btn-primary rounded" onclick="addUser()">
                                <i class="fa fa-floppy-disk" style="font-size: 20px;"></i>
                            </a>
                        </div>
                    </div>


                

                   

                </form>
            </div>
        </div>
    </div>

    <script>
    // เมื่อมีการเลือกไฟล์
    document.querySelector('input[name="u_img"]').addEventListener('change', function (e) {
        // เลือกตำแหน่งที่ต้องการแสดงรูปภาพในฟอร์ม
        var imageContainer = document.querySelector('.col-4 img');

        // เลือกไฟล์ที่เลือก
        var file = e.target.files[0];

        // ถ้ามีไฟล์ที่เลือก
        if (file) {
            // ใช้ FileReader เพื่ออ่านไฟล์เป็น URL
            var reader = new FileReader();

            reader.onload = function (e) {
                // กำหนด URL ของรูปภาพที่ได้อ่านได้
                imageContainer.src = e.target.result;

                // แสดงตัวอย่างรูปทางขวามือ
                var exampleContainer = document.querySelector('.col-4 .example-image');
                exampleContainer.style.display = 'block';
            };

            reader.readAsDataURL(file); // อ่านไฟล์เป็น URL
        } else {
            // ถ้าไม่มีไฟล์ที่เลือก
            imageContainer.src = ''; // ลบรูปภาพที่แสดงออก
        }
    });
</script>

    

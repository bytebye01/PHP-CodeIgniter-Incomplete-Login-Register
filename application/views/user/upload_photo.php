<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <br>
            <h4>Upload Profile</h4>
            <hr>
            <?php if ($rsedit): ?>
                <form method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="editProfile(); return false;">
                <br>
                <div class="row justify-content-center">

                    <div class="col-3">
                        <a>
                            <div style="position: relative; width: 120px; height: 120px; overflow: hidden;">

                                <div style="position: relative; width: 120px; height: 120px; overflow: hidden; border-radius: 50%; border: 5px solid #ABABAB;">
                                    <?php
                                    $img_src = isset($rsedit->u_img) && !empty($rsedit->u_img) ?
                                        base_url('img/') . $rsedit->u_img :
                                        base_url('img/blankuser.jpg');
                                    ?>
                                    <img src="<?php echo $img_src; ?>" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; object-position: center center; border-radius: 50%;">
                                </div>

                            </div>
                            
                        </a>
                    </div>

                    <div class="col-1">
                        

                            <div style="position: absolute; bottom: 50; background-color: #00AB31; border-radius: 50%; object-fit: cover; width: 50%; height: 18%;" >
                                <i class="fas fa-chevron-right fa-fw" style="color: #fff; padding: 5px;"></i>
                            </div>

                    </div>

                    <!-- <div class="col-4 example-image">
                        <div style="position: relative; width: 140px; height: 140px; overflow: hidden;">

                            <div style="position: relative; width: 140px; height: 140px; overflow: hidden; border-radius: 50%; border: 5px solid #00AB31;">
                                <img src="<?php echo base_url('img/blankuser.jpg'); ?>" alt="Example Photo" style="width: 100%; height: 100%; object-fit: cover; object-position: center center; border-radius: 50%;">
                            </div>

                            <div style="position: absolute; bottom: 0; left: 97; background-color: #00AB31; border-radius: 50%; object-fit: cover;height: 20%;">
                                
                                <i class="fas fa-folder-open fa-fw" style="color: #fff; padding: 5px;height: 20px;"></i>
                            </div>

                        </div>
                    </div> -->

                    <div class="col-4 example-image" style="position: relative;">
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

                    
                </div>
                            

                        <br>
                        <hr>
                        

                    <!-- <div class="row">
                        <label for="u_img" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-6" >
                                <input type="file" name="u_img" required accept="image/jpeg, image/png">
                            </div>
                    </div> -->

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
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
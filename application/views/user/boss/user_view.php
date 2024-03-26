<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Show User</h4>
            <hr>
            <?php if (!empty($query)): ?>
                <input type="text" id="searchInput" class="form-control mb-2" placeholder="ค้นหา..." style="width: 200px;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>Level</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Info</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($query as $rs) { ?>
                            <?php if ($rs->pname !== 'Admin') { ?>
                                <tr>
                                    <td><?php echo $rs->u_id; ?></td>
                                    <td><?php echo $rs->pname; ?></td>
                                    <td><?php echo $rs->u_fname; ?></td>
                                    <td><?php echo $rs->u_lname; ?></td>
                                    <td>
                                        <div class="btn-group">
                                        

                                            <a class="btn btn-primary rounded" onclick="showPopupUser(<?php echo $rs->u_id; ?>)">
                                                <i class="fas fa-eye" style="font-size: 13px;"></i>
                                            </a>
                                
                                            
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>ไม่มีข้อมูลที่จะแสดง</p>
            <?php endif; ?>
            
        </div>
    </div>
</div>

    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-7">
                <br>
                <h4>Login Form</h4>
                <hr>
                <form action="<?php echo site_url('User_login/login_checking');?>" method="post" class="form-horizontal">
                <br>
                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Username</div>
                        <div class="col-sm-5">
                            <input type="text" name="u_username" class="form-control" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label">Password</div>
                        <div class="col-sm-5">
                            <input type="password" name="u_password" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
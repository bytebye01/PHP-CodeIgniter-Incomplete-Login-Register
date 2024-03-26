<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="<?php echo site_url('user/central_management/welcome_page');?>">My Website</a>
					
					<button class="navbar-toggler" type="button" data-toggle="collapse"
						data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
						aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto">
							<li class="nav-item active">
								<a class="nav-link" href="<?php echo site_url('home');?>">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('register');?>">Register</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('register/login');?>">Login</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
									aria-expanded="false">
									Dropdown
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Something else here</a>
								</div>
							</li>

							<!-- <li class="nav-item">
								<a href="" button type="button" class="btn btn-Success">Logout</a>
							</li> -->
							

						</ul>
							<!-- <div class="btn-group">
								<class="nav-item">
									<a href="<?php echo site_url('user/central_management/my_user_edit/' . $my_u_id_session); ?>" class="btn btn-info rounded">
										<i class="fas fa-pencil-alt" style="font-size: 20px;"></i>
									</a>
								</class>

								<class class="nav-item">
									<a class="btn btn-danger logout rounded" id="logoutBtn">
										<i class="fa-solid fa-right-from-bracket" style="font-size: 20px;"></i>
									</a>
								</class>
							</div> -->
							
							<div class="nav-item dropdown">
					
							<?php if (isset($current_user_data) && is_object($current_user_data)): ?>
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
									<div class="profile-pic">
										<div>
											<?php
											$img_src = isset($current_user_data->u_img) && !empty($current_user_data->u_img) ?
												base_url('img/') . $current_user_data->u_img :
												base_url('img/blankuser.jpg');
											?>
											<img src="<?php echo $img_src; ?>" alt="">
										</div>
									</div>
								</a>
							<?php endif; ?>
							


								<!-- Dropdown Menu -->
								<ul class="dropdown-menu" aria-labelledby="navbarDropdown">

									<li>
										<a class="dropdown-item" href="<?php echo site_url('user/central_management/my_profile_edit/' . $my_u_id_session); ?>">
											<div style="position: relative; width: 150px; height: 150px; overflow: hidden;">

											<div style="position: relative; width: 150px; height: 150px; overflow: hidden; border-radius: 50%; border: 5px solid #00AB31;">
												<?php
												$img_src = isset($current_user_data->u_img) && !empty($current_user_data->u_img) ?
													base_url('img/') . $current_user_data->u_img :
													base_url('img/blankuser.jpg');
												?>
												<img src="<?php echo $img_src; ?>" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; object-position: center center; border-radius: 50%;">
											</div>

												
												<div style="position: absolute; bottom: 0; left: 100; background-color: #00AB31; border-radius: 50%;">
													<i class="fas fa-camera fa-fw" style="color: #fff; padding: 5px;"></i>
												</div>

											</div>
										</a>
									</li>

									<li><hr class="dropdown-divider"></li>

									<li>
										<a class="dropdown-item" href="<?php echo site_url('user/central_management/my_user_edit/' . $my_u_id_session); ?>">
											<i class="fas fa-sliders-h fa-fw"></i> Change Password
										</a>
									</li>

									<li><hr class="dropdown-divider"></li>

									<li>
										<a class="dropdown-item" id="logoutBtn">
											<i class="fas fa-sign-out-alt fa-fw"></i> Log Out
										</a>
									</li>
								</ul>

							</div>
					</div>
				</nav>
			</div>
		</div>
	</div>

	
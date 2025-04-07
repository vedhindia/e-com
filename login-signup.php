<!DOCTYPE html>
<html lang="en">
	
<head>
		<meta charset="utf-8" />
		<meta name="author" content="www.frebsite.nl" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
        <title>Login - Register</title>
		 
        <!-- Custom CSS -->
        <link href="assets/css/styles.css" rel="stylesheet">
		
    </head>
	
    <body class="grocery-theme light">
        <?php
        session_start();
        include 'admin/dbconnection.php';

        // If user is already logged in, redirect to home page
        if(isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit();
        }

        $login_error = '';
        $register_error = '';
        $register_success = '';

        // Handle Login
        if(isset($_POST['login'])) {
            $email = mysqli_real_escape_string($conn, $_POST['login_email']);
            $password = mysqli_real_escape_string($conn, $_POST['login_password']);
            
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($sql);
            
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];
                    $_SESSION['email'] = $row['email'];
                    header("Location: index.php");
                    exit();
                } else {
                    $login_error = "Invalid password!";
                }
            } else {
                $login_error = "Email not found!";
            }
        }

        // Handle Registration
        if(isset($_POST['register'])) {
            $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
            $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
            $newsletter = isset($_POST['newsletter']) ? 1 : 0;
            
            // Validate password match
            if($password != $confirm_password) {
                $register_error = "Passwords do not match!";
            } else {
                // Check if email already exists
                $check_email = "SELECT * FROM users WHERE email='$email'";
                $result = $conn->query($check_email);
                
                if($result->num_rows > 0) {
                    $register_error = "Email already exists!";
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Insert new user
                    $sql = "INSERT INTO users (first_name, last_name, email, password, newsletter, created_at) 
                           VALUES ('$first_name', '$last_name', '$email', '$hashed_password', $newsletter, CURRENT_TIMESTAMP)";
                    
                    if($conn->query($sql) === TRUE) {
                        $register_success = "Registration successful! Please login.";
                    } else {
                        $register_error = "Error: " . $conn->error;
                    }
                }
            }
        }
        ?>
	
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div id="preloader"><div class="preloader"><span></span><span></span></div></div>
		
        <!-- Main wrapper -->
        <div id="main-wrapper">
		
            <!-- Header -->
            <?php include 'header.php'; ?>
			<div class="clearfix"></div>
			
			<!-- =========================== Breadcrumbs =================================== -->
			<div class="breadcrumbs_wrap dark">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="text-center">
								<h2 class="breadcrumbs_title">Login/Register</h2>
								<nav aria-label="breadcrumb">
								  <ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php"><i class="ti-home"></i></a></li>
									<li class="breadcrumb-item"><a href="#">My Account</a></li>
									<li class="breadcrumb-item active" aria-current="page">Login-register</li>
								  </ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- =========================== Breadcrumbs =================================== -->
			
			<!-- =========================== Login/Signup =================================== -->
			<section>
				<div class="container">
					<div class="row">
						
						<!-- Login Form -->
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="login_signup">
								<h3 class="login_sec_title">Sign In</h3>
                                <?php if(isset($login_error)): ?>
                                    <div class="alert alert-danger"><?php echo $login_error; ?></div>
                                <?php endif; ?>
								<form method="POST" action="">
									<div class="form-group">
										<label>Email Address</label>
										<input type="email" name="login_email" class="form-control" required>
									</div>
									
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="login_password" class="form-control" required>
									</div>
									
									<div class="login_flex">
										<div class="login_flex_1">
											<a href="#" class="text-bold">Forget Password?</a>
										</div>
										<div class="login_flex_2">
											<div class="form-group mb-0">
												<button type="submit" name="login" class="btn btn-md btn-theme">Login</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						
						<!-- Register Form -->
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="login_signup">
								<h3 class="login_sec_title">Create An Account</h3>
                                <?php if(isset($register_error)): ?>
                                    <div class="alert alert-danger"><?php echo $register_error; ?></div>
                                <?php endif; ?>
                                <?php if(isset($register_success)): ?>
                                    <div class="alert alert-success"><?php echo $register_success; ?></div>
                                <?php endif; ?>
								<form method="POST" action="">
									<div class="row">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label>First Name</label>
												<input type="text" name="firstname" class="form-control" required>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label>Last Name</label>
												<input type="text" name="lastname" class="form-control" required>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="form-group">
												<label>Email Address</label>
												<input type="email" name="email" class="form-control" required>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label>Password</label>
												<input type="password" name="password" class="form-control" required>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label>Confirm Password</label>
												<input type="password" name="confirm_password" class="form-control" required>
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12">
											<div class="login_flex">
												<div class="login_flex_1">
													<input id="news" class="checkbox-custom" name="newsletter" type="checkbox">
													<label for="news" class="checkbox-custom-label">Sign Up for Newsletter</label>
												</div>
												<div class="login_flex_2">
													<div class="form-group mb-0">
														<button type="submit" name="register" class="btn btn-md btn-theme">Sign Up</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- =========================== Login/Signup =================================== -->

			<!-- Footer -->
			<?php include 'footer.php'; ?>
			
		</div>
		<!-- End Wrapper -->

		<!-- All Jquery -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/metisMenu.min.js"></script>
		<script src="assets/js/owl-carousel.js"></script>
		<script src="assets/js/ion.rangeSlider.min.js"></script>
		<script src="assets/js/smoothproducts.js"></script>
		<script src="assets/js/jquery-rating.js"></script>
		<script src="assets/js/jQuery.style.switcher.js"></script>
		<script src="assets/js/custom.js"></script>
		
		<!-- Cart/Menu Scripts -->
		<script>
			function openRightMenu() {
				document.getElementById("rightMenu").style.display = "block";
			}
			function closeRightMenu() {
				document.getElementById("rightMenu").style.display = "none";
			}

			function openLeftMenu() {
				document.getElementById("leftMenu").style.display = "block";
			}
			function closeLeftMenu() {
				document.getElementById("leftMenu").style.display = "none";
			}
		</script>

	</body>
</html>
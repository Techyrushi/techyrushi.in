<?php
require_once '../config.php';

if (isset($_SESSION['admin_id'])) {
	header("Location: index.php");
	exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = trim($_POST['username']);
	$password = $_POST['password'];

	if (empty($username) || empty($password)) {
		$error = "Please enter both username and password.";
	} else {
		if ($pdo) {
			$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
			$stmt->execute([$username]);
			$user = $stmt->fetch();

			if ($user && password_verify($password, $user['password'])) {
				$_SESSION['admin_id'] = $user['id'];
				$_SESSION['admin_username'] = $user['username'];
				header("Location: index.php");
				exit;
			} else {
				$error = "Invalid username or password.";
			}
		} else {
			$error = "Database connection error.";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../images/favicon.ico">

	<title>TechZen Admin - Log in </title>

	<!-- Vendors Style-->
	<link rel="stylesheet" href="css/vendors_css.css">

	<!-- Style-->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/skin_color.css">

</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(../images/auth-bg/bg-1.jpg)">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<img src="../images/techyrushis.png" alt="" class="logo">
								<p class="mb-0">Sign in to continue.</p>
							</div>
							<div class="p-40">
								<?php if ($error): ?>
									<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
								<?php endif; ?>
								<form action="auth_login.php" method="post">
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" name="username" class="form-control ps-15 bg-transparent"
												placeholder="Username"
												value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text  bg-transparent"><i
													class="ti-lock"></i></span>
											<input type="password" name="password"
												class="form-control ps-15 bg-transparent" placeholder="Password">
										</div>
									</div>
									<div class="row">
										<div class="col-6">
											<div class="checkbox">
												<input type="checkbox" id="basic_checkbox_1">
												<label for="basic_checkbox_1">Remember Me</label>
											</div>
										</div>
										<!-- /.col -->
										<!-- <div class="col-6">
										 <div class="fog-pwd text-end">
											<a href="javascript:void(0)" class="hover-warning"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
										  </div>
										</div> -->
										<!-- /.col -->
										<div class="col-12 text-center">
											<button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
										</div>
										<!-- /.col -->
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Vendor JS -->
	<script src="js/vendors.min.js"></script>
	<script src="js/pages/chat-popup.js"></script>
	<script src="../assets/icons/feather-icons/feather.min.js"></script>

</body>

</html>
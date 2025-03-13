<?php
session_start();
include "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Klinik Venice | Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<style>
		/* Styling untuk halaman login */
		body {
			background: linear-gradient(to right, #56ccf2, #2f80ed);
			font-family: 'Arial', sans-serif;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.card {
			border: none;
			border-radius: 15px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		.card-title {
			font-size: 24px;
			font-weight: bold;
			color: #333;
		}

		.btn-primary {
			background-color: #2f80ed;
			border: none;
			border-radius: 50px;
			padding: 10px 20px;
			transition: background-color 0.3s ease;
		}

		.btn-primary:hover {
			background-color: #56ccf2;
		}

		.form-control {
			border-radius: 50px;
			padding: 10px 15px;
			box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.logo {
			width: 100px;
			height: 100px;
			display: block;
			margin: 0 auto 20px auto;
		}

		.card-wrapper {
			width: 100%;
			max-width: 400px;
		}

		.footer {
			text-align: center;
			margin-top: 20px;
			color: #fff;
		}
	</style>
</head>

<body>
	<div class="card-wrapper">
		<div class="card fat">
			<div class="card-body">
				<!-- Logo -->
				<img src="img/logo.png" alt="Poli Klinik Logo" class="logo">

				<h4 class="card-title text-center mb-4">Login ke Klinik Venice</h4>
				<form method="POST" class="my-login-validation" novalidate="">
					<div class="form-group">
						<label for="username">Username</label>
						<input id="username" type="text" class="form-control" name="username" required autofocus>
						<div class="invalid-feedback">
							Username is invalid
						</div>
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" type="password" class="form-control" name="password" required data-eye>
						<div class="invalid-feedback">
							Password is required
						</div>
					</div>

					<div class="form-group m-0">
						<button type="submit" name="submit" class="btn btn-primary btn-block">
							Login
						</button>
					</div>
					<br><center><p>Made by <a href='https://clicky.id/mystogancorp' target='_blank'>Iqbal</a></p></center>
				</form>
				<?php
				if (isset($_POST['submit'])) {
					$user = $_POST['username'];
					$pass = $_POST['password'];

					$query = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username='$user' AND password='$pass'");
					$masuk = mysqli_num_rows($query);
					if ($masuk == 0) {
						echo "<script>alert('Username atau password anda salah')</script>";
					} else {
						$masuk1 = mysqli_fetch_assoc($query);
						if ($masuk1["jabatan"] == 'admin') {
							$_SESSION["jabatan"] = 'admin';
							$_SESSION["user"] = $user;
							echo "<script>alert('Anda berhasil Login!'); document.location='../index.php'</script>";
						} else if ($masuk1["jabatan"] == 'pembayaran') {
							$_SESSION["jabatan"] = 'pembayaran';
							echo "<script>alert('Anda berhasil Login!'); document.location='../index.php'</script>";
						} else if ($masuk1["jabatan"] == 'pendaftaran') {
							$_SESSION["jabatan"] = 'pendaftaran';
							echo "<script>alert('Anda berhasil Login!'); document.location='../index.php'</script>";
						} else if ($masuk1["jabatan"] == 'pemeriksaan') {
							$_SESSION["jabatan"] = 'pemeriksaan';
							echo "<script>alert('Anda berhasil Login!'); document.location='../index.php'</script>";
						}
					}
				}
				?>
			</div>
		</div>
		<div class="footer">
		Copyright &copy; <span id="currentYear"></span> Klinik Venice
		</div>
	</div>
	<script>
		// Script untuk menampilkan tahun saat ini secara otomatis
		document.getElementById("currentYear").textContent = new Date().getFullYear();
	</script>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

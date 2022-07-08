<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title;?></title>
	<script src="/assets/jquery.js"></script>
	<link href="/assets/css/bulma.min.css" rel="stylesheet">
	<style>
		html,
		body {
			height: 100%;
		}

		body {
			display: flex;
			align-items: center;
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}

		.form-signin {
			width: 100%;
			max-width: 330px;
			padding: 15px;
			margin: auto;
		}

		.form-signin .checkbox {
			font-weight: 400;
		}

		.form-signin .form-floating:focus-within {
			z-index: 2;
		}

		.form-signin input[type="email"] {
			margin-bottom: -1px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}

		.form-signin input[type="password"] {
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
	</style>
</head>
<body class="text-center">
	<main class="form-signin">
		<?= form_open('/login/proses', 'autocomplate="off"'); ?>
			<h2 style="text-align:center; font-size:24; font-weight:700; margin-bottom:2rem;">Silahkan Login</h2>
			<div class="columns">
				<div class="column">
					<input type="text" class="input is-rounded" id="username" name="username" value="<?= old('username');?>" placeholder="Username" required>
					<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('username');?></span>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<input type="password" class="input is-rounded" id="password" name="password" value="<?= old('password');?>" placeholder="Password" style="border-radius:9999px" required>
					<span style="color:#e74c3c; font-size:small;"><?= session()->getFlashdata('passwordSalah');?></span>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<button class="button is-small is-success" type="submit">Login</button>
				</div>
			</div>
		<?= form_close();?>
	</main>
</body>
</html>
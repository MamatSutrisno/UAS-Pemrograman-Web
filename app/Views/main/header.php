<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title;?></title>
	<script src="/assets/jquery.js"></script>
	<link href="/assets/css/bulma.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<nav class="navbar" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<a class="navbar-item" href="<?= base_url();?>" style="font-weight:500">Home</a>
			<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div id="navbarBasicExample" class="navbar-menu">
			<div class="navbar-start">
				<a href="/antrian" class="navbar-item" id="detailAntrian" >Detail Antrian</a>
			</div>

			<div class="navbar-end">
				<?php if(session()->masuk){?>
					<a class="navbar-item" id="admin" href="/admin">Admin</a>
					<a class="navbar-item" id="pelayanan" href="/admin/pelayanan">Pelayanan</a>
					<a class="navbar-item" id="loket" href="/admin/loket">Loket</a>
					<a class="navbar-item" id="logout" href="/logout">Logout</a>
				<?php }else{ ?>
					<a class="navbar-item" id="login" href="/login">Login</a>
				<?php } ?>
			</div>
		</div>
	</nav>
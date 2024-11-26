<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel='shortcut icon' href='<?= base_url('assets/img/favicon.jpg') ?>'>
	<meta name="robots" CONTENT="noindex, nofollow">
	<title>TYMa:: Statistics Admin Panel</title><!-- GLOBAL VENDORS-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" media="all">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/feather-icons/feather.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/%40fortawesome/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/themify-icon/themify-icons.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/line-awesome/css/line-awesome.min.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/DataTables/datatables.min.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/perfect-scrollbar/css/perfect-scrollbar.css') ?>" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
	<link href="<?= base_url('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet" /><!-- THEME STYLES-->
	<link href="<?= base_url('assets/admin/css/app.min.css') ?>" rel="stylesheet" />
	<script src="<?= base_url('assets/admin/vendors/jquery/dist/jquery.min.js') ?>"></script>
	<style>
		.data-widget-icon {
			position: absolute;
			top: 20px;
			right: 20px;
			font-size: 40px;
			color: #6a89d7;
		}

		@media only screen and (max-width: 600px) {
			.data-widget-icon {
				font-size: 0px;
			}
		}
	</style><!-- PAGE LEVEL STYLES-->
</head>

<body>
	<div class="page-wrapper">
		<!-- BEGIN: Header-->
		<header class="header">
			<nav class="navbar navbar-expand navbar-dark header-navbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item mr-2"><a class="nav-link navbar-icon header-nav-toggler" id="header-nav-toggler" href="#"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a></li>
					<li><a class="navbar-brand d-none d-sm-inline-block" href="<?= base_url('admin') ?>"><img src="assets/logo.png" style="height: 70px; width: inherit;" alt="TYMa <?=$zone?>" class="img-responsive"></a></li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item mr-3"><a class="nav-link navbar-icon navbar-icon-btn" href="javascript:;" data-toggle="modal" data-target="#search-modal"><i class="ft-search"></i></a></li>
					<li class="nav-item dropdown"><a class="nav-link dropdown-toggle navbar-icon navbar-icon-btn" data-toggle="dropdown" href="#"><i class="ft-bell position-relative"></i><span class="badge badge-danger badge-circle notify-badge"></span></a>
						<div class="dropdown-menu dropdown-menu-right pt-0" style="min-width: 350px">
							<div class="py-4 px-3 text-center border-bottom mb-3">
								<h5 class="m-0">No Notifications</h5>
							</div>
							<!-- <div class="px-3 py-2 text-center"><a class="hover-link font-13" href="javascript:;">view all</a></div> -->
						</div>
					</li>
					<li class="nav-item dropdown ml-3">
						<a class="nav-link dropdown-toggle no-arrow d-inline-flex align-items-center px-4" style="background-color: rgba(255,255,255,.1);" href="<?= base_url('admin/logout') ?>">
							<div class="d-none d-sm-inline-block mr-2 text-right">
								<div class="font-weight-strong text-white">TYMa <?=$zone?></div>
								<div class="font-12">Admin</div>
							</div>
							<span class="position-relative d-inline-block"><img class="rounded-circle" src="assets/logo.png" alt="image" width="36" /><span class="badge-point badge-success avatar-badge"></span></span>
						</a>
					</li>
					<li style="display:none"><a class="nav-link navbar-icon quick-sidebar-toggler" href="javascript:;"><span class="ti-align-right"></span></a></li>
				</ul>
			</nav>
			<nav class="header-nav" id="header-nav">
				<ul class="nav header-menu position-static">
					<li class="nav-item "><a class="header-menu-toggle dropdown-toggle no-arrow" href="<?= base_url('/') ?>">Dashboard</a>
					</li>
					<!-- <li class="nav-item dropdown"><a class="header-menu-toggle dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:;">Website<i class="ti-angle-down arrow ml-2"></i></a>
						<div class="dropdown-menu">
							<a class="dropdown-item d-flex align-items-center" href="<?= base_url('admin/variable') ?>"><span class="menu-link-point"></span>Site Variables</a>
					</li> -->
					<!-- <li class="nav-item "><a class="header-menu-toggle dropdown-toggle no-arrow" href="<?= base_url('printm') ?>">Manual Printer</a> -->
					</li>
					<li class="nav-item "><a class="header-menu-toggle dropdown-toggle no-arrow" href="<?= base_url('printe') ?>">Electronic Printer</a>
					</li>
                    <!-- <li class="nav-item "><a class="header-menu-toggle dropdown-toggle no-arrow" href="<?= base_url('manual') ?>">Manual Upload</a> -->
					<li class="nav-item "><a class="header-menu-toggle dropdown-toggle no-arrow" href="<?= base_url('pins') ?>">Pins</a>
					</li>
					<li class="nav-item "><a class="header-menu-toggle dropdown-toggle no-arrow" href="<?= base_url('tagger') ?>">Generate Tags</a>
					</li>
				</ul>
				<div class="d-none d-md-flex align-items-center" style="padding-right: 30px"><button class="btn btn-outline-primary btn-sm"><span class="btn-icon"><i class="ti-pencil"></i>...</span></button></div>
			</nav>
		</header><!-- END: Header-->
		<div class="content-wrapper">
			<!-- BEGIN: Content-->
			<div class="content-area">
				<div class="page-content fade-in-up">
					<!-- BEGIN: Page heading-->
					<div class="page-heading">

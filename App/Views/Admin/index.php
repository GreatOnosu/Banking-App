<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | Admin | Home</title>
	<link rel="stylesheet" type="text/css" href="css/magic.css">
	<script src="../vendor/jquery.min.js"></script>
	<script src="js/menu.js"></script>
</head>
<body>
	<div id="header">
		<h1>Eagle Flight Microfinance Bank</h1>
		<?php include 'includes/admin.php';?>
	</div>
	<div id="content">
		<div class="cnt-header">
			<div class="breadcrumbs">
				<h1>Dashboard</h1>
				<a href="logout" class="btn-profile"><img src="icons/logout.png" title="Logout" /></a>
				<span class="btn-profile">Welcome Admin&nbsp;&nbsp;&nbsp;</span>
			</div>
		</div>
		<div class="cnt-body">
			<div class="dashset-wrap">
				<div class="dashset dashset1">
					<a href="Admin/fundings">
						<div class="upperset"></div>
						<div class="lowerset">
							<span>Fund Accounts</span>
						</div>
					</a>
				</div>
				<div class="dashset">
					<a href="Admin/accounts">
						<div class="upperset"></div>
						<div class="lowerset">
							<span>List of Accounts</span>
						</div>
					</a>
				</div>
				<div class="dashset">
					<a href="Admin/search">
						<div class="upperset"></div>
						<div class="lowerset">
							<span>Account Statement</span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="cnt-header">
			<div class="breadcrumbs">
				<h3>&copy;Benson Idahosa University</h3>
			</div>
		</div>
	</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | <?=$_SESSION['session_fullname'];?> | Transfers</title>
	<link rel="stylesheet" type="text/css" href="css/magic.css">
	<script src="../vendor/jquery.min.js"></script>
	<script src="js/menu.js"></script>
</head>
<body>
	<div id="header">
		<h1>Eagle Flight Microfinance Bank</h1>
		<?php include 'includes/menu.php';?>
	</div>
	<div id="content">
		<div class="cnt-header">
			<div class="breadcrumbs">
				<h2><a href="User/index">Dashboard</a> / <a href="User/transfers">Transfer Fund</a></h2>
				<a href="logout" class="btn-profile"><img src="icons/logout.png" title="Logout" /></a>
				<span class="btn-profile">Welcome <?=$_SESSION['session_username'];?>&nbsp;&nbsp;&nbsp;</span>
			</div>
		</div>
		<div class="cnt-body">
			<div class="cnt-wrap-signup">
				<dl class="form">
					<?=$stat?>
					<form action="User/transfer" method="post">
					<dt class="form-control">
						<label for="amount">Enter Amount</label>
						<input type="number" id="amount" name="amount" required />
					</dt>
					<dt class="form-control">
						<label for="acctno">Account Number</label>
						<input type="number" id="acctno" name="acct_no" required /><span id="info">View Account Name</span>
					</dt>
					<dt class="form-control">
						<label for="acctname">Account Name</label>
						<input type="text" id="acctname" name="acct_name" required />
					</dt>
					<dt class="form-control">
						<label for="pin">Pin</label>
						<input type="password" id="pin" name="pin" required />
					</dt>
					<dt class="form-control">
						<input type="submit" value="Make Payment" name="btn_pay" />
					</dt>
					</form>
				</dl>
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
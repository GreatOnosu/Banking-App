<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | <?=$_SESSION['session_fullname'];?> | Account Statement</title>
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
				<h2><a href="User/index">Dashboard</a> / <a href="User/statement">Account Statement</a> / <a href="User/showstatement?acct=view"><?=$_SESSION['session_username'];?> Account Statement</a></h2>
				<a href="logout" class="btn-profile"><img src="icons/logout.png" title="Logout" /></a>
				<span class="btn-profile">Welcome <?=$_SESSION['session_username'];?>&nbsp;&nbsp;&nbsp;</span>
			</div>
		</div>
		<div class="cnt-body">
			<div class="cnt-wrap-table">
				<table>
					<tr>
					    <th>Date / Time</th>
					    <th>Sender</th>
					    <th>Receiver</th>
					    <th>Amount</th>
					    <th>Type</th>
					    <th>Decription</th>
					    <th>Balance</th>
					</tr>
					<?php foreach($details as $detail):?>
					<tr>
				    	<td><?=$detail->timestamp;?></td>
				    	<td><?=$detail->sender;?></td>
				    	<td><?=$detail->receiver;?></td>
				    	<td><?=$detail->amount;?></td>
				    	<td><?=$detail->type;?></td>
				    	<td><?=$detail->description;?></td>
				    	<td>₦<?=$detail->balance;?></td>
				  	</tr>
				  <?php endforeach;?>
				</table>
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
<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | Admin | Accounts | Profile</title>
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
				<h2><a href="Admin/index">Dashboard</a> / <a href="Admin/accounts">Accounts</a> / <a href="Admin/accountprofile?uas_id=<?=$user?>">Profile</a></h2>
				<a href="logout" class="btn-profile"><img src="icons/logout.png" title="Logout" /></a>
				<span class="btn-profile">Welcome Admin&nbsp;&nbsp;&nbsp;</span>
			</div>
		</div>
		<div class="cnt-body">
			<div class="cnt-wrap-table">
				<?=$stat?>
				<dl class="user-details">
					<img src="<?=$details{0}->image?>" width="240" height="240" class="user-img" />
					<dt>
						<span><b>First Name:</b> <?=$details{0}->first_name?></span>
					</dt>
					<dt>
						<span><b>Other Names:</b> <?=$details{0}->other_name?></span>
					</dt>
					<dt>
						<span><b>DOB:</b> <?=$details{0}->dob?></span>
					</dt>
					<dt>
						<span><b>Gender:</b> <?=$details{0}->gender?></span>
					</dt>
					<dt>
						<span><b>Phone Number:</b> <?=$details{0}->phone_no?></span>
					</dt>
					<dt>
						<span><b>Acccount Balance:</b> ₦<?=$details{0}->balance?></span>
					</dt>
					<dt>
						<span><a href="Admin/editprofile?uas_id=<?=$user?>"><button class="btn-edit">Edit profile</button></a></span>
					</dt>
				</dl>
				<h1 class="heading">Account Statement</h1>
				<table>
					<tr>
					    <th>Date / Time</th>
					    <th>Sender</th>
					    <th>Amount</th>
					    <th>Type</th>
					    <th>Decription</th>
					    <th>Balance</th>
					</tr>
					<?php foreach($statements as $statement):?>
					<tr>
				    	<td><?=$statement->timestamp;?></td>
				    	<td><?=$statement->sender;?></td>
				    	<td><?=$statement->amount;?></td>
				    	<td><?=$statement->type;?></td>
				    	<td><?=$statement->description;?></td>
				    	<td>₦<?=$statement->balance;?></td>
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
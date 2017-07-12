<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | Admin | Accounts | Profile | Edit</title>
	<link rel="stylesheet" type="text/css" href="css/magic.css">
	<link rel="stylesheet" href="../vendor/jquery-ui.css">
    <script src="../vendor/jquery.min.js"></script>
    <script src="../vendor/jquery-ui.js"></script>
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
				<h2><a href="Admin/index">Dashboard</a> / <a href="Admin/accounts">Accounts</a> / <a href="Admin/accountprofile?uas_id=<?=$user?>">Profile</a> / <a href="Admin/editprofile?uas_id=<?=$user?>">Edit</a></h2>
				<a href="logout" class="btn-profile"><img src="icons/logout.png" title="Logout" /></a>
				<span class="btn-profile">Welcome Admin&nbsp;&nbsp;&nbsp;</span>
			</div>
		</div>
		<div class="cnt-body">
			<div class="cnt-wrap-signup">
				<dl class="form">
					<?=$stat?>
					<form action="Admin/editprofile?uas_id=<?=$user?>" method="post" enctype="multipart/form-data">
					<dt class="form-control">
						<label for="fname">First Name</label>
						<input type="text" id="fname" name="fname" value="<?=$details{0}->first_name?>" required />
					</dt>
					<dt class="form-control">
						<label for="oname">Other Names</label>
						<input type="text" id="oname" name="oname" value="<?=$details{0}->other_name?>" required />
					</dt>
					<dt class="form-control">
						<label for="dob">DOB</label>
						<input type="text" id="dob" name="dob" value="<?=$details{0}->dob?>" required />
					</dt>
					<dt class="form-control">
						<label for="image">Upload Passport</label>
						<input type="file" id="image" name="image" />
					</dt>
					<dt class="form-control" style="font-size: 20px;">
						<label>Gender</label><br>
						<?=$gender?><br>
					</dt>
					<dt class="form-control">
						<label for="pnumber">Phone Number</label>
						<input type="text" id="pnumber" name="pnumber" value="<?=$details{0}->phone_no?>" required />
					</dt>
					<dt class="form-control">
						<input type="submit" value="Update" name="btn_update" />
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
<script>
      /* global setting */
    var datepickersOpt = {
        dateFormat: 'yy-mm-dd'
    }
    $("#dob").datepicker(datepickersOpt);
</script>
</html>
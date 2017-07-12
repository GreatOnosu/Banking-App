<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | Sign Up</title>
	<link rel="stylesheet" type="text/css" href="css/magic.css">
	<link rel="stylesheet" href="../vendor/jquery-ui.css">
    <script src="../vendor/jquery.min.js"></script>
    <script src="../vendor/jquery-ui.js"></script> 
</head>
<body>
	<div id="header">
		<h1>Eagle Flight Microfinance Bank</h1>
	</div>
	<div id="content">
		<div class="cnt-header">
			<div class="breadcrumbs">
				<h1>Register with us today</h1>
				<a href="Home/index" id="btn-signup">Sign In</a>
			</div>
		</div>
		<div class="cnt-body">
			<div class="cnt-wrap-signup">
				<?=$stat?>
				<dl class="form">
					<form action="Home/signup" method="post" enctype="multipart/form-data">
					<dt class="form-control">
						<label for="fname">First Name</label>
						<input type="text" id="fname" name="fname" required />
					</dt>
					<dt class="form-control">
						<label for="oname">Other Names</label>
						<input type="text" id="oname" name="oname" required />
					</dt>
					<dt class="form-control">
						<label for="dob">DOB</label>
						<input type="text" id="dob" name="dob" required />
					</dt>
					<dt class="form-control">
						<label for="image">Upload Passport</label>
						<input type="file" id="image" name="image" required />
					</dt>
					<dt class="form-control" style="font-size: 20px;">
						<label>Gender</label><br>
						<input type="radio" name="gender" value="male" checked> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  						<input type="radio" name="gender" value="female"> Female<br>
					</dt>
					<dt class="form-control">
						<label for="pnumber">Phone Number</label>
						<input type="text" id="pnumber" name="pnumber" required />
					</dt>
					<dt class="form-control">
						<label for="pin">Pin</label>
						<input type="password" id="pin" name="pin" required />
					</dt>
					<dt class="form-control">
						<label for="cpin">Confirm Pin</label>
						<input type="password" id="cpin" name="cpin" required />
					</dt>
					<dt class="form-control">
						<input type="submit" value="Sign Up" name="btn_signup" />
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
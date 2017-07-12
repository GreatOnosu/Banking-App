<!DOCTYPE html>
<html lang="en">
<head runat="server">
	<base href="/Stephanie/public/">
	<meta charset="UTF" name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Eagle Flight Microfinance Bank | Home</title>
	<link rel="stylesheet" type="text/css" href="css/magic.css">
</head>
<body>
	<div id="header">
		<h1>Eagle Flight Microfinance Bank</h1>
	</div>
	<div id="content">
		<div class="cnt-header">
			<div class="breadcrumbs">
				<h1>Home</h1>
				<a href="Home/signup" id="btn-signup">Sign Up</a>
			</div>
		</div>
		<div class="cnt-body">
			<img src="images/eagle.jpg" width="100%" id="cnt-bg" />
			<div class="cnt-wrap">
				<div class="intro-text">
					<h1>Welcome to Eagle Flight Micro-Finance Bank Online Banking Portal</h1>
				</div>
				<div class="sign-in">
					<dl class="form text-center">
						<?=$stat?>
						<form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
						<dt class="form-control">
							<input type="text" placeholder="Phone Number" name="phone" required />
						</dt>
						<dt class="form-control">
							<input type="password" placeholder="Pin" name="pin" required />
						</dt>
						<dt class="form-control">
							<input type="submit" value="Sign In" name="btn_login" />
						</dt>
						</form>
					</dl>
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
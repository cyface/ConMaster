<?php session_start(); //This needs to be the first line ?>
<html>
<head>
<title>ConMaster Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="/cm/templates/cm.css" type="text/css">
<script language="JavaScript" src="/cm/templates/cm.js"></script>
</head>

<body class="BodyClass" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/bluebricktileh.jpg" height="100">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<blockquote>
<h2>Please Log Into ConMaster</h2>
<form method="post" action="conmaster.php" name="login">
<table>
<tr><td>User Name</td><td><input type="text" name="username"></td></tr>
<tr><td>Password</td><td><input type="password" name="password"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Log In"></td></tr>
</table>
</form>
<?php
	if (isset($_REQUEST['failed'])) {
		echo "<p class='FieldError'>Login Incorrect.  Please Try Again.</p>";
	}
	if (isset($_REQUEST['logoff'])|isset($_REQUEST['logout'])) {
		session_unset(); //Unset all the session variables
		//session_destroy();
		echo "<p class='FieldError'>Logged out Successfully.</p>";
		
	}
?>
</blockquote>

<script language="javascript">
  document.login.username.focus();
</script>

</body>
</html>

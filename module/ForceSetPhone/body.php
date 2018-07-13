<?php
if (
	$_SESSION['setPhoneStep'] == 1 ||
	$_SESSION['setPhoneStep'] == 4
	)
	include("formSetPhone.php");
else if (
	$_SESSION['setPhoneStep'] == 2 ||
	$_SESSION['setPhoneStep'] == 5
)
	include("formSetCode.php");

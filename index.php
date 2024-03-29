<?php
	require_once("parametermetric/home/entrance/platform.php");
	$platform = new parametermetric\home\entrance\Platform();

	$platform->RequireOnceDirectory("home/dhop");
?>

<?php
	new parametermetric\home\entrance\Specimen();

	// Unblock following code of sampling to view code in action in front-end or defined in respective.

	// A demonstration of code convention used in this project in generic format.
	new parametermetric\home\dhop\des\Specimen();
?>
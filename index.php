<?php
	require_once("parametermetric/home/entrance/platform.php");
	$platform = new parametermetric\home\entrance\Platform();
?>

<?php
	// Unblock following code-blocks to view demonstration of code-in-action in front-end or defined in respective.

	// A demonstration of - code convention used in this project in generic format.
	$platform->RequireOnceDirectory("home/dhop");
	new parametermetric\home\dhop\des\Specimen();

	// A demonstration of - parametermetric\home\entrance\Specimen().
	new parametermetric\home\entrance\Specimen();
?>
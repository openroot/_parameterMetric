<?php
	require_once("parametermetric/home/well/head.php");
	$platform = new parametermetric\home\well\head\Platform();
?>

<?php
	// Unblock following code-blocks to view demonstration of code-in-action in front-end or defined in respective.

	// A demonstration of - code convention used in this project in generic format.
	$platform->RequireOnceDirectory("home/margosa");
	new parametermetric\home\margosa\flower\Specimen();

	// A demonstration of - parametermetric\home\well\head\Specimen().
	new parametermetric\home\well\head\Specimen();
?>
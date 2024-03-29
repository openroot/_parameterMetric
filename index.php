<?php
	require_once("parametermetric/home/well/heap.php");
	$platform = new parametermetric\home\well\heap\Platform();
?>

<?php
	// Unblock following code-blocks to view demonstration of code-in-action in front-end or defined in respective.

	// A demonstration of - parametermetric\home\well\heap.
	new parametermetric\home\well\heap\Specimen();

	// A demonstration of - code convention used in this project in generic format.
	if ($platform->RequireOnceDirectory("home/margosa")) {
		new parametermetric\home\margosa\flower\Specimen();
	}
?>
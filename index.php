<?php
	require_once("parametermetric/home/well/heap.php");
	$platform = new parametermetric\home\well\heap\Platform();
?>

<?php
	// TODO: 1. Add section-counter feature.
	// TODO: 2. Add 'todo-section'. Till then, jot down here.
	// TODO: 3. Add 'analyzer-section' for code of the project analysis.


	// Unblock following code-blocks to view demonstration of code-in-action in front-end or defined in respective.

	// A demonstration of parametermetric\home\well\heap.
	new parametermetric\home\well\heap\Specimen();

	// A demonstration of code convention used in this project in generic format.
	if ($platform->RequireOnceDirectory("home/margosa")) {
		new parametermetric\home\margosa\flower\Specimen();
	}
?>
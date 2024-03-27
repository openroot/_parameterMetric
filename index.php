<?php
	$list = array(
		1 => "parametermetric/home/entrance/platform.php",
		2 => "parametermetric/home/dhop/des.php"
	);
	foreach ($list as $appendix => $value) {
		require_once($value);
	}
?>

<?php
	use parametermetric\home\entrance as entrance;

	new entrance\Platform();

	// Unblock following code of sampling to view code in action in front-end or defined in respective.

	// A demonstration of code convention used in this project in generic format.
	new parametermetric\home\dhop\des\Specimen();
?>
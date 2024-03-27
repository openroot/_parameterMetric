<?php
	require_once("parametermetric/home/entrance/boot.php");
	require_once("parametermetric/home/dhop/des.php");
?>

<?php
	use parametermetric\home\entrance as entrance;
	new entrance\Boot();

	new parametermetric\home\dhop\des\Specimen();
?>
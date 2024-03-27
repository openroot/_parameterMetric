<?php
	require_once("parametermetric/home/entrance/boot.php");
	require_once("parametermetric/home/Dhop/Des.php");
?>

<?php
	use \parametermetric\home\Dhop\Des as DDoS;

	$iKnow = new DDoS\Friend(
		"debcyberboy@gmail.com",
		"D Tapader",
		"Aviator Sun-glass",
		array("sketching", "programming", "learning"),
		"bore",
		"engineer",
		"his",
		array("when", "do not")
	);

	$iKnowAnother = new DDoS\Friend(
		"dev.openroot@live.com",
		"Debaprasad Tapader",
		"Higher Education",
		array("cooking"),
		"late",
		"researcher",
		"above",
		array("code", "style")
	);

	$youThinkI = new DDoS\Me(
		"dev.openroot@gmail.com",
		"Dev",
		array("Masala Dosa", "Milk Coffee", "Egg omelette"),
		array("Yamaha FZ-S", "HERCULES cycle"),
		$iKnow
	);

	echo "<h4>Me</h4>";

	echo $youThinkI->Know();
	echo "<br /><br />";
	echo $youThinkI->Ride($iKnow);
	echo "<br /><br />";
	echo $youThinkI->Explain($iKnow);
	echo "<br /><br />";
	echo "- regards, {$youThinkI->identify()} [{$youThinkI->baseIdentity()}]";

	echo "<h4>Friend</h4>";

	echo $iKnow->Explain();

	echo "<hr />";

	echo $iKnowAnother->Explain();
?>
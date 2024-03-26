<?php
	require_once("parametermetric/home/entrance/boot.php");
	require_once("parametermetric/home/Dhop/Des.php");
?>

<?php
	use \parametermetric\home\Dhop\Des as DDoS;

	echo "<hr />";

	//$youThinkI = new DDoS\Me();
	$youThinkI = new DDoS\Me(
		"dev.openroot@gmail.com",
		"Dev",
		"Egg omelette",
		"Yamaha FZ-S"
	);

	echo "I " . implode(", ", $youThinkI->Know()) . ".";
	echo "<br /><br />";
	echo "When I ride {$youThinkI->Ride()}.";
	echo "<br />";
	echo "I have a friend " . implode(" ", $youThinkI->Explain()) . " with me.";
	echo "<br /><br />";
	echo "- regards, " . $youThinkI->id;

	echo "<hr />";

	//$callForHelp = new DDoS\Friend();
	/*$callForHelp = new DDoS\Friend(
		"debcyberboy@gmail.com",
		"D Tapader",
		"Aviator Sun-glass",
		array("sketching", "programming"),
		"bore",
		"engineer",
		"his"
	);*/

	//echo ucfirst(implode(" ", $callForHelp->Explain())) . ".";

	echo "<hr />";
?>
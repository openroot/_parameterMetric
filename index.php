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
		"his"
	);

	$youThinkI = new DDoS\Me(
		"dev.openroot@gmail.com",
		"Dev",
		"Egg omelette",
		"Yamaha FZ-S",
		$iKnow
	);

	echo "<hr />";

	echo "I " . implode(", ", $youThinkI->Know()) . ".";
	echo "<br /><br />";
	echo "When I ride {$youThinkI->Ride()}.";
	echo "<br />";
	echo "I have a friend " . implode(" ", $youThinkI->Explain($iKnow)) . " with me.";
	echo "<br /><br />";
	echo "- regards, " . $youThinkI->Identity();

	echo "<hr />";

	echo ucfirst(implode(" ", $iKnow->Explain())) . ".";

	echo "<hr />";



	$iKnowAnother = new DDoS\Friend(
		"dev.openroot@live.com",
		"Debaprasad Tapader",
		"Higher Education",
		array("cooking"),
		"late",
		"researcher",
		"above"
	);

	echo "<hr />";

	echo ucfirst(implode(" ", $iKnowAnother->Explain())) . ".";

	echo "<hr />";
?>
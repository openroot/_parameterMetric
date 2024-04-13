<?php
	$links = array(
		"/install/onlineinstallfresh.php" => "Online Install Afresh [Current Version will be backed-up]",		
		"/install/newupdate.php" => "Update [Current version will be updated with the updates placed inside lid/home/well/hid. (Version, needs mention in lid/home/well/water.php:Brick->CapHids())]",
		"/install/installfresh.php" => "Install Afresh [Current Version will be backed-up]",
		"/install/onilnerepair.php" => "Repair [From online sourced]"
	);
?>

<?php
	foreach ($links as $index => $value) {
		echo "<a href=\"{$index}\">{$value}</a><br><br>";
	}
?>
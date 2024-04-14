<?php
	$links = array(
		"/install/onlineinstallfresh.php" => "Fresh Install From Online [current version gets archived in localdrive]"
	);
?>

<?php
	foreach ($links as $index => $value) {
		echo "<a href=\"{$index}\">{$value}</a><br><br>";
	}
?>
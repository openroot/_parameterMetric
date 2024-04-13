<?php
?>

<?php
	$url = "https://github.com/openroot/parametermetric/archive/refs/heads/main.zip";
	$fileBaseName = basename($url);

	if (file_put_contents($fileBaseName, file_get_contents($url))) {
		echo "File downloaded successfully"; 
	}
	else {
		echo "File downloading failed.";
	}
?>
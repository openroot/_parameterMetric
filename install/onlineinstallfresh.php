<?php
?>

<?php
	$fileUrl = "https://github.com/openroot/parametermetric/archive/refs/heads/main.zip";
	$fileName = basename($fileUrl);

	$content = false;
	try {
		$content = file_get_contents($fileUrl);
	}
	catch (\Exception $exception) {
		echo "<br>Error details: " . $exception->getMessage() . "<br>";
	}
	if (!empty($content)) {
		if (file_put_contents($fileName, $content)) {
			echo "File downloaded successfully"; 
		}
	}
	else {
		echo "File downloading from online source was failed.";
	}
?>
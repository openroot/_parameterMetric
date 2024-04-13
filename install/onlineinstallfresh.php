<?php
?>

<?php
	$messages = array();

	$fileUrl = "https://github.com/openroot/parametermetric/archive/refs/heads/main.zip";
	$fileName = basename($fileUrl);

	$content = file_get_contents($fileUrl);
	if (!empty($content)) {
		if (file_put_contents($fileName, $content)) {
			array_push($messages, "File downloaded successfully.");
			$zip = new ZipArchive;
			if ($zip->open("main.zip")) {
				$zip->extractTo("./");
				$zip->close();
				array_push($messages, "Downloaded file unzipped successfully.");
			}
			else {
				array_push($messages, "File unzipping was failed.");
			}
		}
	}
	else {
		array_push($messages, "File downloading from online source was failed.");
	}

	foreach ($messages as $index => $value) {
		echo ($index + 1) . ": {$value}<br>";
	}
?>
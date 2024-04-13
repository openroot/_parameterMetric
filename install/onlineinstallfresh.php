<?php
?>

<?php
	$messages = array();

	$githubRepositoryName = "parametermetric";
	$repositoryBranch = "main";
	$fileUrl = "https://github.com/openroot/{$githubRepositoryName}/archive/refs/heads/{$repositoryBranch}.zip";
	$fileName = basename($fileUrl);

	$content = file_get_contents($fileUrl);
	if (!empty($content)) {
		if (file_put_contents($fileName, $content)) {
			array_push($messages, "File downloaded successfully.");
			$extractToDirectory = "./";
			/*$zip = new ZipArchive;
			if ($zip->open("main.zip")) {
				$zip->extractTo($extractToDirectory);
				$zip->close();
				array_push($messages, "Downloaded file unzipped successfully.");
				$extractedDirectoryName = "{$extractToDirectory}{$githubRepositoryName}-{$repositoryBranch}";
			}
			else {
				array_push($messages, "File unzipping was failed.");
			}*/
			if (unlink("{$repositoryBranch}.zip")) {
				array_push($messages, "Downloaded zipped file deleted successfully.");
				array_push($messages, CopyDirectoriesIndepth("..", "temp") ? "copy success" : "copy unsuccess");
			}
			else {
				array_push($messages, "Deletion of downloaded zipped file was failed.");
			}
		}
	}
	else {
		array_push($messages, "File downloading from online source was failed.");
	}

	foreach ($messages as $index => $value) {
		echo ($index + 1) . ": {$value}<br>";
	}

	function CopyDirectoriesIndepth(string $fromDirectory, string $toDirectoryAnother) {
		$result = false;
		if (is_dir($fromDirectory)) {
			$toDirectoryAnotherExists = false;
			if (!is_dir($toDirectoryAnother)) {
				$toDirectoryAnotherExists = mkdir($toDirectoryAnother);
			}
			else {
				$toDirectoryAnotherExists = true;
			}
			if ($toDirectoryAnotherExists) {
				$originalCount = 0;
				foreach (scandir($fromDirectory) as $index => $value) {
					if (!(str_starts_with($value, ".") || $value == "install")) {
						$originalCount++;
						$sourceFilePath = "{$fromDirectory}/{$value}";
						if (is_file($sourceFilePath)) {
							$destinationFilePath = "{$toDirectoryAnother}/{$value}";
							//echo "> {$destinationFilePath}" . "<br>";
							$oldFileDeleted = true;
							if (file_exists($destinationFilePath) && is_file($destinationFilePath)) {
								$oldFileDeleted = unlink($destinationFilePath);
							}
							if ($oldFileDeleted) {
								echo "{$sourceFilePath} -> {$destinationFilePath}<br>";
								//$result = copy("{$fromDirectory}/{$value}", "{$toDirectoryAnother}/{$value}");
							}
						}
						$result = CopyDirectoriesIndepth("{$fromDirectory}/{$value}", "{$toDirectoryAnother}/{$value}");
					}
				}

				$copiedCount = 0;
				foreach (scandir($toDirectoryAnother) as $index => $value) {
					if (!(str_starts_with($value, ".") || $value == "install")) {
						$copiedCount++;
					}
				}

				//echo "{$originalCount} | {$copiedCount}<br>";
				if ($originalCount == $copiedCount) {
					$result = true;
				}
				else {
					$result = false;
				}
			}
		}
		return $result;
	}
?>
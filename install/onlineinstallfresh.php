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
				CopyDirectoriesIndepth("../", "temp/");
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
		if (is_dir($fromDirectory)) {
			$toDirectoryAnotherExists = false;
			if (!is_dir($toDirectoryAnother)) {
				$toDirectoryAnotherExists = mkdir($toDirectoryAnother);
			}
			else {
				$toDirectoryAnotherExists = true;
			}
			if ($toDirectoryAnotherExists) {
				foreach (scandir($fromDirectory) as $index => $value) {
					//if (!($value == "." || $value == ".."  || $value == "install" || $value == ".git")) {
					if (!(str_starts_with($value, ".") || $value == "install")) {
						echo $value . "<br>";

						//CopyDirectoriesIndepth("{$fromDirectory}/{$value}", "{$toDirectoryAnother}/{$value}");
					}
				}
			}
		}
	}
?>
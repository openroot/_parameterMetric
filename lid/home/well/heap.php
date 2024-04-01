<?php
	namespace lid\home\well\heap;
?>

<?php
	use lid\home\well\pull as lidpull;
?>

<?php
	class Platform {
		protected Directory $directory;
		protected File $file;
		protected lidpull\Pull $pull;

		public function __construct() {
			try {
				$success = false;
				$this->directory = new Directory();
				$this->file = new File();
				if ($this->directory && $this->file && $this->RequireonceDirectory("home/well")) {
					$this->pull = new lidpull\Pull();
					if ($this->pull) {
						$success = true;
					}
				}
				if (!$success) {
					die("Execution interrupted. Possibly it gets fixed on refresh.");
				}
			}
			catch (\Exception $exception) {}
		}

		public function RequireonceDirectory(string $directoryPath) {
			$scripts = array();
			foreach ($this->file->FileListRefresh($directoryPath) as $index => $value) {
				$fileFullPath = $this->directory->DirectoryPathTop() . "/{$directoryPath}/{$value}";
				if (!$this->CurrentScript($fileFullPath)) {
					array_push($scripts, $fileFullPath);
				}
			}
			$successCount = 0;
			$scriptsCount = count($scripts);
			if ($scriptsCount > 0) {
				foreach ($scripts as $index => $value) {
					if(require_once($value)) {
						$successCount++;
					}
				}
			}
			else {
				$scriptsCount = -1;
			}
			return $scriptsCount == $successCount ? true : false;
		}

		public function RequireonceDirectoryArray(array $directoryPaths) {
			// TODO: This function is not verified yet, verify after real implementation.
			$result = true;
			if (count($directoryPaths) > 0) {
				foreach($directoryPaths as $index => $value) {
					if (!$this->RequireonceDirectory($value)) {
						$result = false;
						break;
					}
				}
			}
			else {
				$result = false;
			}
			return $result;
		}

		public function RequireonceFile(string $directoryPath, string $fileName) {
			$fileFullPath = $this->directory->DirectoryPathTop() . "/{$directoryPath}/{$fileName}";
			if (!$this->CurrentScript($fileFullPath)) {
				if (is_file($fileFullPath)) {
					return require_once($fileFullPath);
				}
			}
			return false;
		}

		private function CurrentScript(string $scriptFile) {
			$presentFile = str_replace("\\", "/", __FILE__);
			$scriptFile = $scriptFile[0] == "." ? substr($scriptFile, 1) : $scriptFile;
			return str_contains($presentFile, $scriptFile) ? true : false;
		}
	}

	class Directory {
		protected string $directoryPathTop = "";
		protected array $directoryList = array();
		private string $directoryPathTopDefault = "./lid";

		public function __construct(?string $directoryPathTop = null) {
			$this->directoryPathTop = empty($directoryPathTop) ? $this->directoryPathTopDefault : $directoryPathTop;
		}

		public function DirectoryPathTop() {
			return $this->directoryPathTop;
		}

		public function DirectoryListRecent() {
			return $this->directoryList;
		}

		public function DirectoryListRefresh(?string $directoryPath = null) {
			array_splice($this->directoryList, 0, count($this->directoryList));
			$this->DirectoryListScan(empty($directoryPath) ? "" : $directoryPath);
			return $this->directoryList;
		}

		public function MakeDirectory(string $directoryPath) {
			$directoryFinePathAs = $this->DirectoryFinePathAs($directoryPath);
			if (!file_exists($directoryFinePathAs)) {
				return mkdir($directoryFinePathAs);
			}
			return false;
		}

		public function DeleteDirectory(string $directoryPath) {
			$result = false;
			$directoryFinePathAs = $this->DirectoryFinePathAs($directoryPath);
			if (is_dir($directoryFinePathAs)) {
				$directoryParentName = substr($directoryFinePathAs, 0, strrpos($directoryFinePathAs, "/"));
				$directoryOriginalName = substr($directoryFinePathAs, strrpos($directoryFinePathAs, "/") + 1);
				if ($this->DirectoryFoundAt($this->DirectoryListRefresh($this->DirectoryUnfinedPathAs($directoryParentName)), $directoryOriginalName)) {
					$directoryRecyclebinPath = "home/margosa/spin/algebrafate/recyclebin";
					$this->MakeDirectory($directoryRecyclebinPath);
					if (is_dir($this->DirectoryFinePathAs($directoryRecyclebinPath))) {
						return rename($directoryFinePathAs, "{$this->directoryPathTop}/{$directoryRecyclebinPath}/{$directoryOriginalName}" . $this->CurrentTimePlatformSafe());
					}
				}
			}
			return $result;
		}

		public function MoveDirectoryRecursive(string $directoryPath, string $locationPath) {
			$result = false;
			$directoryFinePathAs = $this->DirectoryFinePathAs($directoryPath);
			if (is_dir($directoryFinePathAs)) {
				$this->MakeDirectory($locationPath);
				//if (is_dir($this->DirectoryFinePathAs($locationPath))) {
					//return rename($directoryFinePathAs, "{$this->directoryPathTop}/{$locationPath}/{$directoryPath}");
				//}
			}
			return $result;
		}

		public function DirectoryFinePathAs(string $directoryPath) {
			return "{$this->directoryPathTop}/{$directoryPath}";
		}

		public function DirectoryUnfinedPathAs(string $directoryFinePathAs) {
			return strpos($directoryFinePathAs, $this->directoryPathTop) == 0 ? substr($directoryFinePathAs, strlen($this->directoryPathTop) + 1) : false;
		}

		public function DirectoryFoundAt(array $directoryPaths, string $directoryName) {
			$result = false;
			foreach ($directoryPaths as $index => $value) {
				if (strcmp(substr($value, strrpos($value, "/") + 1), $directoryName) == 0) {
					if (is_dir($this->DirectoryFinePathAs($value))) {
						$result = true;
					}
				}
			}
			return $result;
		}

		private function DirectoryListScan(string $directoryPath) {
			foreach ($this->DirectoryListFilter($this->DirectoryFinePathAs($directoryPath)) as $index => $value) {
				$directoryFound = "{$directoryPath}/{$value}";
				$directoryFound = strpos($directoryFound, "/") == 0 ? substr($directoryFound, 1) : $directoryFound;
				array_push($this->directoryList, $directoryFound);
				$this->DirectoryListScan("{$directoryPath}/{$value}");
			}
		}

		private function DirectoryListFilter(string $directoryPath) {
			$filteredList = array();
			if (is_dir($directoryPath)) {
				foreach (scandir($directoryPath) as $index => $value) {
					if (!($value == "." || $value == "..") && is_dir("{$directoryPath}/{$value}")) {
						array_push($filteredList, $value);
					}
				}
			}
			return $filteredList;
		}

		private function CurrentTimePlatformSafe(?string $timeZone = "UTC") {
			$currentTime = new \DateTime("now", new \DateTimeZone($timeZone));
			if ($currentTime != null) {
				$timeZone = substr($currentTime->format("O"), 1);
				return $currentTime->format("__H_i_s_u__d_m_Y__D__{$timeZone}");
			}
			return false;
		}
	}

	class File {
		private Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
		}

		public function FileListRefresh(string $directoryPath) {
			$filteredList = array();
			$directoryFinePathAs = $this->directory->DirectoryFinePathAs($directoryPath);
			if (is_dir($directoryFinePathAs)) {
				foreach (scandir($directoryFinePathAs) as $index => $value) {
					if (!($value == "." || $value == "..") && is_file("{$directoryFinePathAs}/{$value}")) {
						array_push($filteredList, $value);
					}
				}
			}
			return $filteredList;
		}
	}
?>

<?php
	use lid\home\well\heap as lidheap;

	class Specimen {
		public function __construct() {
			echo "use lid\home\well\heap as lidheap;<br>\$platform = new lidheap\Platform();<br>\$directory = new lidheap\Directory();<br>\$file = new lidheap\File();<br><br>";
			$platform = new lidheap\Platform();
			$directory = new lidheap\Directory();
			$file = new lidheap\File();

			echo "\$platform->RequireonceDirectory(\"home/margosa/now\");";
			if ($platform->RequireonceDirectory("home/margosa/now")) {
				echo "<pre>RequireonceDirectory, successfull.</pre>";
			}
			echo "\$platform->RequireonceFile(\"home/well\", \"water.php\");";
			if ($platform->RequireonceFile("home/well", "water.php")) {
				echo "<pre>RequireonceFile, successfull.</pre>";
			}

			echo "\$directory->DirectoryListRecent();";
			echo "<pre>"; print_r($directory->DirectoryListRecent()); echo "</pre>";
			echo "\$directory->DirectoryListRefresh(\"home/margosa\");";
			echo "<pre>"; print_r($directory->DirectoryListRefresh("home/margosa")); echo "</pre>";
			echo "\$directory->DirectoryListRecent();";
			echo "<pre>"; print_r($directory->DirectoryListRecent()); echo "</pre>";

			echo "\$directory->MakeDirectory(\"home/margosa/spin/algebrafate/ARandomDirectory\");";
			echo "<pre>"; echo $directory->MakeDirectory("home/margosa/spin/algebrafate/ARandomDirectory") ? "Directory made." : "Directory not made or already exists."; echo "</pre>";
			echo "\$directory->DeleteDirectory(\"home/margosa/spin/algebrafate/ARandomDirectory\");";
			echo "<pre>"; echo $directory->DeleteDirectory("home/margosa/spin/algebrafate/ARandomDirectory") ? "Directory deleted." : "Directory not deleted or not exists."; echo "</pre>";

			echo "<pre>"; echo $directory->DeleteDirectory("home/analyze") ? "Directory deleted." : "Directory not deleted or not exists."; echo "</pre>";
			echo "<pre>"; echo $directory->DeleteDirectory("home/machine") ? "Directory deleted." : "Directory not deleted or not exists."; echo "</pre>";
			
			echo "\$directory->DirectoryListRefresh();";
			echo "<pre>"; print_r($directory->DirectoryListRefresh()); echo "</pre>";

			echo "\$file->FileListRefresh(\"home/margosa/now\");";
			echo "<pre>"; print_r($file->FileListRefresh("home/margosa/now")); echo "</pre>";
		}
	}
?>
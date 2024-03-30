<?php
	namespace parametermetric\home\well\heap;

	class Platform {
		protected Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
		}

		public function RequireOnceDirectory(string $directoryPath) {
			$scripts = array();
			foreach ($this->directory->FileListRefresh($directoryPath) as $index => $value) {
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

		public function RequireOnceDirectoryArray(array $directoryPaths) {
			// TODO: This function is not verified yet, verify after real implementation.
			$result = true;
			if (count($directoryPaths) > 0) {
				foreach($directoryPaths as $index => $value) {
					if (!$this->RequireOnceDirectory($value)) {
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

		public function RequireOnceFile(string $directoryPath, string $fileName) {
			$fileFullPath = $this->directory->DirectoryPathTop() . "/{$directoryPath}/{$fileName}";
			if (!$this->CurrentScript($fileFullPath)) {
				if (is_file($fileFullPath)) {
					return require_once($fileFullPath);
				}
			}
			return false;
		}

		private function CurrentScript(string $scriptFile) {
			return str_contains(str_replace("\\", "/", __FILE__), $scriptFile) ? true : false;
		}
	}

	class Directory {
		protected string $directoryPathTop = "";
		protected array $directoryList = array();

		public function __construct(?string $directoryPathTop = null) {
			$this->directoryPathTop = empty($directoryPathTop) ? "./parametermetric" : $directoryPathTop;
			$this->DirectoryListRefresh();
		}

		public function DirectoryPathTop() {
			return $this->directoryPathTop;
		}

		public function DirectoryList() {
			return $this->directoryList;
		}

		public function DirectoryListRefresh(?string $directoryPath = null) {
			array_splice($this->directoryList, 0, count($this->directoryList));
			$this->DirectoryListScan(empty($directoryPath) ? "" : $directoryPath);
			return $this->directoryList;
		}

		public function FileListRefresh(string $directoryPath) {
			$filteredList = array();
			$directoryFinePathAs = $this->DirectoryFinePathAs($directoryPath);
			if (is_dir($directoryFinePathAs)) {
				foreach (scandir($directoryFinePathAs) as $index => $value) {
					if (!($value == "." || $value == "..") && is_file("{$directoryFinePathAs}/{$value}")) {
						array_push($filteredList, $value);
					}
				}
			}
			return $filteredList;
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

				$this->DirectoryFoundAt($this->DirectoryListRefresh($this->DirectoryUnfinedPathAs($directoryParentName)));

				$directoryOriginalName = substr($directoryFinePathAs, strrpos($directoryFinePathAs, "/") + 1);
				$directoryNewName = "{$this->directoryPathTop}/home/margosa/spin/algebrafate/{$directoryOriginalName}" . $this->CurrentTimePlatformSafe();
				echo $directoryParentName;
				//return rename($directoryFinePathAs, $directoryNewName);
			}
			return $result;
		}

		protected function DirectoryFinePathAs(string $directoryPath) {
			return "{$this->directoryPathTop}/{$directoryPath}";
		}

		protected function DirectoryUnfinedPathAs(string $directoryFinePathAs) {
			return strpos($directoryFinePathAs, $this->directoryPathTop) == 0 ? substr($directoryFinePathAs, strlen($this->directoryPathTop) + 1) : false;
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

		private function DirectoryFoundAt(array $directoryPaths) {
			foreach ($directoryPaths as $index => $value) {
				echo $index . " -> " . $value . "<br>";
			}
		}

		private function CurrentTimePlatformSafe(?string $timeZone = "Asia/Kolkata") {
			$currentTime = new \DateTime("now", new \DateTimeZone($timeZone));
			if ($currentTime != null) {
				$timeZone = substr($currentTime->format("O"), 1);
				return $currentTime->format("__H_i_s_u__d_m_Y__D__{$timeZone}");
			}
			return false;
		}
	}

	use parametermetric\home\well\heap as wand;
	class Specimen {
		public function __construct() {
			$platform = new wand\Platform();
			$directory = new wand\Directory();

			if ($platform->RequireOnceDirectory("home/margosa/now")) {
				echo "<pre>RequireOnceDirectory, successfull.</pre>";
			}
			if ($platform->RequireOnceFile("", "water.php")) {
				echo "<pre>RequireOnceFile, successfull.</pre>";
			}

			//echo "<pre>"; print_r($directory->DirectoryList()); echo "</pre>";
			//echo "<pre>"; print_r($directory->DirectoryListRefresh("home/margosa")); echo "</pre>";
			//echo "<pre>"; print_r($directory->DirectoryList()); echo "</pre>";
			//echo "<pre>"; print_r($directory->FileListRefresh("home/margosa/now")); echo "</pre>";

			echo "<pre>"; echo $directory->MakeDirectory("home/margosa/spin/algebrafate/delete") ? "Directory made." : "Directory not made or already exists."; echo "</pre>";
			echo "<pre>"; echo $directory->DeleteDirectory("home/margosa/spin/algebrafate/aRandomdirectory") ? "Directory deleted." : "Directory not deleted or not exists."; echo "</pre>";
			//echo "<pre>"; print_r($directory->DirectoryListRefresh()); echo "</pre>";
		}
	}
?>
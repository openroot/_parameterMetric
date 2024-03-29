<?php
	namespace parametermetric\home\well\heap;

	class Platform {
		protected Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
		}

		public function RequireOnceFile(string $directoryPath, string $fileName) {
			$fileFullPath = $this->directory->DirectoryPathTop() . "/{$directoryPath}/{$fileName}";
			if (!$this->CurrentScript($fileFullPath)) {
				return require_once($fileFullPath);
			}
			return false;
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
			$directoryFinePath = "{$this->directoryPathTop}/{$directoryPath}";
			if (is_dir($directoryFinePath)) {
				foreach (scandir($directoryFinePath) as $index => $value) {
					if (!($value == "." || $value == "..") && is_file("{$directoryFinePath}/{$value}")) {
						array_push($filteredList, $value);
					}
				}
			}
			return $filteredList;
		}

		private function DirectoryListScan(string $directoryPath) {
			$directoryFinePath = "{$this->directoryPathTop}/{$directoryPath}";
			foreach ($this->DirectoryListFilter($directoryFinePath) as $index => $value) {
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
	}

	use parametermetric\home\well\heap as wand;
	class Specimen {
		public function __construct() {
			$platform = new wand\Platform();
			$directory = new wand\Directory();

			if ($platform->RequireOnceDirectory("home/margosa")) {
				echo "<pre>RequireOnceDirectory, successfull.</pre>";
			}
			else {
				echo "<pre>RequireOnceDirectory, unsuccessfull.</pre>";
			}

			

			if ($platform->RequireOnceFile("", "water.php")) {
				echo "<pre>RequireOnceFile, successfull.</pre>";
			}
			else {
				echo "<pre>RequireOnceFile, unsuccessfull.</pre>";
			}

			if ($platform->RequireOnceFile("home/margosa/branch", "heap.php")) {
				echo "<pre>RequireOnceFile, successfull.</pre>";
			}
			else {
				echo "<pre>RequireOnceFile, unsuccessfull.</pre>";
			}

			echo "<pre>"; print_r($directory->DirectoryList()); echo "</pre>";
			echo "<pre>"; print_r($directory->DirectoryListRefresh("home/margosa")); echo "</pre>";
			echo "<pre>"; print_r($directory->DirectoryList()); echo "</pre>";
			echo "<pre>"; print_r($directory->FileListRefresh("home/margosa")); echo "</pre>";
		}
	}
?>
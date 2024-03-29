<?php
	namespace parametermetric\home\entrance;

	class Platform {
		private Directory $directory;
		public function __construct() {
			$this->directory = new Directory();

			echo "<pre>"; print_r($this->directory->DirectoryList()); echo "</pre>";
			echo "<pre>"; print_r($this->directory->DirectoryListRefresh("home/dhop")); echo "</pre>";
			echo "<pre>"; print_r($this->directory->DirectoryList()); echo "</pre>";
			echo "<pre>"; print_r($this->directory->FileListRefresh("home/dhop")); echo "</pre>";

			$this->RequireOnce("home/dhop");
		}

		public function RequireOnce(string $directoryPath) {
			foreach ($this->directory->FileListRefresh($directoryPath) as $index => $value) {
				$fileFullPath = "{$directoryPath}/{$value}";
				if (!$this->CurrentScript($fileFullPath)) {
					echo $fileFullPath;
				}
			}
		}

		private function CurrentScript(string $scriptFile) {
			$result = strpos($scriptFile, pathinfo(__FILE__, PATHINFO_FILENAME));
			return $result > -1 ? true : false;
		}
	}

	class Directory {
		private string $directoryPathTop = "";
		private array $directoryList = array();

		public function __construct(?string $directoryPathTop = null) {
			$this->directoryPathTop = empty($directoryPathTop) ? "./parametermetric" : $directoryPathTop;
			$this->DirectoryListRefresh();
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
				$directoryFound = strpos($directoryFound, "/") == 0 ? substr("{$directoryFound}", 1) : $directoryFound;
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

	class Specimen {
		public function __construct() {
			$platform = new Platform();
		}
	}
?>
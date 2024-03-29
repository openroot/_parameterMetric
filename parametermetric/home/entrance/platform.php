<?php
	namespace parametermetric\home\entrance;

	class Platform {
		protected Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
		}

		public function RequireOnceDirectory(string $directoryPath) {
			foreach ($this->directory->FileListRefresh($directoryPath) as $index => $value) {
				$fileFullPath = "{$directoryPath}/{$value}";
				if (!$this->CurrentScript($fileFullPath)) {
					require_once($this->directory->DirectoryPathTop() . "/{$fileFullPath}");
				}
			}
		}

		public function RequireOnceDirectoryArray(array $directoryPaths) {
			foreach($directoryPaths as $index => $value) {
				$this->RequireOnceDirectory($value);
			}
		}

		private function CurrentScript(string $scriptFile) {
			$result = strpos($scriptFile, pathinfo(__FILE__, PATHINFO_FILENAME));
			return $result > -1 ? true : false;
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
			$directory = new Directory();

			$platform->RequireOnceDirectory("home/entrance");

			echo "<pre>"; print_r($directory->DirectoryList()); echo "</pre>";
			echo "<pre>"; print_r($directory->DirectoryListRefresh("home/dhop")); echo "</pre>";
			echo "<pre>"; print_r($directory->DirectoryList()); echo "</pre>";
			echo "<pre>"; print_r($directory->FileListRefresh("home/dhop")); echo "</pre>";
		}
	}
?>
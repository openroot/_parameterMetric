<?php
	namespace parametermetric\home\entrance;

	class Platform {
		public function __construct() {
			$platformDirectory = new Directory();

			print_r($platformDirectory->DirectoryList());
			print_r($platformDirectory->FileListScan("home/dhop/flop"));
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

		public function DirectoryListRefresh() {
			$this->DirectoryListScan($this->directoryPathTop);
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

		public function DirectoryListScan(string $directoryPath) {
			foreach ($this->DirectoryListFilter($directoryPath) as $index => $value) {
				array_push($this->directoryList, substr("{$directoryPath}/{$value}", 2));
				$this->DirectoryListScan("{$directoryPath}/{$value}");
			}
		}

		public function FileListScan(string $directoryPath) {
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
	}

	class Specimen {
		public function __construct() {
			$platform = new Platform();
		}
	}
?>
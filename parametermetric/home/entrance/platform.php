<?php
	namespace parametermetric\home\entrance;

	class Platform {
		private string $primaryDirectoryPath = "";
		private string $temporaryDirectoryPath = "";
		private array $directoryList = array();

		public function __construct() {
			$this->primaryDirectoryPath = "parametermetric";



			$this->DirectoryListRefresh();
			print_r($this->directoryList);
		}

		public function DirectoryListRefresh() {
			$this->DirectoryScan("./{$this->primaryDirectoryPath}");
		}

		private function DirectoryScan(string $directoryPath) {
			if (is_dir($directoryPath)) {
				$unfilteredList = scandir($directoryPath);
				$filteredList = $this->DirectoryFilter($unfilteredList);
				foreach ($filteredList as $index => $value) {
					$directoryFullPath = substr("{$directoryPath}/{$value}", 2);
					array_push($this->directoryList, $directoryFullPath);
					$this->DirectoryScan("./{$directoryFullPath}");
				}
			}
		}

		private function DirectoryFilter(array $unfilteredList) {
			$filteredList = array();
			foreach ($unfilteredList as $index => $value) {
				switch ($value) {
					case ".": case "..": break;
					default: array_push($filteredList, $value);
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
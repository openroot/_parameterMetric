<?php
	namespace parametermetric\home\entrance;

	class Platform {
		private string $directoryPathTop = "";
		private array $directoryList = array();

		public function __construct(?string $directoryPathTop = null) {
			$this->directoryPathTop = empty($directoryPathTop) ? "./parametermetric" : $directoryPathTop;

			$this->DirectoryListRefresh("{$this->directoryPathTop}");
			print_r($this->directoryList);
		}

		private function DirectoryListRefresh(string $directoryPath) {
			foreach ($this->DirectoryListFilter($directoryPath) as $index => $value) {
				array_push($this->directoryList, substr("{$directoryPath}/{$value}", 2));
				$this->DirectoryListRefresh("{$directoryPath}/{$value}");
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
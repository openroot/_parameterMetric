<?php
	namespace parametermetric\home\entrance;

	class Platform {
		private string $primaryDirectoryPath = "";

		public function __construct() {
			$this->primaryDirectoryPath = "./parametermetric";
		}

		public function DirectoryScan () {
			$files = scandir($this->primaryDirectoryPath);
			var_dump($files);
		}
	}

	class Specimen {
		public function __construct() {
			$platform = new Platform();

			$platform->DirectoryScan();
		}
	}
?>
<?php
	namespace lid\home\well\pull;
?>

<?php
	use lid\home\well\heap as lidheap;
	use lid\home\well\water as lidwater;
?>

<?php
	class Pull {
		private lidwater\Brick $brick;
		private lidheap\Directory $directory;

		public function __construct() {
			$this->brick = new lidwater\Brick();
			$this->directory = new lidheap\Directory();
			if ($this->brick && $this->directory) {
				$this->prepareFlats();
				$this->prepareHids();
			}
		}

		public function prepareFlats() {
			if (count($this->brick->fetchFlats()) > 0) {
				foreach ($this->brick->fetchFlats() as $index => $value) {
					$this->directory->MakeDirectory($value);
				}
			}
		}

		public function prepareHids() {
			if (count($this->brick->fetchHids()) > 0) {
				$directoryHidPath = "home/well/hid";
				foreach ($this->brick->fetchHids() as $index => $value) {
					$this->directory->CopyDirectoryRecursive("{$directoryHidPath}/{$value}", "");
				}
			}
		}
	}
?>

<?php
	use lid\home\well\pull as lidping;

	class Specimen {
		public function __construct() {}
	}
?>
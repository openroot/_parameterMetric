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
				$this->PrepareFlats();
				$this->PrepareHids();
			}
		}

		public function PrepareFlats() {
			if (count($this->brick->ReadFlats()) > 0) {
				foreach ($this->brick->ReadFlats() as $index => $value) {
					$this->directory->MakeDirectory($value);
				}
			}
		}

		public function PrepareHids() {
			if (count($this->brick->ReadHids()) > 0) {
				$directoryHidPath = "home/well/hid";
				foreach ($this->brick->ReadHids() as $index => $value) {
					$this->directory->CopyDirectoryLeaveindepth("{$directoryHidPath}/{$value}", "");
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
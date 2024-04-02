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
				$this->PrepareBrickFlats();
				$this->PrepareBrickHids();
			}
		}

		public function PrepareBrickFlats() {
			if (count($this->brick->ReadFlats()) > 0) {
				foreach ($this->brick->ReadFlats() as $index => $value) {
					$this->directory->MakeDirectory($value);
				}
			}
			return true;
		}

		public function PrepareBrickHids() {
			if (count($this->brick->ReadHids()) > 0) {
				foreach ($this->brick->ReadHids() as $index => $value) {
					$this->directory->CopyDirectoryLeaveindepth($this->brick->ReadHidDirectoryPath() . "/{$value}", "");
				}
			}
			return true;
		}
	}
?>

<?php
	use lid\home\well\pull as lidping;

	class Specimen {
		public function __construct() {
			$pull = new lidping\Pull();

			echo "<h6>1</h6>";
			echo $pull->PrepareBrickFlats() ? "Success" : "Unsuccess";

			echo "<h6>2</h6>";
			echo $pull->PrepareBrickHids() ? "Success" : "Unsuccess";
		}
	}
?>
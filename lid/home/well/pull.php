<?php
	namespace lid\home\well\pull;
?>

<?php
	use lid\home\well\water as lidwater;
	use lid\home\well\heap as lidheap;
?>

<?php
	class Pull {
		private lidwater\Brick $brick;
		private lidheap\Directory $directory;

		public function __construct() {
			$this->brick = new lidwater\Brick();
			$this->directory = new lidheap\Directory();
			if ($this->brick && $this->directory) {
				$this->TripBrickFlats();
				$this->TripBrickHids();
			}
		}

		protected function TripBrickFlats() {
			if (count($this->brick->ReadFlats()) > 0) {
				foreach ($this->brick->ReadFlats() as $index => $value) {
					$this->directory->MakeDirectory($value);
				}
			}
			return true;
		}

		protected function TripBrickHids() {
			if (count($this->brick->ReadHids()) > 0) {
				foreach ($this->brick->ReadHids() as $index => $value) {
					$this->directory->CopyDirectoryLeaveIndepth($this->brick->ReadHidDirectoryPath() . "/{$value}", "");
				}
			}
			return true;
		}
	}
?>

<?php
	use lid\home\well\pull as lidping;

	class Specimen extends lidping\Pull {
		public function __construct() {
			$pull = new lidping\Pull();

			echo "<h6>1: Pull - TripBrickFlats</h6>";
			echo $pull->TripBrickFlats() ? "Success" : "Unsuccess";

			echo "<h6>2: Pull - TripBrickHids</h6>";
			echo $pull->TripBrickHids() ? "Success" : "Unsuccess";
		}
	}
?>
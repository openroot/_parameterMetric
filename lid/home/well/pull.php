<?php
	namespace lid\home\well\pull;
?>

<?php
	use lid\home\well\heap as lidheap;
	use lid\home\well\joint as lidjoint;
	use lid\home\well\water as lidwater;
?>

<?php
	class Pull extends lidjoint\Joint {
		private lidheap\Directory $directory;
		private lidwater\Brick $brick;

		public function __construct() {
			$this->directory = new lidheap\Directory();
			$this->brick = new lidwater\Brick();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($this->brick) && lidjoint\Joint::SearchMaterialAsAuthentic($this->directory)) {
				$this->TripBrickFlats();
				$this->TripBrickHids();
			}
			else {
				$this->baseId = -1;
			}
			parent::__construct($this);
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
<?php
	namespace lid\home\well\push;
?>

<?php
	use lid\home\well\heap as lidheap;
	use lid\home\well\joint as lidjoint;
	use lid\home\well\water as lidwater;
?>

<?php
	class Push extends lidjoint\Joint {
		protected lidheap\Street $street;
		private lidwater\Dye $dye;

		public function __construct() {
			$this->street = new lidheap\Street();
			$this->dye = new lidwater\Dye();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($this->dye) && lidjoint\Joint::SearchMaterialAsAuthentic($this->street)) {
				$this->TripDyeRegions();
			}
			else {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}

		public function ReadStreet() {
			return $this->street;
		}

		protected function TripDyeRegions() {
			$regionsCount = count($this->dye->ReadRegions());
			if ($regionsCount > 0) {
				$successCount = 0;
				foreach ($this->dye->ReadRegions() as $index => $value) {
					if ($this->street->SetGets($value)) {
						$successCount++;
					}
				}
			}
			if ($successCount == $regionsCount) {
				return true;
			}
			else {
				return false;
			}
		}
	}
?>

<?php
	use lid\home\well\push as lidpong;

	class Specimen extends lidpong\Push {
		public function __construct() {
			$push = new lidpong\Push();
			
			echo "<h6>1: Push - ReadStreet, ReadGets</h6>";
			echo "<pre>";
			print_r($push->ReadStreet()->ReadGets());
			echo "</pre>";

			echo "<h6>2: Push - TripDyeRegions</h6>";
			echo $push->TripDyeRegions() ? "Success" : "Unsuccess";
		}
	}
?>
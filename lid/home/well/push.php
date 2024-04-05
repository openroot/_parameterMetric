<?php
	namespace lid\home\well\push;
?>

<?php
	use lid\home\well\water as lidwater;
	use lid\home\well\heap as lidheap;
?>

<?php
	class Push {
		private lidwater\Dye $dye;
		protected lidheap\Street $street;

		public function __construct(lidheap\Street $street) {
			$this->dye = new lidwater\Dye();
			$this->street = $street;

			if ($this->dye && $this->street) {
				$this->TripDyeRegions();
			}
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

	class Specimen {
		public function __construct() {
			$push = new lidpong\Push();
		}
	}
?>
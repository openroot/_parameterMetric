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

		public function __construct() {
			$this->brick = new lidwater\Brick();
			$this->prepareFlats();
		}

		public function prepareFlats() {
			if (count($this->brick->fetchFlats()) > 0) {
				$directory = new lidheap\Directory();
				if ($directory) {
					foreach ($this->brick->fetchFlats() as $index => $value) {
						$directory->MakeDirectory($value);
					}
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
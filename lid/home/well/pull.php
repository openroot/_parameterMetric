<?php
	namespace lid\home\well\pull;
?>

<?php
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
			foreach ($this->brick->fetchFlats() as $index => $value) {
				echo "{$value}<br>";
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
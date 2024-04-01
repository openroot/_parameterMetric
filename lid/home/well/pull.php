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
		}

		public function prepareFlats() {

		}
	}
?>

<?php
	use lid\home\well\pull as lidping;

	class Specimen {
		public function __construct() {}
	}
?>
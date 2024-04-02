<?php
	namespace lid\home\well\joint;
?>

<?php
?>

<?php
	class Joint {
		public function __construct() {}

		public function Test() {
			return "I know HTML.";
		}
	}
?>

<?php
	use lid\home\well\joint as lidreason;

	class Specimen {
		public function __construct() {
			$joint = new lidreason\Joint();

			echo "<h6>1</h6>";
			echo $joint->Test();
		}
	}
?>
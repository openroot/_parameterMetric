<?php
	namespace lid\home\well\joins;
?>

<?php
?>

<?php
	class Joins {
		public function __construct() {}

		public function Test() {
			return "I know PHP.";
		}
	}
?>

<?php
	use lid\home\well\joins as lidseason;

	class Specimen {
		public function __construct() {
			$joins = new lidseason\Joins();

			echo "<h6>1</h6>";
			echo $joins->Test();
		}
	}
?>
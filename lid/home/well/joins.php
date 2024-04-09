<?php
	namespace lid\home\well\joins;
?>

<?php
	use lid\home\well\joint as lidjoint;
?>

<?php
	class Joins extends lidjoint\Joint {
		public function __construct() {
			parent::__construct($this);
		}

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
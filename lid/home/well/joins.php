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

	class Specimen extends lidjoint\Joint {
		public function __construct() {
			$joins = new lidseason\Joins();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($joins)) {
				echo "<h6>1</h6>";
				echo $joins->Test();
			}
			else {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}
	}
?>
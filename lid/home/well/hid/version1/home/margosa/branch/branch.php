<?php
	namespace lid\home\margosa\branch;
?>

<?php
?>

<?php
	class Branch {
		public function __construct() {}

		public function Around() {
			return "Singing & Playing PHP.";
		}
	}
?>

<?php
	use lid\home\margosa\branch as lidbranch;

	class Specimen {
		public function __construct() {
			$branch = new lidbranch\Branch();

			echo "<h6>1</h6>";
			echo $branch->Around();
		}
	}
?>

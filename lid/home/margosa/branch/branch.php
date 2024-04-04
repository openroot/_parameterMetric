<?php
	namespace lid\home\margosa\branch;
?>

<?php
?>

<?php
	class Branch {
		public function __construct() {}

		public function Around() {
			for ($i = 1; $i <= 3 ; $i++) {
				sleep(1); //$sec = 1; usleep(1000000 * $sec);
				$this->Here();
			}
		}

		public function Here() {
			echo "Singing & Playing PHP.<br>";
		}
	}
?>

<?php
	use lid\home\margosa\branch as lidbranch;

	class Specimen {
		public function __construct() {
			$branch = new lidbranch\Branch();

			echo "<h6>1</h6>";
			$branch->Around();
		}
	}
?>

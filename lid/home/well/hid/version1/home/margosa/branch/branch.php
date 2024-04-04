<?php
	namespace lid\home\margosa\branch;
?>

<?php
?>

<?php
	class Branch {
		private ?array $arguments;

		public function __construct(?array $arguments = null) {
			$this->arguments = $arguments;
		}

		public function Around() {
			for ($i = 1; $i <= 5 ; $i++) {
				$this->Here();
			}
		}

		public function Here() {
			echo "Singing & Playing `PHP`.<br>";
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

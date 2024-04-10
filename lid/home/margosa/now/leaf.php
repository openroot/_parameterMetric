<?php
	namespace lid\home\margosa\now\leaf;
?>

<?php
?>

<?php
	class Leaf {
		public function __construct() {}
	}
?>

<?php
	use lid\home\margosa\now\leaf as lidleave;
	use lid\home\well\joint as lidjoint;

	class Specimen {
		public function __construct() {
			echo "<h6>1: Leaf - __construct</h6>";
			echo "<pre>";
			print_r((new lidjoint\Joint(new lidleave\Leaf()))->Signature());
			echo "</pre>";
		}
	}
?>

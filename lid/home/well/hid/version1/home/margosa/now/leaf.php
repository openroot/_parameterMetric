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
			echo "<h6>1: Joint - Signature | {Signature of PHP class - Leaf (by object)}</h6>";
			echo "<pre>";
			print_r((new lidjoint\Joint(new lidleave\Leaf()))->Signature());
			echo "</pre>";

			echo "<h6>2: Joint - Signature (\"lid\home\margosa\\now\\flower\Me\") | {Signature of PHP class - Me (by name)}</h6>";
			echo "<pre>";
			print_r((new lidjoint\Joint(null))->Signature("lid\home\margosa\\now\\flower\Me"));
			echo "</pre>";
		}
	}
?>

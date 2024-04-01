<?php
	namespace parametermetric\home\well\joins;
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	$platform = new \parametermetric\home\well\heap\Platform();

	$platform->RequireonceFile("home/well", "joint.php");
	use parametermetric\home\well\joint as joint;
?>

<?php
	class Joins extends joint\Joint {
		public function __construct() { }

		public function Test() {
			return parent::Test() . " PHP gets used with, HTML I know too.";
		}
	}
?>

<?php
	use parametermetric\home\well\joins as season;

	class Specimen {
		public function __construct() {
			echo "use parametermetric\home\well\joins as season;<br>\$joins = new season\Joins();<br><br>";
			$joins = new season\Joins();

			echo "\$joins->Test();";
			echo "<pre>"; echo $joins->Test(); echo "</pre>";
		}
	}
?>
<?php
	namespace parametermetric\home\well\joins;
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	use parametermetric\home\well\heap as heap;
?>

<?php
	class Joins {
		public function __construct() {}

		public function Test() {
			return "I know HTML.";
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
<?php
	namespace parametermetric\home\well\joint;
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	use parametermetric\home\well\heap as heap;
?>

<?php
	class Joint {
		public function __construct() {}

		public function Test() {
			return "I know PHP.";
		}
	}
?>

<?php
	use parametermetric\home\well\joint as reason;

	class Specimen {
		public function __construct() {
			echo "use parametermetric\home\well\joint as reason;<br>\$joint = new reason\Joint();<br><br>";
			$joint = new reason\Joint();

			echo "\$joint->Test();";
			echo "<pre>"; echo $joint->Test(); echo "</pre>";
		}
	}
?>
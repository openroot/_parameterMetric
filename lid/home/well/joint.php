<?php
	namespace lid\home\well\joint;
?>

<?php
?>

<?php
	class Joint {
		public function __construct() {}

		public function Test() {
			return "I know HTML.";
		}
	}
?>

<?php
	use lid\home\well\joint as lidreason;

	class Specimen {
		public function __construct() {
			echo "use lid\home\well\joint as lidreason;<br>\$joint = new lidreason\Joint();<br><br>";
			$joint = new lidreason\Joint();

			echo "\$joint->Test();";
			echo "<pre>"; echo $joint->Test(); echo "</pre>";
		}
	}
?>
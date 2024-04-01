<?php
	namespace lid\home\well\joint;
?>

<?php
	use lid\home\well\heap as heap;
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
	use lid\home\well\joint as reason;

	class Specimen {
		public function __construct() {
			echo "use lid\home\well\joint as reason;<br>\$joint = new reason\Joint();<br><br>";
			$joint = new reason\Joint();

			echo "\$joint->Test();";
			echo "<pre>"; echo $joint->Test(); echo "</pre>";
		}
	}
?>
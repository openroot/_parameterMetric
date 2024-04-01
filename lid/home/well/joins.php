<?php
	namespace lid\home\well\joins;
?>

<?php
	use lid\home\well\heap as heap;
?>

<?php
	class Joins {
		public function __construct() {}

		public function Test() {
			return "I know PHP.";
		}
	}
?>

<?php
	use lid\home\well\joins as season;

	class Specimen {
		public function __construct() {
			echo "use lid\home\well\joins as season;<br>\$joins = new season\Joins();<br><br>";
			$joins = new season\Joins();

			echo "\$joins->Test();";
			echo "<pre>"; echo $joins->Test(); echo "</pre>";
		}
	}
?>
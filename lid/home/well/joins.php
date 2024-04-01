<?php
	namespace lid\home\well\joins;
?>

<?php
	use lid\home\well\heap as lidheap;
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
	use lid\home\well\joins as lidseason;

	class Specimen {
		public function __construct() {
			echo "use lid\home\well\joins as lidseason;<br>\$joins = new lidseason\Joins();<br><br>";
			$joins = new lidseason\Joins();

			echo "\$joins->Test();";
			echo "<pre>"; echo $joins->Test(); echo "</pre>";
		}
	}
?>
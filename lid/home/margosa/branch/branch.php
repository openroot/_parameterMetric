<?php
	namespace lid\home\margosa\branch;
?>

<?php
	$GLOBALS["declaredClasses"] = get_declared_classes();
	$GLOBALS["definedFunctions"] = get_defined_functions();
	$GLOBALS["definedConstants"] = get_defined_constants();
?>

<?php
	class Branch {
		private ?array $arguments;
		private array $declaredClasses;
		private array $definedFunctions;
		private array $definedConstants;

		public function __construct(?array $arguments = null) {
			$this->arguments = $arguments;
			$this->declaredClasses = $GLOBALS["declaredClasses"];
			$this->definedFunctions = $GLOBALS["definedFunctions"];
			$this->definedConstants = $GLOBALS["definedConstants"];
		}

		public function Around() {
			return $this->Here();
		}

		public function Here() {
			$result = array();
			$result["classes"] = $this->declaredClasses;
			$result["functions"] = $this->definedFunctions;
			$result["constants"] = $this->definedConstants;
			return $result;
		}
	}
?>

<?php
	use lid\home\margosa\branch as lidbranch;

	class Specimen {
		public function __construct() {
			$branch = new lidbranch\Branch();

			echo "<h6>1</h6>";
			echo "<pre>";
			print_r($branch->Around());
			echo "</pre>";
		}
	}
?>

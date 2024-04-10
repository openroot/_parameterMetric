<?php
	namespace lid\home\margosa\branch;
?>

<?php
	use lid\home\well\joint as lidjoint;
	$GLOBALS["declaredClasses"] = get_declared_classes();
	$GLOBALS["definedFunctions"] = get_defined_functions();
	$GLOBALS["definedConstants"] = get_defined_constants();
?>

<?php
	class Branch extends lidjoint\Joint  {
		private ?array $arguments;
		private array $declaredClasses;
		private array $definedFunctions;
		private array $definedConstants;

		public function __construct(?array $arguments = null) {
			$this->arguments = $arguments;
			$this->declaredClasses = $GLOBALS["declaredClasses"];
			$this->definedFunctions = $GLOBALS["definedFunctions"];
			$this->definedConstants = $GLOBALS["definedConstants"];
			parent::__construct($this);
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

			echo "<h6>1: Branch - Signature</h6>";
			echo "<pre>";
			print_r($branch->Signature());
			echo "</pre>";

			echo "<h6>2: Branch - Around</h6>";
			echo "<pre>";
			print_r($branch->Around());
			echo "</pre>";
		}
	}
?>

<?php
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	use parametermetric\home\well\heap as heap;
?>

<?php
	class Index {
		private heap\Platform $platform;

		public function __construct() {
			$this->platform = new heap\Platform();
			if ($this->platform) {
				$this->Execute();
			}
		}

		private function Execute() {
			// ------------------------------------------------------------------------------------------------------------
			// Unblock following if() blocks to view demonstration of code-in-action in front-end or defined in respective.

			// A demonstration of: namespace 'parametermetric\home\well\heap'.
			/*if ($this->platform) {
				echo "<h3>new parametermetric\home\well\heap\Specimen();</h3>";
				new parametermetric\home\well\heap\Specimen();
			}*/

			// A demonstration of: namespace 'parametermetric\home\well\joint'.
			if ($this->platform->RequireonceFile("home/well", "joint.php")) {
				echo "<h3>new parametermetric\home\well\joint\Specimen();</h3>";
				new parametermetric\home\well\joint\Specimen();
			}

			// A demonstration of: namespace 'parametermetric\home\well\joins'.
			if ($this->platform->RequireonceFile("home/well", "joins.php")) {
				echo "<h3>new parametermetric\home\well\joins\Specimen();</h3>";
				new parametermetric\home\well\joins\Specimen();
			}

			// A demonstration of: code convention used in this project in generic format.
			/*if ($this->platform->RequireonceDirectory("home/margosa/now")) {
				echo "<h3>new parametermetric\home\margosa\now\\flower\Specimen();</h3>";
				new parametermetric\home\margosa\now\flower\Specimen();
			}*/
			// ------------------------------------------------------------------------------------------------------------
		}
	}
?>

<?php
	new Index();
	// ------------------------------------------------------------------------------------------------------------
	// The task needs to be done, is jot down here for now.
	
	// TODO: 1. Add section-counter feature.
	// TODO: 2. Add 'task-section'. Till then, jot down here.
	// TODO: 3. Add 'analyze-section' for code of the project analysis.
	// ------------------------------------------------------------------------------------------------------------
?>
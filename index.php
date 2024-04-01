<?php
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	use parametermetric\home\well\heap as heap;
?>

<?php
	class Launch {
		private heap\Platform $platform;

		public function __construct(?string $blockName = null) {
			$this->platform = new heap\Platform();

			if ($blockName != null) {
				$this->Execute($blockName);
			}
		}

		public function Execute(string $blockName) {
			if ($this->platform) {
				// Following cases to view to demonstrate of code-in-action in front-end as defined in respective.
				switch ($blockName) {
					case "heap":
						// A demonstration of: namespace 'parametermetric\home\well\heap'.
						if ($this->platform) {
							echo "<h3>new parametermetric\home\well\heap\Specimen();</h3>";
							new parametermetric\home\well\heap\Specimen();
						}
						break;
					case "joint":
						// A demonstration of: namespace 'parametermetric\home\well\joint'.
						if ($this->platform->RequireonceFile("home/well", "joint.php")) {
							echo "<h3>new parametermetric\home\well\joint\Specimen();</h3>";
							new parametermetric\home\well\joint\Specimen();
						}
						break;
					case "joins":
						// A demonstration of: namespace 'parametermetric\home\well\joins'.
						if ($this->platform->RequireonceFile("home/well", "joins.php")) {
							echo "<h3>new parametermetric\home\well\joins\Specimen();</h3>";
							new parametermetric\home\well\joins\Specimen();
						}
						break;
					case "margosa":
						// A demonstration of: code convention used in this project in generic format.
						if ($this->platform->RequireonceDirectory("home/margosa/now")) {
							echo "<h3>new parametermetric\home\margosa\\now\\flower\Specimen();</h3>";
							new parametermetric\home\margosa\now\flower\Specimen();
						}
						break;
					default:
						echo "This is default case.";
				}
			}
		}
	}
?>

<?php
	$launch = new Launch("margosa");
	//$launch->Execute("joint");
	//$launch->Execute("joins");
	//$launch->Execute("heap");
?>

<?php
	// ------------------------------------------------------------------------------------------------------------
	// The task needs to be done, is jot down here for now.
	
	// TODO: 1. Add section-counter feature.
	// TODO: 2. Add 'task-section'. Till then, jot down here.
	// TODO: 3. Add 'analyze-section' for code of the project analysis.
	// ------------------------------------------------------------------------------------------------------------
?>
<?php
	require_once("lid/home/well/heap.php");
?>

<?php
	use lid\home\well\heap as heap;
?>

<?php
	class Launch {
		private heap\Platform $platform;

		public function __construct(?string $blockName = null) {
			$this->platform = new heap\Platform();

			if ($blockName != null) {
				$this->Skeleton($blockName);
			}
		}

		public function Skeleton(string $blockName) {
			if ($this->platform) {
				// Following cases to view to demonstrate of code-in-action in front-end as defined in respective.
				switch ($blockName) {
					case "heap":
						// A demonstration of: namespace 'lid\home\well\heap'.
						if ($this->platform) {
							echo "<h3>new lid\home\well\heap\Specimen();</h3>";
							new lid\home\well\heap\Specimen();
						}
						break;
					case "joins":
						// A demonstration of: namespace 'lid\home\well\joins'.
						if ($this->platform->RequireonceFile("home/well", "joins.php")) {
							echo "<h3>new lid\home\well\joins\Specimen();</h3>";
							new lid\home\well\joins\Specimen();
						}
						break;
					case "joint":
						// A demonstration of: namespace 'lid\home\well\joint'.
						if ($this->platform->RequireonceFile("home/well", "joint.php")) {
							echo "<h3>new lid\home\well\joint\Specimen();</h3>";
							new lid\home\well\joint\Specimen();
						}
						break;
					case "margosa":
						// A demonstration of: code convention used in this project in generic format.
						if ($this->platform->RequireonceDirectory("home/margosa/now")) {
							echo "<h3>new lid\home\margosa\\now\\flower\Specimen();</h3>";
							new lid\home\margosa\now\flower\Specimen();
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
	$launch = new Launch();
	$launch->Skeleton("margosa");
	$launch->Skeleton("heap");
	$launch->Skeleton("joins");
	$launch->Skeleton("joint");
?>

<?php
	// ------------------------------------------------------------------------------------------------------------
	// The task needs to be done, is jot down here for now.
	
	// TODO: 1. Add section-counter feature.
	// TODO: 2. Add 'task-section'. Till then, jot down here.
	// TODO: 3. Add 'analyze-section' for code of the project analysis.
	// ------------------------------------------------------------------------------------------------------------
?>
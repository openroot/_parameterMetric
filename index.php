<?php
	require_once("lid/home/well/heap.php");
?>

<?php
	use lid\home\well\heap as lidheap;
?>

<?php
	class Launch {
		private lidheap\Platform $platform;

		public function __construct(?string $blockName = null) {
			$this->platform = new lidheap\Platform();

			if ($blockName != null) {
				$this->Skeleton($blockName);
			}
		}

		public function Skeleton(string $blockName) {
			if ($this->platform) {
				// Following cases to view to demonstrate of code-in-action in front-end as defined in respective.
				switch ($blockName) {
					case "margosanow":
						// A demonstration of code convention used in this project in generic format.
						if ($this->platform->RequireonceDirectory("home/margosa/now")) {
							echo "<h5>Namespace: lid\home\margosa\\now\\flower</h5>";
							new lid\home\margosa\now\flower\Specimen();
						}
						break;
					case "heap":
						// A demonstration of Namespace: 'lid\home\well\heap'.
						echo "<h5>Namespace: lid\home\well\heap</h5>";
						new lid\home\well\heap\Specimen();
						break;
					case "joins":
						// A demonstration of Namespace: 'lid\home\well\joins'.
						echo "<h5>Namespace: lid\home\well\joins</h5>";
						new lid\home\well\joins\Specimen();
						break;
					case "joint":
						// A demonstration of Namespace: 'lid\home\well\joint'.
						echo "<h5>Namespace: lid\home\well\joint</h5>";
						new lid\home\well\joint\Specimen();
						break;
					case "pull":
						// A demonstration of Namespace: 'lid\home\well\pull'.
						echo "<h5>Namespace: lid\home\well\pull</h5>";
						new lid\home\well\pull\Specimen();
						break;
					case "water":
						// A demonstration of Namespace: 'lid\home\well\water'.
						echo "<h5>Namespace: lid\home\well\water</h5>";
						new lid\home\well\water\Specimen();
						break;
					default:
						echo "This is default case of Class 'Launch'.";
				}
			}
		}
	}
?>

<?php
	$launch = new Launch();
	$launch->Skeleton("margosanow");
	$launch->Skeleton("heap");
	$launch->Skeleton("joins");
	$launch->Skeleton("joint");
	$launch->Skeleton("pull");
	$launch->Skeleton("water");
?>

<?php
	// ------------------------------------------------------------------------------------------------------------
	// The task needs to be done, is jot down here for now.
	
	// TODO: 1. Add section-counter feature.
	// TODO: 2. Add 'task-section'. Till then, jot down here.
	// TODO: 3. Add 'analyze-section' for code of the project analysis.
	// ------------------------------------------------------------------------------------------------------------
?>

<?php
	// ------------------------------------------------------------------------------------------------------------
	// Extra testing, is jot down here for now.
	
	// ------------------------------------------------------------------------------------------------------------
?>
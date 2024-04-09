<?php
	require_once("lid/home/well/heap.php");
?>

<?php
	use lid\home\well\heap as lidheap;
	use lid\home\well\joint as lidjoint;
?>

<?php
	class Launch {
		private lidheap\Platform $platform;
		private lidheap\Street $street;

		public function __construct(?string $blockName = null) {
			$this->platform = new lidheap\Platform();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($this->platform)) {
				$this->street = $this->platform->ReadStreet();
				$launchSkeleton = $this->street->FindGets("index_launch_skeleton");
				$blockName = !empty($launchSkeleton) ? $launchSkeleton : $blockName;
				if ($blockName != null) {
					$this->Skeleton($blockName);
				}
				echo "<pre><br><br><br><br><hr><i><b>Project generated:<br><br></b>[baseId] => namespace\Class<b><br>and, off exact order.<br><br>(for, otg development purpose)</b></i><hr><i>";
				print_r(lidjoint\Base::$objectBaseIds);
				echo "</i><hr><hr><br></pre>";
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
					case "margosabranch":
						// A demonstration of code convention used in this project in generic format.
						if ($this->platform->RequireonceFile("home/margosa/branch", "branch.php")) {
							echo "<h5>Namespace: lid\home\margosa\branch</h5>";
							new lid\home\margosa\branch\Specimen();
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
					case "push":
						// A demonstration of Namespace: 'lid\home\well\push'.
						echo "<h5>Namespace: lid\home\well\push</h5>";
						new lid\home\well\push\Specimen();
						break;
					case "water":
						// A demonstration of Namespace: 'lid\home\well\water'.
						echo "<h5>Namespace: lid\home\well\water</h5>";
						new lid\home\well\water\Specimen();
						break;
					case "viewcodes":
					case "viewcodesprimary":
						// Look into all code (non-binary) files (files in primary directories).
						$this->Viewcodes();
						break;
					case "viewcodesall":
						// Look into all code (non-binary) files (files in all directories).
						$this->Viewcodes(false);
						break;
					default:
						echo "This is default case of Class 'Launch'.";
				}
			}
		}

		private function Viewcodes(bool $onlyPrimaryDirectory = true) {
			$compute = new lidheap\Compute();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($compute)) {
				echo "<pre>";
				$filesLines = $compute->LensTextSlip($onlyPrimaryDirectory);
				$i = 0;
				$totalLinesOfCodes = 0;
				foreach ($filesLines as $index1 => $value1) {
					echo "<hr><b>[F " . ++$i . "] {$index1}</b><hr><i>";
					foreach ($value1 as $index2 => $value2) {
						echo "L " . ($index2 + 1) . "> ". htmlspecialchars($value2) . "";
					}
					echo "</i><br>";
					$totalLinesOfCodes += count($value1);
				}
				echo "</pre>";
				echo "<hr><hr><b>Total Lines of Codes:</b><i> {$totalLinesOfCodes}</i><hr><hr>";
			}
		}
	}
?>

<?php
	$launch = new Launch();
	//$launch->Skeleton("margosanow");
	//$launch->Skeleton("margosabranch");
	//$launch->Skeleton("heap");
	//$launch->Skeleton("joins");
	//$launch->Skeleton("joint");
	//$launch->Skeleton("pull");
	//$launch->Skeleton("push");
	//$launch->Skeleton("water");
	//$launch->Skeleton("viewcodes");
?>

<?php
	// ------------------------------------------------------------------------------------------------------------
	// The task needs to be done, is jot down here for now.
	
	// TODO: 1. Add section-counter feature.
	// TODO: 2. Add 'task-section'. Till then, jot down here.
	// TODO: 3. Add 'analyze-section' for code of the project analysis.
	// TODO: 4. Make a 'file-mod' registration system. Incorporate it with push mechanism of project updates.
	// ------------------------------------------------------------------------------------------------------------
?>

<?php
	// ------------------------------------------------------------------------------------------------------------
	// Extra testing, is jot down here for now.

	// ------------------------------------------------------------------------------------------------------------
?>
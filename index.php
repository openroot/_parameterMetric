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
		private array $blockNames;

		public function __construct(?string $blockName = null) {
			$this->platform = new lidheap\Platform();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($this->platform)) {
				$this->street = $this->platform->ReadStreet();
				$this->blockNames = array(
					"deafult" => "Home",
					"margosanowflower" => "Home->Margosa->Now->Flower",
					"margosanowleaf" => "Home->Margosa->Now->Leaf",
					"margosabranch" => "Home->Margosa->Branch",
					"heap" => "Home->Well->Heap",
					"joins" => "Home->Well->Joins",
					"joint" => "Home->Well->Joint",
					"pull" => "Home->Well->Pull",
					"push" => "Home->Well->Push",
					"water" => "Home->Well->Water",
					"viewtextfilesprimary" => "Home->Well->Heap|Compute->LensTextSlip:Primary",
					"viewtextfilesall" => "Home->Well->Heap|Compute->LensTextSlip:All",
					"viewphpcodeclassesprimary" => "Home->Well->Heap|Compute->LensPhpCodeClasses:Primary",
					"viewphpcodeclassesall" => "Home->Well->Heap|Compute->LensPhpCodeClasses:All"
				);
				$this->AttachHeader();
				$this->AttachBody($blockName);
				$this->AttachFooter();
			}
			else {
				die("Execution interrupted. Possibly it gets fixed on page refresh.");
			}
		}

		public function Skeleton(string $blockName) {
			if ($this->platform) {
				// Following cases to view to demonstrate of code-in-action in front-end as defined in respective.
				switch ($blockName) {
					case "margosanowflower":
						// A demonstration of code convention used in this project in generic format.
						if ($this->platform->RequireonceDirectory("home/margosa/now")) {
							echo "<h5>Namespace: lid\home\margosa\\now\\flower</h5>";
							new lid\home\margosa\now\flower\Specimen();
						}
						break;
					case "margosanowleaf":
						// A demonstration of code convention used in this project in generic format.
						if ($this->platform->RequireonceDirectory("home/margosa/now")) {
							echo "<h5>Namespace: lid\home\margosa\\now\leaf</h5>";
							new lid\home\margosa\now\leaf\Specimen();
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
					case "viewtextfilesprimary":
						// Look into all text (non-binary) files (files in primary directories).
						$this->ViewTextFiles();
						break;
					case "viewtextfilesall":
						// Look into all text (non-binary) files (files in all directories).
						$this->ViewTextFiles(false);
						break;
					case "viewphpcodeclassesprimary":
						// Look into PHP code classes (files in primary directories).
						$this->ViewPhpCodeClasses();
						break;
					case "viewphpcodeclassesall":
						// Look into PHP code classes (files in all directories).
						$this->ViewPhpCodeClasses(false);
						break;
					default:
						echo "This is default case of Class 'Launch'.";
				}
			}
		}

		private function AttachHeader() {
			echo "<hr><hr><pre>";
			echo "<i><b>Menu</b></i><br><br>";
			foreach ($this->blockNames as $index => $value) {
				echo "<i>";
				if (str_ends_with($_SERVER['REQUEST_URI'], $index)) {
					echo "{$value}<br>";
				}
				else {
					echo "<a href=\"?index_launch_skeleton={$index}\">{$value}</a><br>";
				}
				echo "</i>";
			}
			echo "</pre><hr><hr><br><br>";
		}

		private function AttachFooter() {
			echo "<pre><br><br><hr><hr><i><b>Project generated:<br><br></b>[baseId] => namespace\Class<b><br>and, off exact order.<br><br>(for, otg development purpose)</b></i><hr><i>";
			print_r(lidjoint\Base::$objectBaseIds);
			echo "</i><hr><hr><br></pre>";
		}

		private function AttachBody(?string $blockName = null) {
			$launchSkeleton = $this->street->FindGets("index_launch_skeleton");
			$blockName = !empty($launchSkeleton) ? $launchSkeleton : $blockName;
			if ($blockName != null) {
				$this->Skeleton($blockName);
			}
		}

		private function ViewTextFiles(bool $onlyPrimaryDirectory = true) {
			$compute = new lidheap\Compute();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($compute)) {
				$filesLines = $compute->LensTextSlip($onlyPrimaryDirectory);
				$i = 0;
				$totalLinesOfTexts = 0;
				echo "<pre>";
				foreach ($filesLines as $index1 => $value1) {
					echo "<hr><b>[F " . ++$i . "] {$index1}</b><hr><i>";
					foreach ($value1 as $index2 => $value2) {
						echo "L " . ($index2 + 1) . "> ". htmlspecialchars($value2) . "";
					}
					echo "</i><br>";
					$totalLinesOfTexts += count($value1);
				}
				echo "</pre>";
				echo "<hr><hr>" . ($onlyPrimaryDirectory ? "[Primary Directories] " : "[All Directories] ") . "<b>Total Lines of Texts:</b><i> {$totalLinesOfTexts}</i><hr><hr>";
			}
		}

		private function ViewPhpCodeClasses(bool $onlyPrimaryDirectory = true) {
			$compute = new lidheap\Compute();
			if (lidjoint\Joint::SearchMaterialAsAuthentic($compute)) {
				$phpClasses = $compute->LensPhpCodeClasses($onlyPrimaryDirectory);
				$i = 0;
				$totalNumbersOfPhpClasses = 0;
				echo "<pre>";
				foreach ($phpClasses as $index1 => $value1) {
					echo "<hr><b>[F " . ++$i . "] {$index1}</b><hr><i>";
					foreach ($value1 as $index2 => $value2) {
						echo "C " . ($index2 + 1) . "> ". htmlspecialchars($value2) . PHP_EOL;
					}
					echo "</i><br>";
					$totalNumbersOfPhpClasses += count($value1);
				}
				echo "</pre>";
				echo "<hr><hr>" . ($onlyPrimaryDirectory ? "[Primary Directories] " : "[All Directories] ") . "<b>Total Numbers of PHP Classes:</b><i> {$totalNumbersOfPhpClasses}</i><hr><hr>";
			}
		}
	}
?>

<?php
	$launch = new Launch();
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
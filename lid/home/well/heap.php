<?php
	namespace lid\home\well\heap;
	require_once("joint.php");
?>

<?php
	use lid\home\well\joint as lidjoint;
	use lid\home\well\pull as lidpull;
	use lid\home\well\push as lidpush;
	use lid\home\well\water as lidwater;
?>

<?php
	/* recognize */
	class Platform extends lidjoint\Joint {
		protected lidpull\Pull $pull;
		protected lidpush\Push $push;
		protected Directory $directory;
		protected File $file;
		protected Street $street;
		protected Lamp $lamp;
		protected Wide $wide;
		protected Notice $notice;
		protected Run $run;
		protected Dive $dive;

		public function __construct() {
			$success = false;
			$this->directory = new Directory();
			$this->file = new File();
			if (lidjoint\Joint::SeeAuthentic($this->directory) && lidjoint\Joint::SeeAuthentic($this->file) && $this->RequireonceDirectory("home/well")) {
				$this->pull = new lidpull\Pull();
				if ($this->pull) {
					$this->push = new lidpush\Push();
					if ($this->push) {
						$this->street = $this->push->ReadStreet();
						$this->lamp = new Lamp();
						$this->wide = new Wide();
						$this->notice = new Notice();
						$this->run = new Run();
						$this->dive = new Dive();
						if (lidjoint\Joint::SeeAuthentic($this->street) && lidjoint\Joint::SeeAuthentic($this->lamp) && lidjoint\Joint::SeeAuthentic($this->wide) && lidjoint\Joint::SeeAuthentic($this->notice) && lidjoint\Joint::SeeAuthentic($this->run) && lidjoint\Joint::SeeAuthentic($this->dive)) {
							$success = true;
						}
					}
				}
			}
			if (!$success) {
				$this->baseId = -1;
				die("Execution interrupted. Possibly it gets fixed on refresh.");
			}
			parent::__construct($this);
		}

		public function ReadStreet() {
			return $this->street;
		}

		public function ReadLamp() {
			return $this->lamp;
		}

		public function ReadWide() {
			return $this->wide;
		}

		public function ReadNotice() {
			return $this->notice;
		}

		public function ReadRun() {
			return $this->run;
		}

		public function ReadDive() {
			return $this->dive;
		}

		public function RequireonceDirectory(string $directoryPath) {
			$filteredFileFullPaths = array();
			$fileFullPaths = $this->file->EnlistFilelist($directoryPath);
			if (count($fileFullPaths) == 0) {
				return true;
			}
			foreach ($fileFullPaths as $index => $value) {
				$fileFullPath = $this->directory->ReadTopDirectory() . "/{$directoryPath}/{$value}";
				if (!$this->SearchScriptAsCurrentscript($fileFullPath)) {
					array_push($filteredFileFullPaths, $fileFullPath);
				}
			}
			$successCount = 0;
			$filteredFileFullPathsCount = count($filteredFileFullPaths);
			if ($filteredFileFullPathsCount > 0) {
				foreach ($filteredFileFullPaths as $index => $value) {
					if(require_once($value)) {
						$successCount++;
					}
				}
			}
			else {
				$filteredFileFullPathsCount = -1;
			}
			return $filteredFileFullPathsCount == $successCount ? true : false;
		}

		public function RequireonceDirectories(array $directoryPaths) {
			$result = true;
			if (count($directoryPaths) > 0) {
				foreach($directoryPaths as $index => $value) {
					if (!$this->RequireonceDirectory($value)) {
						$result = false;
						break;
					}
				}
			}
			else {
				$result = false;
			}
			return $result;
		}

		public function RequireonceFile(string $directoryPath, string $fileName) {
			$fullFilePath = $this->directory->ReadTopDirectory() . "/{$directoryPath}/{$fileName}";
			if (!$this->SearchScriptAsCurrentscript($fullFilePath)) {
				if (is_file($fullFilePath)) {
					return require_once($fullFilePath);
				}
			}
			return false;
		}

		public function SearchScriptAsCurrentscript(string $fileName) {
			$presentScriptFile = str_replace("\\", "/", __FILE__);
			$fileName = $fileName[0] == "." ? substr($fileName, 1) : $fileName;
			return str_contains($presentScriptFile, $fileName) ? true : false;
		}
	}

	/* eat */
	class Directory extends lidjoint\Joint {
		protected string $topDirectory;
		protected array $recentDirectorylist;
		private string $defaultTopDirectory;
		private string $recyclebinDirectory;

		public function __construct(?string $topDirectory = null) {
			$this->recentDirectorylist = array();
			$this->defaultTopDirectory = "./lid";
			$this->recyclebinDirectory = "home/margosa/spin/algebrafate/recyclebin";
			$this->topDirectory = empty($topDirectory) ? $this->defaultTopDirectory : $topDirectory;
			parent::__construct($this);
		}

		public function ReadTopDirectory() {
			return $this->topDirectory;
		}

		public function ReadRecentDirectorylist() {
			return $this->recentDirectorylist;
		}

		public function FineDirectoryPath(string $directoryPath) {
			// TODO: [NOT MISSION CRITICAL]
			// TODO: Process only after verifying if passed value do not already contain topDirectory at start.
			// TODO: Further rectify any false slashes.
			return $directoryPath != "" ? "{$this->topDirectory}/{$directoryPath}" : $this->topDirectory;
		}

		public function UnfineDirectoryPath(string $fineDirectoryPath) {
			// TODO: [NOT MISSION CRITICAL]
			// TODO: Process only after verifying if passed value do contain topDirectory at start.
			// TODO: Further rectify any false slashes.
			return strpos($fineDirectoryPath, $this->topDirectory) == 0 ? substr($fineDirectoryPath, strlen($this->topDirectory) + 1) : false;
		}

		public function ContainsDirectoryName(array $directoryPaths, string $directoryName) {
			$result = false;
			foreach ($directoryPaths as $index => $value) {
				if (strcmp(substr($value, strrpos($value, "/") + 1), $directoryName) == 0) {
					if (is_dir($this->FineDirectoryPath($value))) {
						$result = true;
					}
				}
			}
			return $result;
		}

		public function RefreshRecentDirectorylistIndepth(?string $directoryPath = null) {
			array_splice($this->recentDirectorylist, 0, count($this->recentDirectorylist));
			$this->EnlistRecentDirectorylistIndepth(empty($directoryPath) ? "" : $directoryPath);
			return $this->recentDirectorylist;
		}

		public function MakeDirectory(string $directoryPath) {
			$fineDirectoryPath = $this->FineDirectoryPath($directoryPath);
			if (!file_exists($fineDirectoryPath)) {
				return mkdir($fineDirectoryPath);
			}
			return false;
		}

		public function DeleteDirectory(string $directoryPath) {
			$result = false;
			$fineDirectoryPath = $this->FineDirectoryPath($directoryPath);
			if (is_dir($fineDirectoryPath)) {
				$parentDirectoryPath = substr($fineDirectoryPath, 0, strrpos($fineDirectoryPath, "/"));
				$directoryName = substr($fineDirectoryPath, strrpos($fineDirectoryPath, "/") + 1);
				if ($this->ContainsDirectoryName($this->RefreshRecentDirectorylistIndepth($this->UnfineDirectoryPath($parentDirectoryPath)), $directoryName)) {
					$this->MakeDirectory($this->recyclebinDirectory);
					if (is_dir($this->FineDirectoryPath($this->recyclebinDirectory))) {
						return rename($fineDirectoryPath, "{$this->topDirectory}/{$this->recyclebinDirectory}/{$directoryName}" . $this->CurrentTimePlatformSafe());
					}
				}
			}
			return $result;
		}

		public function CopyDirectoryLeaveIndepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopyDirectory($directoryPath, $locationPath, "leaveindepth");
		}

		public function CopyDirectoryMergeIndepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopyDirectory($directoryPath, $locationPath, "mergeindepth");
		}

		public function CopyDirectoryLeaveOutdepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopyDirectory($directoryPath, $locationPath, "leaveoutdepth");
		}

		public function CopyDirectoryMergeOutdepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopyDirectory($directoryPath, $locationPath, "mergeoutdepth");
		}

		private function EnlistRecentDirectorylistIndepth(string $directoryPath) {
			foreach ($this->EnlistDirectorylistOutdepth($this->FineDirectoryPath($directoryPath)) as $index => $value) {
				$foundDirectoryPath = "{$directoryPath}/{$value}";
				$foundDirectoryPath = strpos($foundDirectoryPath, "/") == 0 ? substr($foundDirectoryPath, 1) : $foundDirectoryPath;
				array_push($this->recentDirectorylist, $foundDirectoryPath);
				$this->EnlistRecentDirectorylistIndepth($foundDirectoryPath);
			}
		}

		private function EnlistDirectorylistOutdepth(string $directoryPath) {
			$filteredList = array();
			if (is_dir($directoryPath)) {
				foreach (scandir($directoryPath) as $index => $value) {
					if (!($value == "." || $value == "..") && is_dir("{$directoryPath}/{$value}")) {
						array_push($filteredList, $value);
					}
				}
			}
			return $filteredList;
		}

		private function EnlistDirectoriesAndFilesOutdepth(string $fineDirectoryPath) {
			$directoriesandfiles = array();
			if (!($fineDirectoryPath == "." || $fineDirectoryPath == "..") && is_dir($fineDirectoryPath)) {
				foreach(scandir($fineDirectoryPath) as $index => $value) {
					if (!($value == "." || $value == "..")) {
						array_push($directoriesandfiles, $value);
					}
				}
			}
			return $directoriesandfiles;
		}

		private function YieldCopyDirectory(string $directoryPath, string $locationPath, string $copyType) {
			$result = false;
			$fineDirectoryPath = $this->FineDirectoryPath($directoryPath);
			if (is_dir($fineDirectoryPath)) {
				$this->MakeDirectory($locationPath);
				$fineLocationPath = $this->FineDirectoryPath($locationPath);
				if (is_dir($fineLocationPath)) {
					$result = $this->CopyDirectoryIndepth($fineDirectoryPath, $fineLocationPath, $copyType);
				}
			}
			return $result;
		}

		private function CopyDirectoryIndepth(string $fineDirectoryPath, string $fineLocationPath, string $copyType) {
			$result = true;
			$directoriesandfiles = $this->EnlistDirectoriesAndFilesOutdepth($fineDirectoryPath);
			if (count($directoriesandfiles) == 0) {
				return;
			}
			else {
				foreach ($directoriesandfiles as $index => $value) {
					$copySource = "{$fineDirectoryPath}/{$value}";
					$copyTo = "{$fineLocationPath}/{$value}";
					switch ($copyType) {
						case "leaveindepth":
							if (!file_exists($copyTo)) {
								if (is_dir($copySource)) {
									$result = mkdir($copyTo);
								}
								else if (is_file($copySource)) {
									$result = copy($copySource, $copyTo);
								}
							}
							$result = $this->CopyDirectoryIndepth("{$fineDirectoryPath}/{$value}", "{$fineLocationPath}/{$value}", $copyType);
							break;
						case "mergeindepth":
							if (is_file($copySource)) {
								$result = copy($copySource, $copyTo);
							}
							else if (is_dir($copySource) && !file_exists($copyTo)) {
								$result = mkdir($copyTo);
							}
							$result = $this->CopyDirectoryIndepth("{$fineDirectoryPath}/{$value}", "{$fineLocationPath}/{$value}", $copyType);
							break;
						case "leaveoutdepth":
							if (!file_exists($copyTo)) {
								if (is_dir($copySource)) {
									$result = mkdir($copyTo);
								}
								else if (is_file($copySource)) {
									$result = copy($copySource, $copyTo);
								}
							}
							break;
						case "mergeoutdepth":
							if (is_file($copySource)) {
								$result = copy($copySource, $copyTo);
							}
							else if (is_dir($copySource) && !file_exists($copyTo)) {
								$result = mkdir($copyTo);
							}
							break;
					}
				}
			}
			return $result;
		}

		private function CurrentTimePlatformSafe(?string $timeZone = "UTC") {
			$currentTime = new \DateTime("now", new \DateTimeZone($timeZone));
			if ($currentTime != null) {
				$timeZone = substr($currentTime->format("O"), 1);
				return $currentTime->format("__H_i_s_u__d_m_Y__D__{$timeZone}");
			}
			return false;
		}
	}

	/* vehicle */
	class File extends lidjoint\Joint {
		private Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
			if (!lidjoint\Joint::SeeAuthentic($this->directory)) {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}

		public function SearchFilepathAsFilename(string $filePath, string $fileName) {
			if (strcmp(substr($filePath, strrpos($filePath, "/") + 1), $fileName) == 0) {
				return true;
			}
			return false;
		}

		public function ContainsFileName(array $filePaths, string $fileName) {
			$result = false;
			foreach ($filePaths as $index => $value) {
				if ($this->SearchFilepathAsFilename($value, $fileName)) {
					if (is_file($this->directory->FineDirectoryPath($value))) {
						$result = true;
					}
				}
			}
			return $result;
		}

		public function EnlistFilelist(string $directoryPath) {
			$fileList = array();
			$fineDirectoryPath = $this->directory->FineDirectoryPath($directoryPath);
			if (is_dir($fineDirectoryPath)) {
				foreach (scandir($fineDirectoryPath) as $index => $value) {
					if (!($value == "." || $value == "..") && is_file("{$fineDirectoryPath}/{$value}")) {
						array_push($fileList, $value);
					}
				}
			}
			return $fileList;
		}
	}

	/* name */
	class Street extends lidjoint\Joint {
		protected array $gets;

		public function __construct() {
			$this->gets = array();
			parent::__construct($this);
		}

		public function ReadGets() {
			return $this->gets;
		}

		public function SetGets(string $key) {
			if (!array_key_exists($key, $this->gets)) {
				$this->gets[$key] = null;
				return $this->RollGets($key);
			}
			return false;
		}

		public function FindGets(string $key) {
			if (array_key_exists($key, $this->gets)) {
				return $this->gets[$key];
			}
			return false;
		}

		protected function RollGets(?string $key = null) {
			if ($key != null) {
				if (array_key_exists($key, $_GET)) {
					$this->gets[$key] = $_GET[$key];
					return true;
				}
			}
			else {
				$successCount = 0;
				foreach ($_GET as $key => $value) {
					if (array_key_exists($key, $this->gets)) {
						$this->gets[$key] = $value;
						$successCount++;
					}
				}
				if ($successCount <= count($_GET)) {
					return true;
				}
			}
			return false;
		}
	}

	/* rent */
	class Lamp extends lidjoint\Joint {
		protected lidwater\Sand $sand;
		protected ?\PDO $pdoAc;
		protected string $pdoType;

		public function __construct(string $pdoType = "mysql") {
			$this->sand = new lidwater\Sand();
			$this->pdoAc = null;
			$this->pdoType = $pdoType;
			if (lidjoint\Joint::SeeAuthentic($this->sand)) {
				$this->constructPdoAc();
			}
			else {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}

		public function ReadPdoAc() {
			return $this->pdoAc;
		}

		public function ReadPdoType() {
			return $this->pdoType;
		}

		public function constructPdoAc() {
			if ($this->pdoAc == null) {
				try {
					switch ($this->pdoType) {
						case "mysql":
							$this->pdoAc = new \PDO("mysql:host=" . $this->sand->ReadPdoAc()["servername"], $this->sand->ReadPdoAc()["username"], $this->sand->ReadPdoAc()["password"]);
							break;
						default:
					}
					$this->pdoAc->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
					return true;
				}
				catch (\PDOException $exception) {}
			}
			return false;
		}

		public function destroyPdoAc() {
			$this->pdoAc = null;
		}

		public function TestPdoAc() {
			$sql = "CREATE DATABASE myDBPDO";
			try {
				if ($this->pdoAc != null) {
					$this->pdoAc->exec($sql);
					echo "Database created successfully<br>";
				}
			}
			catch (\PDOException $exception) {
				 echo $sql . "<br>" . $exception->getMessage();
			}
		}
	}

	/* likes */
	class Wide extends lidjoint\Joint {
		public function __construct() {
			// TODO: Console | Log : Try-Catch handler
			parent::__construct($this);
		}
	}

	/* hate */
	class Notice extends lidjoint\Joint {
		public function __construct() {
			// TODO: Date | Time | Callback
			parent::__construct($this);
		}
	}

	/* appeal */
	class Run extends lidjoint\Joint {
		public function __construct() {
			// TODO: AJAX Live : Multi Page
			parent::__construct($this);
		}
	}

	/* relate */
	class Dive extends lidjoint\Joint {
		public function __construct() {
			// TODO: Unlimited Energy Exchange : Source Diagram -> Time
			parent::__construct($this);
		}
	}

	/* reason */
	class Compute extends lidjoint\Joint {
		private lidwater\Brick $brick;
		private Platform $platform;
		private Directory $directory;
		private File $file;

		public function __construct() {
			// TODO: API : Service
			$this->brick = new lidwater\Brick();
			$this->platform = new Platform();
			$this->directory = new Directory();
			$this->file = new File();
			if (!(lidjoint\Joint::SeeAuthentic($this->brick) && lidjoint\Joint::SeeAuthentic($this->platform) && lidjoint\Joint::SeeAuthentic($this->directory) && lidjoint\Joint::SeeAuthentic($this->file))) {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}

		public function LensDirectories(bool $onlyPrimaryDirectory = true) {
			$result = array();

			$result1 = array();
			$result2 = array();
			$brickFlats = $this->brick->ReadFlats();
			$directoryPaths = $this->directory->RefreshRecentDirectorylistIndepth();
			if ($onlyPrimaryDirectory) {
				foreach ($brickFlats as $index => $value) {
					if ($this->SearchArrayAsStringOutdepth($directoryPaths, $value)) {
						array_push($result1, $value);
					}
					else {
						array_push($result2, $value);
					}
				}
			}
			else {
				foreach ($directoryPaths as $index => $value) {
					if ($this->SearchArrayAsStringOutdepth($brickFlats, $value)) {
						array_push($result1, $value);
					}
					else {
						array_push($result2, $value);
					}
				}
			}
			array_push($result, $result1);
			array_push($result, $result2);

			return $result;
		}

		public function LensFiles(bool $onlyPrimaryDirectory = true) {
			$result = array();
			foreach (array_merge($this->LensDirectories($onlyPrimaryDirectory)[0], $this->LensDirectories($onlyPrimaryDirectory)[1]) as $index => $value) {
				$fileNames = $this->file->EnlistFilelist($value);
				if (count($fileNames) > 0) {
					$result[$value] = $fileNames;
				}
			}
			return $result;
		}

		public function LensTextSlip(bool $onlyPrimaryDirectory = true, ?string $slipType = null) {
			$result = array();
			$slipType = empty($slipType) ? "text" : $slipType;
			foreach ($this->LensFiles($onlyPrimaryDirectory) as $index1 => $value1) {
				foreach ($value1 as $index2 => $value2) {
					$slipPath = "{$index1}/{$value2}";
					$textSlip = null;
					switch ($slipType) {
						case "text":
							$textSlip = new lidjoint\TextSlip($slipPath);
							break;
						case "codetextslip":
							$textSlip = new lidjoint\CodeTextSlip($slipPath);
							break;
						case "phpcodetextslip":
							$textSlip = new lidjoint\PhpCodeTextSlip($slipPath);
							break;
						case "jsoncodetextslip":
							$textSlip = new lidjoint\JsonCodeTextSlip($slipPath);
							break;
						default:
							$textSlip = new lidjoint\TextSlip($slipPath);
					}
					if (lidjoint\Joint::SeeAuthentic($textSlip)) {
						$result[$slipPath] = $textSlip->ReadSlip();
					}
				}
			}
			return $result;
		}

		public function LensPhpCodeClasses(bool $onlyPrimaryDirectory = true) {
			$result = array();
			$slipLines = $this->LensTextSlip($onlyPrimaryDirectory, "phpcodetextslip");
			foreach ($slipLines as $index1 => $value1) {
				$classNames = array();
				$namespacePath = "";
				foreach ($value1 as $index2 => $value2) {
					$value2 = trim($value2);
					if (str_starts_with($value2, "namespace") && str_ends_with($value2, ";")) {
						$temp = ltrim($value2, "namespace ");
						$namespacePath = rtrim($temp, ";");
					}
					else if (str_starts_with($value2, "class")) {
						$temp = ltrim($value2, "class ");
						$className = explode(" ", $temp, 2)[0];
						array_push($classNames, $className);
					}
				}
				$classNamesWithNamespace = array();
				if (count($classNames) > 0) {
					if (empty($namespacePath)) {
						$classNamesWithNamespace = $classNames;
					}
					else {
						foreach ($classNames as $index => $value) {
							array_push($classNamesWithNamespace, "{$namespacePath}\\{$value}");
						}
					}
					$result[$index1] = $classNamesWithNamespace;
				}
			}
			return $result;
		}

		public function LensPhpCodeClassStructures() {
			$result = array();
			$joint = new lidjoint\Joint(null);
			if ($this->platform->RequireonceDirectories($this->brick->ReadFlats())) {
				$phpClasses = $this->LensPhpCodeClasses();
				foreach ($phpClasses as $index1 => $value1) {
					$classStructures = array();
					foreach ($value1 as $index2 => $value2) {
						array_push($classStructures, $joint->Signature($value2));
					}
					$result[$index1] = $classStructures;
				}
			}
			return $result;
		}

		private function SearchArrayAsStringOutdepth(array $stringArray, string $searchString) {
			if (count($stringArray) > 0) {
				foreach ($stringArray as $index => $value) {
					if ($value === $searchString) {
						return true;
					}
				}
			}
			return false;
		}
	}
?>

<?php
	use lid\home\well\heap as lidheap;

	class Specimen extends lidjoint\Joint {
		public function __construct() {
			$platform = new lidheap\Platform();
			$directory = new lidheap\Directory();
			$file = new lidheap\File();
			$compute = new lidheap\Compute();
			if (lidjoint\Joint::SeeAuthentic($platform) && lidjoint\Joint::SeeAuthentic($directory) && lidjoint\Joint::SeeAuthentic($file) && lidjoint\Joint::SeeAuthentic($compute)) {
				$this->ChainSampling($platform, $directory, $file, $compute);
			}
			else {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}

		private function ChainSampling(lidheap\Platform $platform, lidheap\Directory $directory, lidheap\File $file, lidheap\Compute $compute) {
			$street = $platform->ReadStreet();
			$lamp = $platform->ReadLamp();
			echo "<h6>1: Platform - RequireonceDirectory (home/margosa/now)</h6>";
			echo $platform->RequireonceDirectory("home/margosa/now") ? "Success" : "Unsuccess";

			echo "<h6>2: Platform - RequireonceFile (home/well, water.php)</h6>";
			echo $platform->RequireonceFile("home/well", "water.php") ? "Success" : "Unsuccess";

			echo "<h6>3: Platform - SearchScriptAsCurrentscript (well/heap.php)</h6>";
			echo $platform->SearchScriptAsCurrentscript("well/heap.php") ? "Success" : "Unsuccess";

			echo "<h6>4: Directory - ReadTopDirectory</h6>";
			echo $directory->ReadTopDirectory();

			echo "<h6>5: Directory - FineDirectoryPath (home/margosa/now)</h6>";
			echo $directory->FineDirectoryPath("home/margosa/now");

			echo "<h6>6: Directory - UnfineDirectoryPath (./lid/home/margosa/now)</h6>";
			echo $directory->UnfineDirectoryPath("./lid/home/margosa/now");

			echo "<h6>7: Directory - ContainsDirectoryName (home/margosa/now | home/margosa/spin, Spin)</h6>";
			echo $directory->ContainsDirectoryName(array("home/margosa/now", "home/margosa/spin"), "Spin") ? "Success" : "Unsuccess";

			echo "<h6>8: Directory - ReadRecentDirectorylist ()</h6>";
			echo "<pre>";
			print_r($directory->ReadRecentDirectorylist());
			echo "</pre>";
			
			echo "<h6>9: Directory - RefreshRecentDirectorylistIndepth (home/margosa)</h6>";
			echo "<pre>";
			print_r($directory->RefreshRecentDirectorylistIndepth("home/margosa"));
			echo "</pre>";

			echo "<h6>10: Directory - ReadRecentDirectorylist ()</h6>";
			echo "<pre>";
			print_r($directory->ReadRecentDirectorylist());
			echo "</pre>";

			echo "<h6>11: Directory - MakeDirectory (home/margosa/spin/algebrafate/ARandomDirectory)</h6>";
			echo $directory->MakeDirectory("home/margosa/spin/algebrafate/ARandomDirectory") ? "Success" : "Directory not made or already exists";
			
			echo "<h6>12: Directory - DeleteDirectory (home/margosa/spin/algebrafate/ARandomDirectory)</h6>";
			echo $directory->DeleteDirectory("home/margosa/spin/algebrafate/ARandomDirectory") ? "Success" : "Directory not deleted or not exists";
		
			echo "<h6>13: Directory - RefreshRecentDirectorylistIndepth ()</h6>";
			echo "<pre>";
			print_r($directory->RefreshRecentDirectorylistIndepth());
			echo "</pre>";

			echo "<h6>14: File - ContainsFileName (home/margosa/now/flower.php | home/margosa/now/leaf.php, Leaf.php)</h6>";
			echo $file->ContainsFileName(array("home/margosa/now/flower.php", "home/margosa/now/leaf.php"), "Leaf.php") ? "Success" : "Unsuccess";

			echo "<h6>15: File - EnlistFilelist (home/margosa/now)</h6>";
			echo "<pre>";
			print_r($file->EnlistFilelist("home/margosa/now"));
			echo "</pre>";

			echo "<h6>16: Street - ReadGets</h6>";
			echo "<pre>";
			print_r($street->ReadGets());
			echo "</pre>";

			echo "<h6>17: Lamp - TestPdoAc</h6>";
			echo $lamp->TestPdoAc();

			$lensDirectories = $compute->LensDirectories();
			echo "<h6>X1: Compute - LensDirectories | {Primary directories (exists)} | [0]</h6>";
			echo "<pre>";
			print_r($lensDirectories[0]);
			echo "</pre>";

			echo "<h6>X2: Compute - LensDirectories | {Primary directories (do not exist - set)} | [1]</h6>";
			echo "<pre>";
			print_r($lensDirectories[1]);
			echo "</pre>";

			$lensDirectories = $compute->LensDirectories(false);
			echo "<h6>X3: Compute - LensDirectories (false) | {All directories (primary only)} | [0]</h6>";
			echo "<pre>";
			print_r($lensDirectories[0]);
			echo "</pre>";

			echo "<h6>X4: Compute - LensDirectories (false) | {All directories (non primary)} | [1]</h6>";
			echo "<pre>";
			print_r($lensDirectories[1]);
			echo "</pre>";

			echo "<h6>X5: Compute - LensFiles | {Primary directory files}</h6>";
			echo "<pre>";
			print_r($compute->LensFiles());
			echo "</pre>";

			echo "<h6>X6: Compute - LensFiles (false) | {All files}</h6>";
			echo "<pre>";
			print_r($compute->LensFiles(false));
			echo "</pre>";
		}
	}
?>
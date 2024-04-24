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
				if (lidjoint\Joint::SeeAuthentic($this->pull)) {
					$this->push = new lidpush\Push();
					if (lidjoint\Joint::SeeAuthentic($this->push)) {
						$this->street = $this->push->ReadStreet();
						$this->lamp = new Lamp();
						$this->wide = new Wide();
						$this->notice = new Notice();
						$this->run = new Run();
						$this->dive = new Dive();
						if (lidjoint\Joint::SeeAuthentic($this->lamp) && lidjoint\Joint::SeeAuthentic($this->wide) && lidjoint\Joint::SeeAuthentic($this->notice) && lidjoint\Joint::SeeAuthentic($this->run) && lidjoint\Joint::SeeAuthentic($this->dive)) {
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

		public function ReadDirectory() {
			return $this->directory;
		}

		public function ReadFile() {
			return $this->file;
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
			$fileFullPaths = $this->file->CollectNamesInPath($directoryPath);
			if (count($fileFullPaths) == 0) {
				return true;
			}
			foreach ($fileFullPaths as $index => $value) {
				$fileFullPath = $this->directory->ReadPathTop() . "/{$directoryPath}/{$value}";
				if (!$this->SeeRunningScript($fileFullPath)) {
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

		public function SipRequireonceDirectory(array $directoryPaths) {
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
			$fullFilePath = $this->directory->ReadPathTop() . "/{$directoryPath}/{$fileName}";
			if (!$this->SeeRunningScript($fullFilePath)) {
				if (is_file($fullFilePath)) {
					return require_once($fullFilePath);
				}
			}
			return false;
		}

		public function SeeRunningScript(string $fileName) {
			$presentScriptFile = str_replace("\\", "/", __FILE__);
			$fileName = $fileName[0] == "." ? substr($fileName, 1) : $fileName;
			return str_contains($presentScriptFile, $fileName) ? true : false;
		}
	}

	/* eat */
	class Directory extends lidjoint\Joint {
		protected array $pathsRecent;
		protected string $pathTop;
		private string $pathRecyclebin;

		public function __construct() {
			$this->pathsRecent = array();
			$this->pathTop = "./lid";
			$this->pathRecyclebin = "home/margosa/spin/algebrafate/recyclebin";
			parent::__construct($this);
		}

		public function ReadPathTop() {
			return $this->pathTop;
		}

		public function ReadPathsRecent() {
			return $this->pathsRecent;
		}

		public function TripPathsRecent(?string $path =null, ?bool $depth = true, ?array $parts = array("directory")) {
			$this->pathsRecent = $this->IndirectCollectTree((empty($path) ? "" : $path), $depth, $parts);
			return $this->pathsRecent;
		}

		public function DirectPath(string $path) {
			$path = trim($path, "/");
			if (empty($path)) {
				return $this->pathTop;
			}
			else if (str_starts_with($path, $this->pathTop)) {
				return $path;
			}
			else {
				return "{$this->pathTop}/{$path}";
			}
		}

		public function IndirectPath(string $directPath) {
			$directPath = trim($directPath, "/");
			if ($directPath === $this->pathTop) {
				return "";
			}
			else if (!str_starts_with($directPath, $this->pathTop)) {
				return $directPath;
			}
			else {
				return trim(ltrim($directPath, $this->pathTop), "/");
			}
		}

		public function LetExisting(string $path, string $part = "directory") {
			$directPath = $this->DirectPath($path);
			if (file_exists($directPath)) {
				switch ($part) {
					case "directory":
						return is_dir($directPath);
						break;
					case "file":
						return is_file($directPath);
						break;
					default:
						return false;
				}
			}
			return false;
		}

		public function SeePathParent (string $path, string $part = "directory") {
			return $this->LetExisting($path, $part) ? $this->IndirectPath(dirname($this->DirectPath($path))) : "";
		}

		public function SeeName(string $path, string $part = "directory") {
			$directPath = $this->DirectPath($path);
			return $this->LetExisting($path, $part) ? substr($directPath, strrpos($directPath, "/") + 1) : "";
		}

		public function SeePathHasName(string $path, string $name, string $part = "directory") {
			if (!empty($name)) {
				foreach (array_keys($this->IndirectCollectTree($path, false, array($part))) as $value) {
					if (strcmp($this->SeeName($value, $part), $name) === 0) {
						return true;
					}
				}
			}
			return false;
		}

		public function DirectCollectTree(string $path, ?bool $depth = true, ?array $parts = array("directory")) {
			$result = array();
			$parts = is_null($parts) ? array("directory") : $parts;
			$depth = is_null($depth) ? true : $depth;
			if ($this->LetExisting($path)) {
				foreach (scandir($this->DirectPath($path)) as $value) {
					if (!($value === "." || $value === "..")) {
						foreach ($parts as $part) {
							$newPath = "{$path}/{$value}";
							if ($this->LetExisting($newPath, $part)) {
								$name = $this->SeeName($newPath, $part);
								$result[$name] = null;
								if ($depth) {
									$returned = $this->DirectCollectTree($newPath, $depth, $parts);
									if (count($returned) > 0) {
										$result[$name] = $returned;
									}
								}
							}
						}
					}
				}
			}
			return $result;
		}

		public function IndirectCollectTree(string $path, ?bool $depth = true, ?array $parts = array("directory")) {
			$result = array();
			$parts = is_null($parts) ? array("directory") : $parts;
			$depth = is_null($depth) ? true : $depth;
			if ($this->LetExisting($path)) {
				foreach (scandir($this->DirectPath($path)) as $value) {
					if (!($value === "." || $value === "..")) {
						foreach ($parts as $part) {
							$newPath = "{$path}/{$value}";
							if ($this->LetExisting($newPath, $part)) {
								$name = $this->SeeName($newPath, $part);
								$result[trim($newPath, "/")] = null;
								if ($depth) {
									$returned = $this->IndirectCollectTree($newPath, $depth, $parts);
									if (count($returned) > 0) {
										$result = array_merge($result, $returned);
									}
								}
							}
						}
					}
				}
			}
			return $result;
		}

		public function Make(string $path) {
			if (!$this->LetExisting($path)) {
				return mkdir($this->DirectPath($path));
			}
			return false;
		}

		public function Move(string $path, string $pathLocation, ?string $name = null) {
			if ($this->LetExisting($path) && $this->LetExisting($pathLocation)) {
				$pathParent = $this->SeePathParent($path);
				$nameProvided = $this->SeeName($path);
				if (!empty($pathParent) && !empty($nameProvided)) {
					if ($this->SeePathHasName($pathParent, $nameProvided, "directory")) {
						$name = empty($name) ? $this->SeeName($path) : $name;
						return rename($this->DirectPath($path), $this->DirectPath($pathLocation) . "/{$name}");
					}
				}
			}
			return false;
		}

		public function Delete(string $path) {
			$result = false;
			if ($this->LetExisting($path)) {
				$name = $this->SeeName($path);
				if (!empty($name)) {
					$this->Make($this->pathRecyclebin);
					if ($this->LetExisting($this->pathRecyclebin)) {
						return $this->Move($path, $this->pathRecyclebin, "{$name}" . $this->CurrentTimePlatformSafe());
					}
				}
			}
			return $result;
		}

		public function Copy1(string $path, string$pathLocation, ?string $name =null, ?string $clause = "leave", ?bool $depth = true, ?array $parts = array("directory")) {

		}

		public function RefreshRecentDirectoriesIndepth(?string $path = null) {
			$this->pathsRecent = array();
			$this->CollectRecentDirectoriesIndepth(empty($path) ? "" : $path);
			return $this->pathsRecent;
		}

		public function CollectRecentDirectoriesIndepth(string $directoryPath) {
			foreach ($this->CollectDirectoriesOutdepth($this->DirectPath($directoryPath)) as $index => $value) {
				$foundDirectoryPath = "{$directoryPath}/{$value}";
				$foundDirectoryPath = strpos($foundDirectoryPath, "/") == 0 ? substr($foundDirectoryPath, 1) : $foundDirectoryPath;
				array_push($this->pathsRecent, $foundDirectoryPath);
				$this->CollectRecentDirectoriesIndepth($foundDirectoryPath);
			}
		}

		public function CollectDirectoriesOutdepth(string $directoryPath) {
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

		public function CollectDirectoriesFilesOutdepth(string $directDirectoryPath) {
			$directoriesandfiles = array();
			if (!($directDirectoryPath == "." || $directDirectoryPath == "..") && is_dir($directDirectoryPath)) {
				foreach(scandir($directDirectoryPath) as $index => $value) {
					if (!($value == "." || $value == "..")) {
						array_push($directoriesandfiles, $value);
					}
				}
			}
			return $directoriesandfiles;
		}

		public function CopyLeaveIndepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopy($directoryPath, $locationPath, "leaveindepth");
		}

		public function CopyMergeIndepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopy($directoryPath, $locationPath, "mergeindepth");
		}

		public function CopyLeaveOutdepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopy($directoryPath, $locationPath, "leaveoutdepth");
		}

		public function CopyMergeOutdepth(string $directoryPath, string $locationPath) {
			return $this->YieldCopy($directoryPath, $locationPath, "mergeoutdepth");
		}

		private function YieldCopy(string $directoryPath, string $locationPath, string $copyType) {
			$result = false;
			$directDirectoryPath = $this->DirectPath($directoryPath);
			if (is_dir($directDirectoryPath)) {
				$this->Make($locationPath);
				$fineLocationPath = $this->DirectPath($locationPath);
				if (is_dir($fineLocationPath)) {
					$result = $this->Copy($directDirectoryPath, $fineLocationPath, $copyType);
				}
			}
			return $result;
		}

		private function Copy(string $directDirectoryPath, string $fineLocationPath, string $copyType) {
			$result = true;
			$directoriesandfiles = $this->CollectDirectoriesFilesOutdepth($directDirectoryPath);
			if (count($directoriesandfiles) == 0) {
				return;
			}
			else {
				foreach ($directoriesandfiles as $index => $value) {
					$copySource = "{$directDirectoryPath}/{$value}";
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
							$result = $this->Copy("{$directDirectoryPath}/{$value}", "{$fineLocationPath}/{$value}", $copyType);
							break;
						case "mergeindepth":
							if (is_file($copySource)) {
								$result = copy($copySource, $copyTo);
							}
							else if (is_dir($copySource) && !file_exists($copyTo)) {
								$result = mkdir($copyTo);
							}
							$result = $this->Copy("{$directDirectoryPath}/{$value}", "{$fineLocationPath}/{$value}", $copyType);
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

		public function SeeNameInPath(string $filePath, string $fileName) {
			if (strcmp(substr($filePath, strrpos($filePath, "/") + 1), $fileName) == 0) {
				return true;
			}
			return false;
		}

		public function LetFile(array $filePaths, string $fileName) {
			$result = false;
			foreach ($filePaths as $index => $value) {
				if ($this->SeeNameInPath($value, $fileName)) {
					if (is_file($this->directory->DirectPath($value))) {
						$result = true;
					}
				}
			}
			return $result;
		}

		public function CollectNamesInPath(string $directoryPath) {
			$fileList = array();
			$directDirectoryPath = $this->directory->DirectPath($directoryPath);
			if (is_dir($directDirectoryPath)) {
				foreach (scandir($directDirectoryPath) as $index => $value) {
					if (!($value == "." || $value == "..") && is_file("{$directDirectoryPath}/{$value}")) {
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

		public function FindGet(string $key) {
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

		public function __construct() {
			// TODO: API : Service
			$this->brick = new lidwater\Brick();
			$this->platform = new Platform();
			if (!(lidjoint\Joint::SeeAuthentic($this->brick) && lidjoint\Joint::SeeAuthentic($this->platform))) {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}

		public function LensDirectories(bool $onlyPrimaryDirectory = true) {
			$result = array();

			$result1 = array();
			$result2 = array();
			$brickFlats = $this->brick->ReadFlats();
			$paths = array_keys($this->platform->ReadDirectory()->IndirectCollectTree(""));
			if ($onlyPrimaryDirectory) {
				foreach ($brickFlats as $flat) {
					if ($this->SeeArrayRowHasString($paths, $flat)) {
						array_push($result1, $flat);
					}
					else {
						array_push($result2, $flat);
					}
				}
			}
			else {
				foreach ($paths as $path) {
					if ($this->SeeArrayRowHasString($brickFlats, $path)) {
						array_push($result1, $path);
					}
					else {
						array_push($result2, $path);
					}
				}
			}
			array_push($result, $result1);
			array_push($result, $result2);

			return $result;
		}

		public function LensFiles(bool $onlyPrimaryDirectory = true) {
			$result = array();
			foreach (array_merge($this->LensDirectories($onlyPrimaryDirectory)[0], $this->LensDirectories($onlyPrimaryDirectory)[1]) as $path) {
				$names = $this->platform->ReadFile()->CollectNamesInPath($path);
				if (count($names) > 0) {
					$result[$path] = $names;
				}
			}
			return $result;
		}

		public function LensTextSlip(bool $onlyPrimaryDirectory = true, ?string $slipType = null) {
			$result = array();
			$slipType = empty($slipType) ? "text" : $slipType;
			foreach ($this->LensFiles($onlyPrimaryDirectory) as $path => $names) {
				foreach ($names as $name) {
					$slipPath = "{$path}/{$name}";
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
			foreach ($slipLines as $slipPath => $lines) {
				$classNames = array();
				$namespacePath = "";
				foreach ($lines as $line) {
					$line = trim($line);
					if (str_starts_with($line, "namespace") && str_ends_with($line, ";")) {
						$temp = ltrim($line, "namespace ");
						$namespacePath = rtrim($temp, ";");
					}
					else if (str_starts_with($line, "class")) {
						$temp = ltrim($line, "class ");
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
						foreach ($classNames as $className) {
							array_push($classNamesWithNamespace, "{$namespacePath}\\{$className}");
						}
					}
					$result[$slipPath] = $classNamesWithNamespace;
				}
			}
			return $result;
		}

		public function LensPhpCodeClassStructures() {
			$result = array();
			$joint = new lidjoint\Joint(null);
			if ($this->platform->SipRequireonceDirectory($this->brick->ReadFlats())) {
				$phpClasses = $this->LensPhpCodeClasses();
				foreach ($phpClasses as $slipPath => $classes) {
					$classStructures = array();
					foreach ($classes as $class) {
						array_push($classStructures, $joint->Signature($class));
					}
					$result[$slipPath] = $classStructures;
				}
			}
			return $result;
		}

		private function SeeArrayRowHasString(array $arrayRow, string $search) {
			if (count($arrayRow) > 0) {
				foreach ($arrayRow as $index => $value) {
					if ($value === $search) {
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

			echo "<h6>3: Platform - SeeRunningScript (well/heap.php)</h6>";
			echo $platform->SeeRunningScript("well/heap.php") ? "Success" : "Unsuccess";

			echo "<h6>4: Directory - ReadPathTop</h6>";
			echo $directory->ReadPathTop();

			echo "<h6>5: Directory - DirectPath (home/margosa/now)</h6>";
			echo $directory->DirectPath("home/margosa/now");

			echo "<h6>6: Directory - IndirectPath (./lid/home/margosa/now)</h6>";
			echo $directory->IndirectPath("./lid/home/margosa/now");

			echo "<h6>7: Directory - SeePathHasName (home/margosa/now, Flower.php)</h6>";
			echo $directory->SeePathHasName("home/margosa/now", "Flower.php", "file") ? "Success" : "Unsuccess";

			echo "<h6>7: Directory - DirectCollectTree (home/well, true, directory | file)</h6>";
			echo "<pre>";
			print_r($directory->DirectCollectTree("home/well", true, array("directory", "file")));
			echo "</pre>";

			echo "<h6>7: Directory - IndirectCollectTree (home/well, true, directory)</h6>";
			echo "<pre>";
			print_r($directory->IndirectCollectTree("home/well", true, array("directory")));
			echo "</pre>";

			echo "<h6>8: Directory - ReadPathsRecent ()</h6>";
			echo "<pre>";
			print_r($directory->ReadPathsRecent());
			echo "</pre>";

			echo "<h6>7: Directory - TripPathsRecent</h6>";
			echo "<pre>";
			print_r($directory->TripPathsRecent());
			echo "</pre>";

			echo "<h6>11: Directory - Make (home/margosa/spin/algebrafate/ARandomDirectory)</h6>";
			echo $directory->Make("home/margosa/spin/algebrafate/ARandomDirectory") ? "Success" : "Directory not made or already exists";
			
			echo "<h6>12: Directory - Delete (home/margosa/spin/algebrafate/ARandomDirectory)</h6>";
			echo $directory->Delete("home/margosa/spin/algebrafate/ARandomDirectory") ? "Success" : "Directory not deleted or not exists";

			echo "<h6>12: Directory - Copy1 (home/margosa/spin/algebrafate/ADirectoryToCopy, home/margosa/spin/algebrafate/recyclebin)</h6>";
			echo "<pre>";
			$directory->Make("home/margosa/spin/algebrafate/ADirectoryToCopy");
			print_r($directory->Copy1("home/margosa/spin/algebrafate/ADirectoryToCopy", "home/margosa/spin/algebrafate/recyclebin"));
			echo "</pre>";

			echo "<h6>14: File - LetFile (home/margosa/now/flower.php | home/margosa/now/leaf.php, Leaf.php)</h6>";
			echo $file->LetFile(array("home/margosa/now/flower.php", "home/margosa/now/leaf.php"), "Leaf.php") ? "Success" : "Unsuccess";

			echo "<h6>15: File - CollectNamesInPath (home/margosa/now)</h6>";
			echo "<pre>";
			print_r($file->CollectNamesInPath("home/margosa/now"));
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
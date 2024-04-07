<?php
	namespace lid\home\well\heap;
?>

<?php
	use lid\home\well\pull as lidpull;
	use lid\home\well\push as lidpush;
	use lid\home\well\water as lidwater;
?>

<?php
	/* recognize */
	class Platform {
		protected Directory $directory;
		protected File $file;
		protected Street $street;
		protected Lamp $lamp;
		protected Wide $wide;
		protected Notice $notice;
		protected Run $run;
		protected Dive $dive;
		protected Compute $compute;
		protected lidpull\Pull $pull;
		protected lidpush\Push $push;

		public function __construct() {
			try {
				$success = false;
				$this->directory = new Directory();
				$this->file = new File();
				if ($this->directory && $this->file && $this->RequireonceDirectory("home/well")) {
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
							$this->compute = new Compute();
							if ($this->street && $this->lamp && $this->wide && $this->notice && $this->run && $this->dive && $this->compute) {
								$success = true;
							}
						}
					}
				}
				if (!$success) {
					die("Execution interrupted. Possibly it gets fixed on refresh.");
				}
			}
			catch (\Exception $exception) {}
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

		public function ReadCompute() {
			return $this->compute;
		}

		public function RequireonceDirectory(string $directoryPath) {
			$filteredFileFullPaths = array();
			foreach ($this->file->EnlistFilelist($directoryPath) as $index => $value) {
				$fileFullPath = $this->directory->ReadTopDirectory() . "/{$directoryPath}/{$value}";
				if (!$this->SearchScriptAsCurrentScript($fileFullPath)) {
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
			// TODO: This function is not verified yet, verify after real implementation.
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
			if (!$this->SearchScriptAsCurrentScript($fullFilePath)) {
				if (is_file($fullFilePath)) {
					return require_once($fullFilePath);
				}
			}
			return false;
		}

		public function SearchScriptAsCurrentScript(string $fileName) {
			$presentScriptFile = str_replace("\\", "/", __FILE__);
			$fileName = $fileName[0] == "." ? substr($fileName, 1) : $fileName;
			return str_contains($presentScriptFile, $fileName) ? true : false;
		}
	}

	/* eat */
	class Directory {
		protected string $topDirectory;
		protected array $recentDirectorylist;
		private string $defaultTopDirectory;
		private string $recyclebinDirectory;

		public function __construct(?string $topDirectory = null) {
			$this->recentDirectorylist = array();
			$this->defaultTopDirectory = "./lid";
			$this->recyclebinDirectory = "home/margosa/spin/algebrafate/recyclebin";
			$this->topDirectory = empty($topDirectory) ? $this->defaultTopDirectory : $topDirectory;
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
	class File {
		private Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
		}

		public function ContainsFileName(array $filePaths, string $fileName) {
			$result = false;
			foreach ($filePaths as $index => $value) {
				if (strcmp(substr($value, strrpos($value, "/") + 1), $fileName) == 0) {
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
	class Street {
		protected array $gets;

		public function __construct() {
			$this->gets = array();
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
	class Lamp {
		protected ?\PDO $pdoAc;
		protected string $pdoType;
		protected lidwater\Sand $sand;

		public function __construct(string $pdoType = "mysql") {
			$this->pdoAc = null;
			$this->pdoType = $pdoType;
			$this->sand = new lidwater\Sand();

			if ($this->sand) {
				$this->constructPdoAc();
			}
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
				}
				catch (\PDOException $exception) {
					// TODO: Log following: echo $exception->getMessage();
				}
			}
		}

		public function destroyPdoAc() {
			$this->pdoAc = null;
		}

		public function TestPdoAc() {
			$sql = "CREATE DATABASE myDBPDO";

			try {
				$this->pdoAc->exec($sql); // use exec() because no results are returned
				echo "Database created successfully<br>";
			}
			catch (\PDOException $exception) {
				 echo $sql . "<br>" . $exception->getMessage();
			}
		}
	}

	/* likes */
	class Wide {
		public function __construct() {
			// TODO: Console | Log : Try-Catch handler
		}
	}

	/* hate */
	class Notice {
		public function __construct() {
			// TODO: Date | Time | Callback
		}
	}

	/* appeal */
	class Run {
		public function __construct() {
			// TODO: AJAX Live : Multi Page
		}
	}

	/* relate */
	class Dive {
		public function __construct() {
			// TODO: Unlimited Energy Exchange : Source Diagram -> Time
		}
	}

	/* reason */
	class Compute {
		public function __construct() {
			// TODO: API : Service
		}
	}
?>

<?php
	use lid\home\well\heap as lidheap;

	class Specimen {
		public function __construct() {
			$platform = new lidheap\Platform();
			$directory = new lidheap\Directory();
			$file = new lidheap\File();
			$street = $platform->ReadStreet();
			$lamp = $platform->ReadLamp();

			echo "<h6>1: Platform - RequireonceDirectory (home/margosa/now)</h6>";
			echo $platform->RequireonceDirectory("home/margosa/now") ? "Success" : "Unsuccess";

			echo "<h6>2: Platform - RequireonceFile (home/well, water.php)</h6>";
			echo $platform->RequireonceFile("home/well", "water.php") ? "Success" : "Unsuccess";

			echo "<h6>3: Platform - SearchScriptAsCurrentScript (well/heap.php)</h6>";
			echo $platform->SearchScriptAsCurrentScript("well/heap.php") ? "Success" : "Unsuccess";

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

			echo "<h6>16:Street - ReadGets</h6>";
			echo "<pre>";
			print_r($street->ReadGets());
			echo "</pre>";

			echo "<h6>17:Lamp - TestPdoAc</h6>";
			echo $lamp->TestPdoAc();
		}
	}
?>
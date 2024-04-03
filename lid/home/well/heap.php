<?php
	namespace lid\home\well\heap;
?>

<?php
	use lid\home\well\pull as lidpull;
?>

<?php
	class Platform {
		protected Directory $directory;
		protected File $file;
		protected lidpull\Pull $pull;

		public function __construct() {
			try {
				$success = false;
				$this->directory = new Directory();
				$this->file = new File();
				if ($this->directory && $this->file && $this->RequireonceDirectory("home/well")) {
					$this->pull = new lidpull\Pull();
					if ($this->pull) {
						$success = true;
					}
				}
				if (!$success) {
					die("Execution interrupted. Possibly it gets fixed on refresh.");
				}
			}
			catch (\Exception $exception) {}
		}

		public function RequireonceDirectory(string $directoryPath) {
			$filteredFileFullPaths = array();
			foreach ($this->file->EnlistFilelist($directoryPath) as $index => $value) {
				$fileFullPath = $this->directory->ReadTopDirectory() . "/{$directoryPath}/{$value}";
				if (!$this->SearchScriptIsCurrent($fileFullPath)) {
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
			if (!$this->SearchScriptIsCurrent($fullFilePath)) {
				if (is_file($fullFilePath)) {
					return require_once($fullFilePath);
				}
			}
			return false;
		}

		private function SearchScriptIsCurrent(string $fullFilePath) {
			$presentScriptFile = str_replace("\\", "/", __FILE__);
			$fullFilePath = $fullFilePath[0] == "." ? substr($fullFilePath, 1) : $fullFilePath;
			return str_contains($presentScriptFile, $fullFilePath) ? true : false;
		}
	}

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

		public function RecentDirectorylist() {
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

	class File {
		private Directory $directory;

		public function __construct() {
			$this->directory = new Directory();
		}

		public function ContainsFileName(string $filePaths, string $fileName) {
			// TODO: This function is not verified yet, verify after real implementation.
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
?>

<?php
	use lid\home\well\heap as lidheap;

	class Specimen {
		public function __construct() {
			$platform = new lidheap\Platform();
			$directory = new lidheap\Directory();
			$file = new lidheap\File();

			echo "<h6>1: RequireonceDirectory (home/margosa/now)</h6>";
			echo $platform->RequireonceDirectory("home/margosa/now") ? "Success" : "Unsuccess";

			echo "<h6>2: RequireonceFile (home/well, water.php)</h6>";
			echo $platform->RequireonceFile("home/well", "water.php") ? "Success" : "Unsuccess";

			echo "<h6>3: ReadTopDirectory</h6>";
			echo $directory->ReadTopDirectory();

			echo "<h6>4: FineDirectoryPath (home/margosa/now)</h6>";
			echo $directory->FineDirectoryPath("home/margosa/now");

			echo "<h6>5: UnfineDirectoryPath (./lid/home/margosa/now)</h6>";
			echo $directory->UnfineDirectoryPath("./lid/home/margosa/now");

			echo "<h6>3: RecentDirectorylist ()</h6>";
			echo "<pre>";
			print_r($directory->RecentDirectorylist());
			echo "</pre>";
			
			echo "<h6>4: RefreshRecentDirectorylistIndepth (home/margosa)</h6>";
			echo "<pre>";
			print_r($directory->RefreshRecentDirectorylistIndepth("home/margosa"));
			echo "</pre>";

			echo "<h6>5: RecentDirectorylist ()</h6>";
			echo "<pre>";
			print_r($directory->RecentDirectorylist());
			echo "</pre>";

			echo "<h6>6: MakeDirectory (home/margosa/spin/algebrafate/ARandomDirectory)</h6>";
			echo $directory->MakeDirectory("home/margosa/spin/algebrafate/ARandomDirectory") ? "Success" : "Directory not made or already exists";
			
			echo "<h6>7: DeleteDirectory (home/margosa/spin/algebrafate/ARandomDirectory)</h6>";
			echo $directory->DeleteDirectory("home/margosa/spin/algebrafate/ARandomDirectory") ? "Success" : "Directory not deleted or not exists";
		
			echo "<h6>8: RefreshRecentDirectorylistIndepth ()</h6>";
			echo "<pre>";
			print_r($directory->RefreshRecentDirectorylistIndepth());
			echo "</pre>";

			echo "<h6>9: EnlistFilelist (home/margosa/now)</h6>";
			echo "<pre>";
			print_r($file->EnlistFilelist("home/margosa/now"));
			echo "</pre>";
		}
	}
?>
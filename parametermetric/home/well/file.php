<?php
	namespace parametermetric\home\well\file;
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	use parametermetric\home\well\heap as heap;

	class File {
		private heap\Directory $directory;

		public function __construct() {
			$this->directory = new heap\Directory();
		}

		public function FileListRefresh(string $directoryPath) {
			$filteredList = array();
			$directoryFinePathAs = $this->directory->DirectoryFinePathAs($directoryPath);
			if (is_dir($directoryFinePathAs)) {
				foreach (scandir($directoryFinePathAs) as $index => $value) {
					if (!($value == "." || $value == "..") && is_file("{$directoryFinePathAs}/{$value}")) {
						array_push($filteredList, $value);
					}
				}
			}
			return $filteredList;
		}
	}

	use parametermetric\home\well\file as pond;
	class Specimen {
		public function __construct() {
			$file = new pond\File();

			echo "use parametermetric\home\well\\file as pond;<br>\$file = new pond\File();<br><br>";

			echo "\$file->FileListRefresh(\"home/margosa/now\");";
			echo "<pre>"; print_r($file->FileListRefresh("home/margosa/now")); echo "</pre>";
		}
	}
?>
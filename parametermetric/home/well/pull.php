<?php
	namespace parametermetric\home\well\pull;
	require_once("parametermetric/home/well/heap.php");
?>

<?php
	use parametermetric\home\well\heap as heap;
?>

<?php
	class Pull {
		protected heap\Directory $directory;
		protected heap\File $file;

		public function __construct() {
			$this->directory = new heap\Directory();
			$this->file = new heap\File();

			$this->Test();
		}

		public function Test() {
			//echo "I'm in Pull.";
		}
	}
?>

<?php
	use parametermetric\home\well\pull as ping;

	class Specimen {
		public function __construct() {}
	}
?>
<?php
	namespace lid\home\well\joint;
?>

<?php
	use lid\home\well\heap as lidheap;
?>

<?php
	class Joint {
		public function __construct() {}

		public function Test() {
			return "I know HTML.";
		}
	}

	class Slip {
		protected string $slipPath;
		protected lidheap\Directory $directory;

		public function __construct(string $slipPath) {
			$this->slipPath = $slipPath;
			$this->directory = new lidheap\Directory();
		}

		public function ReadSlipPath() {
			return $this->slipPath;
		}

		public function CreateSlip() {}

		public function CopySlip(string $newSlipPath) {}

		public function MoveSlip(string $directoryPath) {}

		public function TrashSlip() {}

		public function DeleteSlip() {}

		protected function FineSlipPath() {
			return $this->directory->FineDirectoryPath($this->slipPath);
		}

		protected function SearchSlipAsExists() {
			if (is_file($this->FineSlipPath())) {
				return true;
			}
			return false;
		}
	}

	class TextSlip extends Slip {
		public function __construct(string $slipPath) {
			parent::__construct($slipPath);
		}

		public function ReadSlip() {
			$result = array();
			if ($this->SearchSlipAsExists()) {
				$result = file($this->FineSlipPath());
			}
			return $result;
		}

		public function WriteSlip(string $filePath, array $lines) {}

		public function AppendSlip(string $filePath, array $lines) {}

		public function OverwriteSlip(string $filePath, array $lines) {}
	}

	class GraphicSlip extends Slip {
		public function __construct() {}
	}

	class VideoSlip extends Slip {
		public function __construct() {}
	}

	class BinarySlip extends Slip {
		public function __construct() {}
	}
	
	class CodeTextSlip extends TextSlip {
		public function __construct() {}
	}

	class PhpCodeTextSlip extends CodeTextSlip {
		public function __construct() {}
	}
?>

<?php
	use lid\home\well\joint as lidreason;

	class Specimen {
		public function __construct() {
			$joint = new lidreason\Joint();

			echo "<h6>1</h6>";
			echo $joint->Test();
		}
	}
?>
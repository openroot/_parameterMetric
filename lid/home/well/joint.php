<?php
	namespace lid\home\well\joint;
?>

<?php
	use lid\home\well\heap as lidheap;
?>

<?php
	class Base {
		public static int $objectBaseIdPointer = 1;
		public static array $objectBaseIds = array();
		public static int $resourceBaseIdPointer = 1;
		public static array $resourceBaseIds = array();
	}

	class Joint {
		protected int $baseId = 0;

		public function __construct(mixed $material) {
			if (!is_null($material)) {
				if (is_object($material)) {
					if ($material->baseId != -1) {
						$material->baseId = ++Base::$objectBaseIdPointer;
						array_push(Base::$objectBaseIds, $material->baseId);
					}
				}
				else if (is_resource($material)) {
					if ($material->baseId != -1) {
						$material->baseId = ++Base::$resourceBaseIdPointer;
						array_push(Base::$resourceBaseIds, $material->baseId);
					}
				}
			}
		}

		public function ReadBaseId() {
			return $this->baseId;
		}

		public static function SearchMaterialAsAuthenticate(mixed $material) {
			if (!is_null($material)) {
				if (is_object($material)) {
					foreach (Base::$objectBaseIds as $index => $value) {
						if ($value == $material->ReadBaseId()) {
							return true;
						}
					}
				}
				else if (is_resource($material)) {
					foreach (Base::$resourceBaseIds as $index => $value) {
						if ($value == $material->ReadBaseId()) {
							return true;
						}
					}
				}
				return false;
			}
		}
	}

	class Slip extends Joint {
		protected lidheap\Directory $directory;
		protected string $slipPath;

		public function __construct(string $slipPath) {
			$this->directory = new lidheap\Directory();
			$this->slipPath = $slipPath;
			parent::__construct($this);
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
			// TODO: Verify as text mime, to put $this->baseId = -1; on unsuccess.
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
		}
	}
?>
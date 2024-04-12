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
		protected int $baseId;
		private mixed $thisMaterial;

		public function __construct(mixed $material) {
			if (!is_null($material)) {
				$this->baseId = 1;
				$this->thisMaterial = $material;
				if (is_object($material)) {
					if (isset($material->baseId) && $material->baseId != -1) {
						$material->baseId = ++Base::$objectBaseIdPointer;
						Base::$objectBaseIds[$material->baseId] = get_class($material);
					}
				}
				else if (is_resource($material)) {
					if (isset($material->baseId) && $material->baseId != -1) {
						$material->baseId = ++Base::$resourceBaseIdPointer;
						// TODO: [NOT MISSION CRITICAL]
						// TODO: Unblock following when implemented & verified (first) in this project (as is_resource()).
						//Base::$resourceBaseIds[$material->baseId] = get_class($material);
					}
				}
			}
		}

		public function ReadBaseId() {
			return isset($this->thisMaterial->baseId) ? $this->thisMaterial->baseId : -1;
		}

		public function Signature(?string $className = null) {
			$result = array();
				$className = empty($className) ? get_class($this->thisMaterial) : $className;
				if (!empty($className)) {
					$result["className"] = $className;
					$result["classVarsNonprivate"] = get_class_vars($className);
					$result["classMethodsNonprivate"] = get_class_methods($className);
					$result["parentClass"] = array();
					$parentClassName = get_parent_class($className);
					if (!empty($parentClassName)) {
						$result["parentClass"] = $this->Signature($parentClassName);
					}
				}
			return $result;
		}

		public static function SearchMaterialAsAuthentic(mixed $material) {
			if (!is_null($material)) {
				if (is_object($material)) {
					foreach (Base::$objectBaseIds as $index => $value) {
						if ($index === $material->ReadBaseId()) {
							return true;
						}
					}
				}
				else if (is_resource($material)) {
					foreach (Base::$resourceBaseIds as $index => $value) {
						if ($index === $material->ReadBaseId()) {
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
			if (Joint::SearchMaterialAsAuthentic($this->directory)) {
				$this->slipPath = $slipPath;
			}
			else {
				$this->baseId = -1;
			}
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
			$slipMime = mime_content_type("./lid/{$slipPath}");
			if ($slipMime == "text/x-php" || $slipMime == "application/json") {
				parent::__construct($slipPath);
			}
			else {
				$this->baseId = -1;
			}
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
		public function __construct(string $slipPath) {
			$slipMime = mime_content_type("./lid/{$slipPath}");
			if ($slipMime == "text/x-php" || $slipMime == "application/json") {
				parent::__construct($slipPath);
			}
			else {
				$this->baseId = -1;
			}
		}
	}

	class PhpCodeTextSlip extends CodeTextSlip {
		public function __construct(string $slipPath) {
			$slipMime = mime_content_type("./lid/{$slipPath}");
			if ($slipMime == "text/x-php") {
				parent::__construct($slipPath);
			}
			else {
				$this->baseId = -1;
			}
		}
	}

	class JsonCodeTextSlip extends CodeTextSlip {
		public function __construct(string $slipPath) {
			$slipMime = mime_content_type("./lid/{$slipPath}");
			if ($slipMime == "application/json") {
				parent::__construct($slipPath);
			}
			else {
				$this->baseId = -1;
			}
		}
	}
?>

<?php
	use lid\home\well\joint as lidreason;

	class Specimen extends Joint {
		public function __construct() {
			$joint = new lidreason\Joint($this);
			if (!Joint::SearchMaterialAsAuthentic($joint)) {
				$this->baseId = -1;
			}
			parent::__construct($this);

			if (Joint::SearchMaterialAsAuthentic($joint)) {
				$textSlip = new lidreason\TextSlip("home/margosa/data/json/sample2.json");
				if (lidreason\Joint::SearchMaterialAsAuthentic($textSlip)) {
					echo "<h6>1: TextSlip - Signature</h6>";
					echo "<pre>";
					print_r($textSlip->Signature());
					echo "</pre>";

					echo "<h6>2: TextSlip - ReadSlip</h6>";
					echo "<pre>";
					print_r($textSlip->ReadSlip());
					echo "</pre>";
				}
			}
		}
	}
?>
<?php
	namespace parametermetric\home\Dhop\Des;

	class Me extends Friend {
		protected string $id = "dev.openroot@gmail.com";
		protected string $recognize = "D Tapader";
		private string $eat = "egg";
		private string $vehicle = "Yamaha FZ-S";

		public function __construct(string $id, string $recognize, string $eat, string $vehicle) {
			$this->id = $id;
			$this->recognize = $recognize;
			$this->eat = $eat;
			$this->vehicle = $vehicle;
		}

		public function Identity() {
			return $this->id;
		}

		public function Know() {
			return array($this->recognize, "eat {$this->eat}", "have {$this->vehicle}");
		}

		public function Ride() {
			return "{$this->vehicle}, do not entertain {$this->eat}";
		}
	}

	class Friend {
		protected string $id = "debcyberboy@gmail.com";
		protected string $name = "D Tapader";
		protected string $rent = "Aviator Sun-glass";
		protected array $likes = array("sketching", "programming");
		protected string $hate = "bore";
		private string $appeal = "engineer";
		private string $relate = "his";

		public function __construct(string $id, string $name, string $rent, array $likes, string $hate, string $appeal, string $relate) {
			$this->id = $id;
			$this->name = $name;
			$this->rent = $rent;
			$this->likes = $likes;
			$this->hate = $hate;
			$this->appeal = $appeal;
			$this->relate = $relate;
		}

		public function Explain() {
			return array("{$this->appeal} " . $this->name, "mighty to '{$this->rent}', ", "who likes " . implode(", ", $this->likes), "- is never {$this->hate}", "to share {$this->relate} {$this->rent}");
		}
	}
?>
<?php
	namespace parametermetric\home\Dhop\Des;

	class Me extends Friend {
		protected string $id = "";
		protected string $recognize = "Lorem Ipsum";
		private string $eat = "loremipsum";
		private string $vehicle = "Lorem IPSUM";
		private ?Friend $friend = null;

		public function __construct(string $id, string $recognize, string $eat, string $vehicle, ?Friend $friend = null) {
			$this->id = $id;
			$this->recognize = $recognize;
			$this->eat = $eat;
			$this->vehicle = $vehicle;
			$this->friend = $friend;
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
		protected string $id = "";
		protected string $name = "Foo Bar";
		protected string $rent = "Foo bar";
		protected array $likes = array("foo", "bar");
		protected string $hate = "foobar";
		private string $appeal = "FooBar";
		private string $relate = "foo bar";
		private ?Friend $friend = null;

		public function __construct(string $id, string $name, string $rent, array $likes, string $hate, string $appeal, string $relate, ?Friend $friend = null) {
			$this->id = $id;
			$this->name = $name;
			$this->rent = $rent;
			$this->likes = $likes;
			$this->hate = $hate;
			$this->appeal = $appeal;
			$this->relate = $relate;
			$this->friend = $friend;
		}

		public function Identity() {
			return $this->id;
		}

		public function Explain(?Friend $friend = null) {
			$this->Pipe($friend);
			return array("{$this->friend->appeal} " . $this->friend->name, "mighty to: {$this->friend->rent}, ", "who likes " . implode(", ", $this->friend->likes), "- is never {$this->friend->hate}", "to share {$this->friend->relate} {$this->friend->rent}");
		}

		private function Pipe(?Friend $friend = null) {
			if ($friend != null) {
				$this->friend = $friend;
			}
			else {
				$this->friend = $this;
			}
		}
	}
?>
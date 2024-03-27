<?php
	namespace parametermetric\home\Dhop\Des;

	class Me extends Friend {
		protected string $id = "";
		protected string $recognize = "Lorem Ipsum";
		private array $eat = array("loremipsum", "loremipsum", "loremipsum");
		private array $vehicle = array("Lorem IPSUM", "LOREM Ipsum");
		private ?Friend $friend = null;

		public function __construct(string $id, string $recognize, array $eat, array $vehicle, ?Friend $friend = null) {
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
			return array($this->recognize, "eat " . implode(", ", $this->eat), "have " . implode(", ", $this->vehicle) . " for transportation");
		}

		public function Ride(?Friend $friend = null) {
			return array(
				implode(" ", array($friend != null ? ucfirst($friend->reason[0]) : "When", "I ride " . (count($this->vehicle) > 1 ? "either of " : "") . implode(", ", $this->vehicle))),
				implode(" ", array($friend != null ? $friend->reason[1] : "do not", "entertain " . implode(" or ", $this->eat)))
			);
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
		protected array $reason = array("Foo", "bar");
		private ?Friend $friend = null;

		public function __construct(string $id, string $name, string $rent, array $likes, string $hate, string $appeal, string $relate, array $reason, ?Friend $friend = null) {
			$this->id = $id;
			$this->name = $name;
			$this->rent = $rent;
			$this->likes = $likes;
			$this->hate = $hate;
			$this->appeal = $appeal;
			$this->relate = $relate;
			$this->reason = $reason;
			$this->friend = $friend;
		}

		public function Identity() {
			return $this->id;
		}

		public function Explain(?Friend $friend = null) {
			$this->Pipe($friend);

			if ($friend == null) {
				return ucfirst(implode(" ", array(
					"{$this->friend->appeal} " . $this->friend->name, "mighty to: {$this->friend->rent}, ", "who likes " . implode(", ", $this->friend->likes), "- is never {$this->friend->hate}", "to share {$this->friend->relate} {$this->friend->rent}."
				)));
			}
			else {
				return implode(" ", array(
					ucfirst($this->friend->reason[0]) . " {$this->friend->reason[1]} ride or eat I accompany with ",
					"{$this->friend->appeal} " . $this->friend->name, "mighty to: {$this->friend->rent}, ", "who likes " . implode(", ", $this->friend->likes), "- is never {$this->friend->hate}", "to share {$this->friend->relate} {$this->friend->rent}",
					" with me."
				));
			}
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
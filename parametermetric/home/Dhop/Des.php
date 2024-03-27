<?php
	namespace parametermetric\home\Dhop\Des;

	class Me extends Friend {
		protected string $baseId = "";
		protected string $recognize = "Lorem Ipsum";
		private array $eat = array("loremipsum", "loremipsum", "loremipsum");
		private array $vehicle = array("Lorem IPSUM", "LOREM Ipsum");
		private ?Friend $friend = null;

		public function __construct(string $baseId, string $recognize, array $eat, array $vehicle, ?Friend $friend = null) {
			$this->baseId = $baseId;
			$this->recognize = $recognize;
			$this->eat = $eat;
			$this->vehicle = $vehicle;
			$this->friend = $friend;
		}

		public function baseIdentity() {
			return $this->baseId;
		}

		public function identify() {
			return $this->recognize;
		}

		public function Know() {
			return "I " . implode(", ", array(
				$this->recognize, "eat " . implode(", ", $this->eat), "have " . implode(", ", $this->vehicle) . " for transportation"
			)) . ".";
		}

		public function Ride(?Friend $friend = null) {
			return implode("; ", array(
				implode(" ", array($friend != null ? ucfirst($friend->reason[0]) : "When", "I ride " . (count($this->vehicle) > 1 ? "either of " : "") . implode(", ", $this->vehicle))),
				implode(" ", array($friend != null ? $friend->reason[1] : "do not", "entertain " . implode(" or ", $this->eat)))
			)) . ".";
		}
	}

	class Friend {
		protected string $baseId = "";
		protected string $name = "Foo Bar";
		protected string $rent = "Foo bar";
		protected array $likes = array("foo", "bar");
		protected string $hate = "foobar";
		private string $appeal = "FooBar";
		private string $relate = "foo bar";
		protected array $reason = array("Foo", "bar");
		private ?Friend $friend = null;

		public function __construct(string $baseId, string $name, string $rent, array $likes, string $hate, string $appeal, string $relate, array $reason, ?Friend $friend = null) {
			$this->baseId = $baseId;
			$this->name = $name;
			$this->rent = $rent;
			$this->likes = $likes;
			$this->hate = $hate;
			$this->appeal = $appeal;
			$this->relate = $relate;
			$this->reason = $reason;
			$this->friend = $friend;
		}

		public function baseIdentity() {
			return $this->baseId;
		}

		public function identify() {
			return $this->name;
		}

		public function Explain(?Friend $friend = null) {
			$this->Pipe($friend);

			if ($friend == null) {
				$stream = "";
				if (count($this->friend->likes) > 1) {
					$stream = " interests are " . implode(", ", array_slice($this->friend->likes, 0, count($this->friend->likes) - 1)) . " and " . array_slice($this->friend->likes, -1)[0] . ".";
				}
				else {
					$stream = " interest is {$this->friend->likes[0]}.";
				}
				return ucfirst(implode(" ", array(
					"{$this->friend->appeal} " . $this->friend->name, "mighty to: {$this->friend->rent}, ", "who likes " . implode(", ", $this->friend->likes), "- is never {$this->friend->hate}", "to share {$this->friend->relate} {$this->friend->rent}."
				))) . " " . ucfirst($this->friend->reason[0]) . " or {$this->friend->reason[1]} {$this->friend->hate} {$this->friend->relate}{$stream}";
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
			$this->friend = $friend != null ? $friend : $this;
		}
	}
?>
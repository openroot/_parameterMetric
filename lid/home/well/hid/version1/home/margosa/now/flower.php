<?php
	namespace lid\home\margosa\now\flower;
?>

<?php
?>

<?php
	class Me extends Friend {
		protected string $baseId = "";
		protected string $recognize = "Lorem Ipsum";
		private array $eat = array("loremipsum", "loremipsum", "loremipsum");
		private array $vehicle = array("Lorem IPSUM", "LOREM Ipsum");
		protected ?Friend $friend = null;

		public function __construct(string $baseId, string $recognize, array $eat, array $vehicle, ?Friend $friend = null) {
			$this->baseId = $baseId;
			$this->recognize = $recognize;
			$this->eat = $eat;
			$this->vehicle = $vehicle;
			$this->friend = $friend;
		}

		public function BaseIdentity() {
			return $this->baseId;
		}

		public function Identify() {
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
		protected ?Friend $friend = null;

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

		public function BaseIdentity() {
			return $this->baseId;
		}

		public function Identify() {
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
					"{$this->friend->appeal} {$this->friend->name}", "mighty to: {$this->friend->rent}, ", "who likes " . implode(", ", $this->friend->likes), "- is never {$this->friend->hate}", "to share {$this->friend->relate} {$this->friend->rent}."
				))) . " " . ucfirst($this->friend->reason[0]) . " or {$this->friend->reason[1]} {$this->friend->hate} {$this->friend->relate}{$stream}";
			}
			else {
				return implode(" ", array(
					ucfirst($this->friend->reason[0]) . " {$this->friend->reason[1]} ride or eat I accompany with ",
					"{$this->friend->appeal} {$this->friend->name}", "mighty to: {$this->friend->rent}, ", "who likes " . implode(", ", $this->friend->likes), "- is never {$this->friend->hate}", "to share {$this->friend->relate} {$this->friend->rent}",
					" with me."
				));
			}
		}

		private function Pipe(?Friend $friend = null) {
			$this->friend = $friend != null ? $friend : $this;
		}
	}
?>

<?php
	use lid\home\margosa\now\flower as lidtattooartist;

	class Specimen {
		public function __construct() {
			$iKnow = new lidtattooartist\Friend(
				"debcyberboy@gmail.com",
				"D Tapader",
				"Aviator Sun-glass",
				array("sketching", "programming", "learning"),
				"bore",
				"engineer",
				"his",
				array("when", "do not")
			);

			$iKnowAnother = new lidtattooartist\Friend(
				"dev.openroot@live.com",
				"Debaprasad Tapader",
				"Higher Education",
				array("cooking"),
				"late",
				"researcher",
				"above",
				array("code", "style")
			);

			$youThinkI = new lidtattooartist\Me(
				"dev.openroot@gmail.com",
				"Dev",
				array("Masala Dosa", "Milk Coffee", "Egg omelette"),
				array("Yamaha FZ-S", "HERCULES cycle"),
				$iKnow
			);

			echo "<h4>Me</h4>";

			echo $youThinkI->Know();
			echo "<br /><br />";
			echo $youThinkI->Ride($iKnow);
			echo "<br /><br />";
			echo $youThinkI->Explain($iKnow);
			echo "<br /><br />";
			echo "- regards, " . $youThinkI->Identify() . " [ " . $youThinkI->BaseIdentity() . " ]";

			echo "<h4>Friend</h4>";

			echo $iKnow->Explain();

			echo "<hr />";

			echo $iKnowAnother->Explain();
		}
	}
?>

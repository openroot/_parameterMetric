<?php
	namespace Dhop\Des;

	class Me extends Friend {
		public const id = "dev.openroot@gmail.com";
		private $eat = "egg";
		private $vehicle = "Yamaha FZ-S";

		public function Know() {
			return array(Me::id, "eat {$this->eat}", "have {$this->vehicle}");
		}

		public function Ride() {
			return "{$this->vehicle}, do not entertain {$this->eat}";
		}
	}

	class Friend {
		protected const id = "debcyberboy@gmail.com";
		protected $rent = "Aviator Sun-glass";
		protected $likes = array("sketching", "programming");
		protected $hate = "bore";
		private $appeal = "engineer";
		private $relation = "his";

		public function Explain() {
			return array("{$this->appeal} " . Friend::id, "mighty to '{$this->rent}', ", "who likes " . implode(", ", $this->likes), "- is never {$this->hate}", "to share {$this->relation} {$this->rent}");
		}
	}
?>

<?php
	use \Dhop\Des as DDoS;

	echo "<hr />";

	$youThinkI = new DDoS\Me();

	echo "I " . implode(", ", $youThinkI->Know()) . ".";
	echo "<br /><br />";
	echo "When I ride {$youThinkI->Ride()}.";
	echo "<br />";
	echo "I have a friend " . implode(" ", $youThinkI->Explain()) . " with me.";
	echo "<br /><br />";
	echo "- regards, " . DDoS\Me::id;

	echo "<hr />";

	$callForHelp = new DDoS\Friend();

	echo ucfirst(implode(" ", $callForHelp->Explain())) . ".";

	echo "<hr />";
?>
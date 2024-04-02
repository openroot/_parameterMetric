<?php
	namespace lid\home\well\water;
?>

<?php
?>

<?php
	class Brick {
		private array $flats;
		private array $hids;

		public function __construct() {
			$this->figureFlats();
			$this->figureHids();
		}

		public function fetchFlats() {
			return $this->flats;
		}

		public function fetchHids() {
			return $this->hids;
		}

		protected function figureFlats() {
			$this->flats = array(
				"home/margosa",
				"home/margosa/now",
				"home/margosa/data",
				"home/margosa/branch",
				"home/margosa/spin",
				"home/margosa/spin/algebrafate",
				"home/margosa/spin/algebrafate/recyclebin",
				"home/margosa/spin/exist",
				"home/analyze",
				"home/analyze/essay",
				"home/analyze/essay/ignore",
				"home/analyze/essay/spell",
				"home/analyze/essay/spell/power",
				"home/analyze/essay/restore",
				"home/analyze/checkupdate",
				"home/analyze/selfupdate",
				"home/analyze/fullcircle",
				"home/analyze/halfcircle",
				"home/square",
				"home/square/task",
				"home/square/task/left",
				"home/square/task/left/track",
				"home/square/task/flag",
				"home/square/tip",
				"home/machine",
				"home/machine/reach",
				"home/machine/dump",
				"home/machine/traffic",
				"home/machine/shuffle",
				"home/machine/calculator",
				"home/machine/specimen",
				"home/machine/dice",
				"home/machine/switch"
			);
		}

		protected function figureHids() {
			$this->hids = array(
				"version1"
			);
		}
	}
?>

<?php
	/*echo "<pre>water.php: \"Once boil done, at this point, it's executed and data in memory.\"</pre>";*/
?>
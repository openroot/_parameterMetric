<?php
	namespace lid\home\well\water;
?>

<?php
	use lid\home\well\joint as lidjoint;
?>

<?php
	class Brick extends lidjoint\Joint {
		private array $flats;
		private array $hids;
		private string $hidDirectoryPath;

		public function __construct() {
			$this->CapFlats();
			$this->CapHids();
			$this->hidDirectoryPath = "home/well/hid";
			parent::__construct($this);
		}

		public function ReadFlats() {
			return $this->flats;
		}

		public function ReadHids() {
			return $this->hids;
		}

		public function ReadHidDirectoryPath() {
			return $this->hidDirectoryPath;
		}

		protected function CapFlats() {
			$this->flats = array(
				"engineering",
				"engineering/coordinate",
				"engineering/division",
				"engineering/dry",
				"engineering/slope",
				"engineering/clutch",
				"engineering/symmetry",
				"transform",
				"transform/radian",
				"transform/theta",
				"transform/sumof",
				"transform/mi",
				"transform/pi",
				"transform/transpose",
				"transform/percentile",
				"transform/epsilon",
				"transform/addition",
				"transform/delta",
				"transform/pollen",
				"transform/attribute",
				"doctrine",
				"doctrine/threads",
				"doctrine/threads/brights",
				"doctrine/threads/rails",
				"doctrine/threads/grasses",
				"doctrine/threads/bouncers",
				"doctrine/threads/layers",
				"doctrine/resources",
				"doctrine/resources/magazines",
				"doctrine/resources/zips",
				"doctrine/resources/kits",
				"doctrine/structures",
				"doctrine/structures/abstracts",
				"doctrine/structures/extends",
				"doctrine/structures/vectors",
				"doctrine/structures/enums",
				"doctrine/structures/sustains",
				"doctrine/structures/dimensions",
				"doctrine/job",
				"doctrine/job/emergence",
				"doctrine/job/testify",
				"doctrine/job/stacked",
				"doctrine/job/routinely",
				"doctrine/function",
				"doctrine/function/asynchronous",
				"doctrine/function/synchronous",
				"doctrine/facades",
				"doctrine/facades/bundles",
				"doctrine/facades/cards",
				"doctrine/facades/placards",
				"doctrine/facades/grades",
				"doctrine/trace",
				"doctrine/trace/adjacent",
				"doctrine/trace/counter",
				"doctrine/transactions",
				"doctrine/transactions/sockets",
				"doctrine/transactions/pockets",
				"doctrine/transactions/definitions",
				"doctrine/transactions/temporaries",
				"doctrine/transactions/derivatives",
				"doctrine/transactions/mortgages",
				"doctrine/translations",
				"doctrine/translations/acronyms",
				"doctrine/translations/proportions",
				"doctrine/translations/addresses",
				"doctrine/translations/moderates",
				"doctrine/translations/recites",
				"rider",
				"rider/ornament",
				"rider/particular",
				"rider/mask",
				"rider/drink",
				"rider/drink/transfer",
				"rider/drink/brace",
				"rider/drink/halogen",
				"rider/drink/source",
				"rider/drink/guard",
				"rider/drink/bogusreturn",
				"rider/drink/replace",
				"rider/drink/score",
				"rider/drink/history",
				"rider/position",
				"rider/position/factory",
				"rider/position/happy",
				"rider/position/rear",
				"rider/position/sheet",
				"albino",
				"albino/concept",
				"albino/realistic",
				"albino/unmodified",
				"albino/unmodified/overcolour",
				"albino/unmodified/overcolour/alignment",
				"albino/unmodified/overcolour/closure",
				"albino/unmodified/overcolour/electric",
				"albino/unmodified/overcolour/count",
				"albino/unmodified/overcolour/attach",
				"albino/unmodified/overcolour/wood",
				"albino/unmodified/overcolour/support",
				"albino/unmodified/default",
				"albino/unmodified/default/place",
				"albino/unmodified/default/background",
				"albino/unmodified/default/case",
				"albino/unmodified/default/probe",
				"albino/unmodified/default/accompany",
				"albino/unmodified/diagram",
				"albino/unmodified/diagram/avail",
				"albino/unmodified/diagram/keyword",
				"albino/unmodified/diagram/keyword/reference",
				"albino/unmodified/diagram/keyword/type",
				"albino/unmodified/diagram/keyword/quantity",
				"albino/unmodified/diagram/keyword/opacity",
				"albino/unmodified/diagram/reasonless",
				"albino/unmodified/diagram/reasonless/graphite",
				"albino/unmodified/diagram/reasonless/season",
				"albino/unmodified/diagram/reasonless/matter",
				"albino/unmodified/diagram/tooth",
				"albino/unmodified/diagram/tooth/idol",
				"albino/unmodified/diagram/tooth/feed",
				"albino/unmodified/diagram/tooth/zoomversion",
				"albino/unmodified/distance",
				"albino/opposite",
				"albino/opposite/deadline",
				"albino/opposite/prototype",
				"rest",
				"rest/commit",
				"rest/chief",
				"rest/tend",
				"rest/minetag",
				"home",
				"home/margosa",
				"home/margosa/now",
				"home/margosa/data",
				"home/margosa/branch",
				"home/margosa/spin",
				"home/margosa/spin/algebrafate",
				"home/margosa/spin/algebrafate/recyclebin",
				"home/margosa/spin/exist",
				"home/well",
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
				"home/machine/switch",
				"same",
				"same/dictionary",
				"same/dictionary/token",
				"same/dictionary/token/chain",
				"same/dictionary/token/chain/result",
				"same/dictionary/token/signal",
				"same/eight",
				"same/eight/site",
				"same/eight/stamp",
				"same/eight/pots",
				"same/eight/exert",
				"same/eight/foil",
				"same/eight/option",
				"same/eight/timing",
				"same/eight/release",
				"same/outin",
				"same/outin/in",
				"same/outin/out",
				"currency",
				"currency/gap",
				"currency/gap/pump",
				"currency/gap/pump/original",
				"currency/gap/pump/knock",
				"currency/gap/hollow",
				"currency/gap/hollow/repeat",
				"currency/gap/hollow/pace",
				"currency/gap/clean",
				"currency/gap/clean/peer",
				"currency/gap/clean/interest",
				"currency/clone",
				"currency/clone/print",
				"currency/clone/print/queue",
				"currency/clone/print/resize",
				"currency/clone/context",
				"currency/clone/context/markup",
				"currency/clone/context/lack",
				"currency/clone/instead",
				"currency/clone/instead/steer",
				"currency/clone/instead/target",
				"currency/note",
				"currency/note/next",
				"currency/note/next/blanks",
				"currency/note/next/acute",
				"currency/note/previous",
				"currency/note/previous/paper",
				"currency/note/previous/form",
				"currency/note/set",
				"currency/note/set/carry",
				"currency/note/set/animal",
				"threshold",
				"threshold/leapdynamic",
				"threshold/leapdynamic/charge",
				"threshold/leapdynamic/compound",
				"threshold/leapdynamic/chock",
				"threshold/leapdynamic/culture",
				"threshold/leapdynamic/camp",
				"threshold/leapdynamic/credit",
				"threshold/leapdynamic/contrast",
				"threshold/leapdynamic/celsius",
				"threshold/leapdynamic/car",
				"threshold/statistics",
				"threshold/statistics/architecture",
				"threshold/statistics/given",
				"threshold/statistics/day",
				"threshold/foresight",
				"threshold/foresight/requirement",
				"threshold/foresight/purpose",
				"threshold/foresight/shred",
				"threshold/foresight/reel",
				"threshold/unfold",
				"threshold/unfold/fold",
				"threshold/unfold/subtle",
				"threshold/unfold/ready",
				"threshold/unfold/false",
				"threshold/unfold/misogyny",
				"threshold/unfold/underscore",
				"threshold/unfold/recognize",
				"threshold/unfold/forty",
				"threshold/unfold/nonrelated",
				"threshold/unfold/boxpattern"
			);
		}

		protected function CapHids() {
			$this->hids = array(
				"version1"
			);
		}
	}

	class Dye extends lidjoint\Joint {
		private array $regions;

		public function __construct() {
			$this->CapRegions();
			parent::__construct($this);
		}

		public function ReadRegions() {
			return $this->regions;
		}
		
		protected function CapRegions() {
			$this->regions = array(
				"index_launch_skeleton"
			);
		}
	}

	class Sand extends lidjoint\Joint {
		private array $pdoAc;

		public function __construct() {
			$this->CapPdoAc();
			parent::__construct($this);
		}

		public function ReadPdoAc() {
			return $this->pdoAc;
		}

		protected function CapPdoAc() {
			$this->pdoAc = array(
				"servername" => "localhost",
				"username" => "devoptemp",
				"password" => "viAR8d4r",
				"databse" => "myDBPDO"
			);
		}
	}
?>

<?php
	use lid\home\well\water as lidwater;

	class Specimen extends lidjoint\Joint {
		public function __construct() {
			$brick = new lidwater\Brick();
			$dye = new lidwater\Dye();
			if (lidjoint\Joint::SeeAuthentic($brick) && lidjoint\Joint::SeeAuthentic($dye)) {
				echo "<h6>1: Brick - ReadFlats</h6>";
				echo "<pre>";
				print_r($brick->ReadFlats());
				echo "</pre>";

				echo "<h6>2: Brick - ReadHids</h6>";
				echo "<pre>";
				print_r($brick->ReadHids());
				echo "</pre>";

				echo "<h6>3: Dye - ReadRegions</h6>";
				echo "<pre>";
				print_r($dye->ReadRegions());
				echo "</pre>";

				/*echo "<pre>water.php: \"Once boil done, at this point, it's executed and data in memory.\"</pre>";*/
			}
			else {
				$this->baseId = -1;
			}
			parent::__construct($this);
		}
	}
?>
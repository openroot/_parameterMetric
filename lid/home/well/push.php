<?php
	namespace lid\home\well\push;
?>

<?php
?>

<?php
	class Push {
		public function __construct() {}
	}
?>

<?php
	use lid\home\well\push as lidpong;

	class Specimen {
		public function __construct() {
			$push = new lidpong\Push();
		}
	}
?>
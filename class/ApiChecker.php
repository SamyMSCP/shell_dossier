<?php
require_once "ApiTest.php";

class ApiChecker
{
	private static $nbr_test = 0;
	private static $fail = 0;
	private static $success = 0;
	private static $toTest = [
		"ApiScpi",
		"ApiSociety",
		"ApiPublication",
		"ApiActualite",
		"ApiBuilding"
	];

	public function __construct()
	{
		set_time_limit(0);
		self::testAll();
	}

	private function head()
	{
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
			<meta charset="utf-8">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.0/semantic.min.css"
				  integrity="sha256-/mC8AIsSmTcTtaf8vgnfbZXZLYhJCd0b9If/M0Y5nDw=" crossorigin="anonymous"/>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.0/semantic.js"
					integrity="sha256-fo+IDPj22bsomfjSdI2jkDQp1gYWhudJwp15cZdijQw=" crossorigin="anonymous"></script>
			<title>Api Checker</title>
		</head>
		<body>
		<?php
	}

	private function foot()
	{
		?>
		</body>
		<script>
			$('.ui.accordion').accordion();
		</script>
		</html>
		<?php
	}

	private function testRender($name, $result, $desc = "")
	{
		self::$nbr_test++;
		if ($result)
			self::$success++;
		else
			self::$fail++;
		?>
		<tr class="<?= ($result) ? '' : 'error' ?>">
			<?php if ($result): ?>
				<td><?= $name ?></td>
				<td class="collapsing"><i class="ui green check circle icon"></i></td>
			<?php else: ?>
				<td colspan="2">
					<div class="ui accordion">
						<div class="title">
							<i class="dropdown icon"></i>
							<?=$name?>
						</div>
						<div class="content">
							<p class="transition"><?= $desc ?></p>
						</div>
					</div>
				</td>
			<?php endif ?>
		</tr>
		<?php
	}

	private function body()
	{
		?>
		<div class="ui container fluid">
			<table class="ui celled striped table">
				<thead>
				<tr>
					<th colspan="2">Rendu des tests:</th>
				</tr>
				</thead>
				<tbody>
				<?php self::test() ?>
				</tbody>
			</table>
		</div>
		<div class="ui container">
			<div class="ui grid">
				<div class="four wide column">
					<div class="ui statistic">
						<div class="value"><?= self::$nbr_test ?></div>
						<div class="label">tests</div>
					</div>
				</div>
				<div class="four wide column">
					<div class="ui statistic">
						<div class="value"><?= self::$success ?></div>
						<div class="label">Success</div>
					</div>
				</div>
				<div class="four wide column">
					<div class="ui statistic">
						<div class="value"><?= self::$fail ?></div>
						<div class="label">Fail</div>
					</div>
				</div>
				<div class="four wide column">
					<div class="ui statistic">
					<div class="value"><?= number_format(self::$success / self::$nbr_test * 100.0, 2, ',', '') ?> %</div>
					<div class="label">Reussite</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public static function test()
	{
		foreach (self::$toTest as $test) {
			$c = new $test;
			try {
				$ret = $c->test();
				self::testRender($ret['name'], $ret['return'], $ret['desc']);
			}
			catch (Exception $e) { echo $e->getMessage(); }
			unset($c);
		}
	}

	public static function testAll()
	{
		self::head();
		self::body();
		self::foot();
	}
}

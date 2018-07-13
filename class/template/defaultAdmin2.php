<?php
$page->loadModule('VueJsBaseComponent','VueJsBaseComponent');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="icon" type="image/x-icon" href="img/favicon.webp">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="">
		<meta name="author" content="Anasse EL HANANI">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Anasse EL HANANI">
		<title><?=$page->title?> | Backoffice MeilleureSCPI.com</title>
		<?php include('headerCommun2.php') ?>
		<script src="lib/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" charset="utf-8">
			var store = new Vuex.Store({})
		</script>
		<style type="text/css" media="all">
			<?= $GLOBALS['autoprefixer']->compile(file_get_contents(__DIR__ . '/styleCommun.php')) ?>
		</style>
		<?php
			include('scriptCommun.php');
			require_once('vueJsUtil.php');
		?>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="lib/morris/morris.min.js"></script>
		<script type="text/javascript"><?= $page->scriptHead ?></script>
		<?= $page->header ?>
		<style><?= $page->style ?></style>
	</head>
	<body>
		<?= $page->body ?>
		<?php
			include('scriptBodyCommun.php');
		?>
		<script type="text/javascript" charset="utf-8">
			Vue.use(VueResource);
		</script>
		<script type="text/javascript"><?= $page->scriptBody ?></script>
		<style>
			@media (min-width: 1200px) {
				.container {
					width: 1105px;
				}
			}
		</style>
	</body>
</html>

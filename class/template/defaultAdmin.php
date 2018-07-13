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

		<?php
		/*
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.js"></script>
		<script src="lib/jquery_old/jquery.min.js"></script>

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="lib/jquery.actual/jquery.actual.js"></script>
		<link href='lib/montserrat/montserrat.css' rel='stylesheet' type='text/css'>

		<script src="chart.js"></script>

		<link href="lib/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

		<script src="chart.js"></script>
		<script src="lib/morris/morris.min.js"></script>
*/
?>



		<!--<script src="lib/vue/dist/vue.js"></script>
		<script src="lib/vuex/dist/vuex.js"></script>
		<script src="lib/vue-resource/dist/vue-resource.js"></script>-->
		<?php
			include('headerCommun.php');
		?>
		<script src="lib/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" charset="utf-8">
//			Vue.use(Vuex);
			var store = new Vuex.Store({})
		</script>
			<style type="text/css" media="all">
		<?php
			echo $GLOBALS['autoprefixer']->compile(file_get_contents(__DIR__ . '/styleCommun.php'));
			//echo file_get_contents(__DIR__ . '/styleCommun.php');
		?>
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

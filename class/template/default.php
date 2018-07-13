<?php
$page->loadModule('MessageBox','MessageBox');
$dh = Dh::getCurrent();
if (!empty($dh))
$page->loadModule("DhFrontStore", "DhFrontStore", array("dh" => $dh));
 ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" type="image/x-icon" href="img/favicon.webp">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Suivez la performance de vos SCPI avec le meilleur agrégateur du marché. Gratuit, accessible à tout moment.">
		<meta name="author" content="MeilleureSCPI.com">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=$page->title?> | MeilleureSCPI.com</title>

		<link href="lib/hamburgers/dist/hamburgers.css" rel="stylesheet">
		<script type="text/javascript" charset="utf-8" src="https://npmcdn.com/babel-transform-in-browser@6.4.6/dist/btib.min.js"></script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WSKRT22');</script>
<!-- End Google Tag Manager -->

		<?php
		/*
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.js"></script>
		<script src="lib/jquery_old/jquery.min.js"></script>

		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="lib/jquery.actual/jquery.actual.js"></script>
		<link href='lib/montserrat/montserrat.css' rel='stylesheet' type='text/css'>

		<script src="chart.js"></script>

		<link href="lib/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
		*/
		?>

		<?php
			include('headerCommun.php');
			//include('styleCommun.php');
		?>
			<style type="text/css" media="all">
		<?php
			echo $GLOBALS['autoprefixer']->compile(file_get_contents(__DIR__ . '/styleCommun.php'));
			//echo file_get_contents(__DIR__ . '/styleCommun.php');
			//echo file_get_contents(__DIR__ . '/styleCommun.php');
		?>
			</style>

		<?php
			include('scriptCommun.php');
			require_once('vueJsUtil.php');
		?>
		<script type="text/javascript"><?= $page->scriptHead ?></script>
		<?= $page->header ?>
		<style>
			<?php
				echo  $page->getStyle();
				//echo $page->style;
			?>
		</style>
	</head>
	<body>
		<?= $page->body ?>
		<?= $this->MessageBox ?>
		<?php
			//$page->MessageBox 
		?>
		<?php
			include('scriptBodyCommun.php');
		?>
		<script type="text/javascript" charset="utf-8">
			Vue.use(VueResource);
		</script>
		<script type="text/javascript"><?= $page->scriptBody ?></script>
		<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', 'UA-27134846-1', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>
	</body>
</html>

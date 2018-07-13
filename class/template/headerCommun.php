<?php if (!isProd()): ?>
	<script src="lib/vue/dist/vue.js?v=2.4.2"></script>
	<script src="lib/vuex/dist/vuex.js?v=2.4.0"></script>
	<script src="lib/vue-resource/dist/vue-resource.js?v=1.3.4"></script>
<?php else: ?>
	<script src="lib/vue/dist/vue.min.js?v=2.4.2"></script>
	<script src="lib/vuex/dist/vuex.min.js?v=2.4.0"></script>
	<script src="lib/vue-resource/dist/vue-resource.min.js?v=1.3.4"></script>
<?php endif; ?>
<script type="text/javascript" charset="utf-8">
	var store = new Vuex.Store({})
</script>
<?php if (OFFLINE_MODE) : ?>
<script type="text/javascript" src="lib/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="lib/jquery-ui.js?v=1.12.1"></script>
<link href="lib/jquery-ui.css?v=1.12.1" rel="stylesheet">
<script type="text/javascript" src="lib/jquery.cookie.min.js?v=1.4.1"></script>
<script src="lib/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<link href="lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
<?php else : ?>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=Intl.~locale.fr-FR,Object.values"></script>
<?php endif ; ?>

<link href='lib/montserrat/montserrat.css' rel='stylesheet' type='text/css'>
<link href='lib/opensans/opensans.css' rel='stylesheet' type='text/css'>
<link href="lib/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="lib/jquery.actual/jquery.actual.js"></script>
<script src="lib/moment/moment-with-locales.min.js"></script>
<script src="chart.js"></script>
<script src="lib/num.js?v=2"></script>
<?php
/*

<script src="lib/bfh.js"></script>
*/
?>

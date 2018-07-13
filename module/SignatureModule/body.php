<h1 style="color: #1781e0;">CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form action="?p=<?=$GLOBALS['GET']['p']?><?=(isset($GLOBALS['GET']['projet'])) ? '&projet=' . $GLOBALS['GET']['projet'] : ""?><?=(isset($GLOBALS['GET']['client'])) ? '&client=' . $GLOBALS['GET']['client'] : ""?>" method="post" accept-charset="utf-8">
<div class="contentSituation">
<?php
include('firstPage.php');
include('secondPage.php');
?>
</form>

<?=$this->Loading?>
<?=$this->Nav2Minimal?>
<div class="containerPerso">
	<h1>CRÉATION DE VOTRE COMPTE</h1>
	<div class="traitOrange"> </div>
	<div class="progressBlk">
		<?=$this->ProgressBlock?>
	</div>
	<div class="contentSituation">
		<?php
		if ($this->state == 1 || $this->state == 2)
		{
			include("formNewUser.php");
			//include("ptest.php");
		}
		else if ($this->state == 3)
		{
			include("thanks.php");
		}
		?>
	</div>
</div>

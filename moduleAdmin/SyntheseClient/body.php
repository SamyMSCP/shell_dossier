<?php
/*
<?=$this->modal_content?>
*/
?>
<?php
//include($this->getPath() . 'modal_editTransaction.php');
?>
<div class="syntheseCLientTable">
	<button data-toggle="modal" data-target="#add_scpi" class="BtnStyle btnAddScpi" >
		<img src="<?=$this->getPath()?>img/BTN-Plus_Blanc.png" />
		<span style="font-size:14px;">AJOUTER UNE SCPI</span>
	</button>
</div>

<div id="appPortefeuille">
	<portefeuille-table></portefeuille-table>
	<portefeuille-modal></portefeuille-modal>
</div>
<?php
include("modal_new.php");
include("likeFront.php");
?>

<div class="ongletsBoutons">
	<ul>
	<?php
	$first = true;
	foreach ($this->onglets as $key => $elm) {
		?>
		<li  onclick="showOnglet('<?=str_replace("'", "_", str_replace(" ", "_", $key))?>');eval('init_<?=$elm?>();');" class='onglet_btn onglet_btn_<?=str_replace("'", "_", str_replace(" ", "_", $key))?><?php if ($first) echo " selected ";?>'><span><?=strtoupper($key)?></span></li >
		<?php
		$first = false;
	}
	?>
	</ul>
</div>
<div class="blockOnglet">
	<?php
	$first = true;
	foreach ($this->onglets as $key => $elm) {
		?>
		<div class="onglets onglet_<?=str_replace("'", "_", str_replace(" ", "_", $key))?>" <?php if ($first) echo "style='display:block'";?>>
			<?=$this->{$elm}?>
		</div>
		<?php
		$first = false;
	}
	?>
</div>

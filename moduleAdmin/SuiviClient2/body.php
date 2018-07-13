<div class="vueApp">
	<div style="text-align:center;">
		<?php
		if (!isset($this->noAdd) || $this->noAdd == false)
		{
			?>
			<div class="BtnSuivi">
				<btn-new-crm></btn-new-crm>
			</div>
			<?php
		}
		?>
	</div>
	<div class="suiviCLientTable">
		<modal-crm></modal-crm>
		<table-crm></table-crm>
	</div>
</div>

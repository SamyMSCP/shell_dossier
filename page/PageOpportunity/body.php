<?=$this->Nav2?>
<div class="containerPerso">
	<?= $this->MonCompte?>
	<div class="vueApp_opportunity">
		<div class="container research"><!-- RECHERCHE-->
			<fieldset class="col-lg-4">
				<legend class="text-uppercase">type d'opportunit&eacute;</legend>
				<div class="row">
					<div class="col-lg-6">
						<input type="checkbox" class="checkbox-search" id="search_nue"/>
						<label for="search_nue" class="checkbox-search-label">NUE PROPRIET&Eacute;</label>
					</div>
					<div class="col-lg-6">
						<input type="checkbox" class="checkbox-search" id="search_usu"/>
						<label for="search_usu" class="checkbox-search-label">USUFRUIT</label>
					</div>
				</div>
			</fieldset>
			<fieldset class="col-lg-4">
				<legend class="text-uppercase">Nom de la SCPI</legend>
				<select class="form-control select-search">
					<option value="" selected="">Aucune pr&eacute;f&eacute;rence</option>
					<?php
					//TODO: Add filter
					$s = ScpiList::getAll();
					foreach ($s as $key)
					{
						$id = $key->id;
						$name = $key->name;
						echo "<option>$name</option>";
					}
					?>
				</select>
			</fieldset>
			<fieldset class="col-lg-4">
				<legend class="text-uppercase">Dur&eacute;e du d&eacute;membrement</legend>
				<select class="form-control select-search">
					<option value="" selected="">Aucune pr&eacute;f&eacute;rence</option>
					<?php
					$i = 3;
					while ($i <= 20)
					{
						echo "<option>$i</option>";
						$i++;
					}
					?>
				</select>
			</fieldset>
		</div>
		<?=$this->OpportunityCreator?>
		<?=$this->OpportunityVisual?>
	</div>
</div>

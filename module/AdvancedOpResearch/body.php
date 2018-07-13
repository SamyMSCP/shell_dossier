<div class="modal fade modal_adv_search" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel">
	 <div class="modal-dialog modal-lg" style=" margin-top: 8vh;">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     		   <h4 class="modal-title" style="text-align: center;">MeilleureSCPI.com - Recherche Avanc&eacute;e<h4>
      		</div>
     		<div class="modal-body">
     			<div class="well">
     				<div class="row">
     					<div class="col-lg-6">
							<span class="input-group">
								<span class="input-group-addon">SCPI: </span>
								<select class="form-control" id="input-type" v-model="search_scpi">
									<option value="" selected="">Aucune pr&eacute;f&eacute;rence</option>
									<?php
									$s = ScpiList::getAll();
									foreach ($s as $key)
									{
										$id = $key->id;
										$name = $key->name;
										echo "<option>$name</option>";
									}
									?>
								</select>
							</span>
						</div>
						<div class="col-lg-6">
							<span class="input-group">
								<span class="input-group-addon">Dur&eacute;e</span>
								<input type="number" class="form-control" min="0" max="20" v-model="search_duree"/>
							</span>
						</div>
					</div>
					<div class="row" style=" margin-top: 16px;">
						<div class="col-lg-3">
							<input type="checkbox" v-model="search_key_en"/>
							S&eacute;lection de cle de r&eacute;partition:
						</div>
						<div class="col-lg-6" v-show="search_key_en">
							<div id="adjustRatio" ></div>
						</div>
					</div>
					<div class="row" v-show="search_key_en">
						<div class="col-lg-6" style="color:#01528a; z-index:3">
							<u>Nue Propri&eacute;t&eacute;:</u> {{search_key}} %
						</div>
						<div class="col-lg-6" style="color:#428bca; z-index:3">
							<u>Usufruit:</u> {{search_key_usu}} %
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn-mscpi" data-dismiss="modal" @click="search()"><i class="fa fa-search"></i> Rechercher</button>
				<button type="button" class="btn-mscpi" data-dismiss="modal" @click="clearSearch()">Annuler</button>
			</div>
		</div>
	</div>
</div>

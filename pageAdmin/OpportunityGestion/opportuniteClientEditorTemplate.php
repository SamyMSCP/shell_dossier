<div>
	<div class="modal fade opportuniteClientEditor" id="modalOpportunite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" style="border-radius: 15px;">
			<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
				<div class="modal-body">
					<div class="modalTitle">OPPORTUNITÉ</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img class="close-cross" src="img/crm/BTN-Close-01.png"/></button>
					<div class="trait"> </div>
					<div class="opportunity-form">
						<div>Status :</div>
						<div>
							<select v-model="selected.state" class="isSet">
								<option value="0">Ouverte</option>
								<option value="1">À saisir</option>
								<option value="2">Fermé (réussi)</option>
								<option value="3">Fermé (abandon)</option>
							</select>
						</div>
					</div>
					<div class="opportunity-form">
						<div>
							SCPI :
						</div>
						<div>
							<select v-model="selected.id_scpi" :class="{isSet: selected.id_scpi != 0}">
								<option value="0">Veuillez choisir une SCPI</option>
								<option v-for="scpi in $store.getters.getScpiOpportunite" :value="scpi.id"> {{ scpi.name }}</option>
							</select>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Type de propriété :</div>
						<div>
							<select v-model="selected.type" class="isSet">
								<option value="0">Nue propriété</option>
								<option value="1">Usufruit</option>
							</select>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Démembrement temporaire :</div>
						<div>
							<select v-model="selected.time_demembrement" class="isSet">
								<option v-for="n in 20" v-if="n > 2" :value="n">{{ n }}</option>
							</select>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Nombre de part:</div>
						<div>
							<input class="isSet" type="number" min="1" v-model="selected.nb_part"/>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Prix en &euro;:</div>
						<div>
							<input class="isSet" type="number" step="0.01" v-model="selected.price_per_part"/>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Clé de répartition (Nue propriété) :</div>
						<div>
							<input type="number" step="0.01" min="50" max="99.99" v-model="selected.key_nue" class="isSet"/>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Divisible :</div>
						<div>
							<select v-model="selected.partial_subscrib" class="isSet">
								<option value="1">oui</option>
								<option value="0">non</option>
							</select>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Validé :</div>
						<div>
							<select v-model="selected.validated" class="isSet">
								<option value="1">oui</option>
								<option value="0">non</option>
							</select>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Notification Client :</div>
						<div>
							<select v-model="selected.notif_client" class="isSet">
								<option value="0">non</option>
								<option value="1">oui</option>
							</select>
						</div>
					</div>
					<div class="btnV2">
						<button @click="saveSelected()">ENREGISTRER</button>
						<button data-toggle="modal" data-target="#presentation-state" class="text-uppercase">Pr&eacute;visualiser</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="presentation-state">
		<div class="modal-dialog modal-md" style="border-radius: 15px;">
			<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
				<div class="modal-body">
					<div class="modalTitle">RÉCAPITULATIF</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img class="close-cross" src="img/crm/BTN-Close-01.png"/></button>
					<div class="opportunity-form">
						<div>&Eacute;tat:</div>
						<div>
							<span style="color: #FFFFFF;" v-if="selected.state == 0" class="label label-primary">Ouverte</span>
							<span style="color: #FFFFFF;" v-if="selected.state == 1" class="label label-info">A Saisir</span>
							<span style="color: #FFFFFF;" v-if="selected.state == 2" class="label label-warning">Ferm&eacute; (Reussi)</span>
							<span style="color: #FFFFFF;" v-if="selected.state == 3" class="label label-danger">Ferm&eacute; (Abandon)</span>

						</div>
					</div>
					<div class="opportunity-form">
						<div>Nombre de part:</div>
						<div>{{selected.nb_part}}</div>
					</div>
					<div class="opportunity-form">
						<div>Prix de la part:</div>
						<div>{{selected.price_per_part}}</div>
					</div>
					<div class="opportunity-form">
						<div>Cl&eacute; Nu-propri&egrave;t&eacute;:</div>
						<div>{{selected.key_nue}}</div>
					</div>
					<div class="opportunity-form">
						<div>Cl&eacute; Usufruit:</div>
						<div>{{100.0 - selected.key_nue}}</div>
					</div>
					<div class="opportunity-form">
						<div>Volume Nue Propriete:</div>
						<div>{{(selected.nb_part * selected.price_per_part * (selected.key_nue / 100.0)).toFixed(2)}} &euro;</div>
					</div>
					<div class="opportunity-form">
						<div>Volume Usufruit:</div>
						<div>{{(selected.nb_part * selected.price_per_part * ((100.0 - selected.key_nue) / 100.0)).toFixed(2)}} &euro;</div>
					</div>
					<div class="opportunity-form">
						<div>Divisible:</div>
						<div>
							<i class="fa fa-check text-success" v-if="selected.partial_subscrib == 1"></i>
							<i class="fa fa-times text-danger" v-if="selected.partial_subscrib == 0"></i>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Valid&eacute;e:</div>
						<div>
							<i class="fa fa-check text-success" v-if="selected.validated == 1"></i>
							<i class="fa fa-times text-danger" v-if="selected.validated == 0"></i>
						</div>
					</div>
					<div class="opportunity-form">
						<div>Notification Client:</div>
						<div>
							<i class="fa fa-check text-success" v-if="selected.notif_client == 1"></i>
							<i class="fa fa-times text-danger" v-if="selected.notif_client == 0"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

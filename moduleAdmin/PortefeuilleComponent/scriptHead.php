</script>
<script type="text/x-template" id="portefeuilleModal">
	<div class="modal fade" id="bodyPortefeuilleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modalBig" style="border-radius: 15px;">
			<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
				<div class="modal-body">
					<div class="modalTransactionCons">
						Conseiller : 
						<select class="noBorder" v-model="trans.id_cons" @change="setModify(trans)">
							<option value="0">-</option>
							<option v-for="cons in $store.getters.getConseillers" :value="cons.id">{{ cons.shortName }}</option>
						</select>
					</div>
					<h3>
						Transaction nº {{ trans.id }} - 
						<select v-model="trans.type" class="noBorder" @change="setModify(trans)">
							<option value="A">Achat</option>
							<option value="V">Vente</option>
						</select>
					</h3>
					<div class="traitOrange"></div>
					<table class="tablePortefeuille">
						<thead>
							<tr>
								<th style="min-width: 50px;"></th>
								<th style="min-width: 190px;">Nom de la SCPI</th>
								<th style="min-width: 130px;">Nombre de parts</th>
								<th style="min-width: 90px;">Marché</th>
								<th style="min-width: 140px;">Type de propriété</th>
								<th style="min-width: 150px;">Cle de repartition</th>
								<th style="min-width: 150px;">Durée de démembrement</th>
								<th>Statut transaction</th>
								<th style="min-width:135px;">prix/part en pleine propriété</th>
								<th style="min-width:150px;">Montant d'investissement</th>
								<th style="min-width:150px;">Montant global de revente</th>
								<th style="min-width:190px;">Bénéficiaire</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="doMscpi" v-if="trans.doByMscpi">
										<div></div>
									</div>
									<div class="doOther" v-else></div>
								</td>
								<td>
									<select v-model="trans.id_scpi" @change="setModify(trans)">
										<option v-for="scpi in $store.getters.getAllScpiSorted" :value="scpi.id">{{ scpi.name}}</option>
									</select>
								</td>
								<td>
									<input type="text" step="any" v-model="trans.nbr_part" @keyup="setModify(trans)"/>
								</td>
								<td>
									<select v-model="trans.marcher" @change="setModify(trans)">
										<option>-</option>
										<option v-for="marcher in $store.state.transactions.lstMarcher" :value="marcher">{{ marcher }}</option>
									</select>
								</td>
								<td>
									<select v-model="trans.type_pro" @change="setModify(trans)">
										<option>Pleine propriété</option>
										<option>Nue propriété</option>
										<option>Usufruit</option>
									</select>
								</td>
								<td>
									<input type="number" min="1" max="99" step="any" v-model="trans.cle_repartition" @keyup="setModify(trans)" v-if="trans.type_pro != 'Pleine propriété'"/>
									<span v-else>-</span>
								</td>
								<td>
									<input type="number" min="0" max="20" v-model="trans.dt" @keyup="setModify(trans)" v-if="trans.type_pro != 'Pleine propriété'"/>
									<span v-else>-</span>
								</td>
								<td>
									<select v-model="trans.status_trans" @change="setModify(trans)">
										<option v-if="trans.info_trans != 'MS.C' || 1" value="-1">-</option>
										<option v-if="key == '5-0' || key == '6-0'" v-for="(status, key) in $store.state.transactions.lstStatusTransaction" :value="key">{{status}}</option>
									</select>
								</td>
								<td>
									<input min="1" type="number" v-model="trans.prix_part" step="any" @keyup="setModify(trans)"/>
								</td>
								<td>
									<span v-if="trans.type_pro == 'Pleine propriété'">{{ trans.prix_part * trans.nbr_part | euros }}</span>
									<span v-else>{{ trans.prix_part * trans.nbr_part * trans.cle_repartition / 100 | euros }}</span>
								</td>
								<td>
									<span v-if="trans.type_pro == 'Pleine propriété'">{{ getScpi(trans.id_scpi).value * trans.nbr_part | euros }}</span>
									<span v-else>{{ getScpi(trans.id_scpi).value * trans.nbr_part * trans.cle_repartition / 100 | euros }}</span>
								</td>
								<td>
									<select class="noBorder"@change="setModify(trans)" v-model="trans.id_beneficiaire">
										<option value="0">-</option>
										<option v-for="ben in $store.getters.getBeneficiaireForDh($store.getters.getSelectedDh.id)" :value="ben.id_benf">{{ ben.shortName }}</option>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="modalTransactionPlus">
						<div>
							<div>
								Date d'entrée en jouissance excel {{ trans.date_entre_joui | date }}
							</div>
							<div>
								Date d'entrée en jouissance calculée {{ trans.date_entre_joui_calc| date }}
							</div>
							<div>
								Date de sortie de jouissance excel {{ trans.date_fin_joui | date }}
							</div>
							<div>
								Date de sortie de jouissance calculée {{ trans.date_sortie_joui_calc | date }}
							</div>
						</div>
						<div>
							<div>
								Date de signature du BS
								<my-datepicker id="dateBsPortefeuille" v-model="trans.date_bs" @change="setModify(trans)"></my-datepicker>
							</div>
							<div>
								Date d'enregistrement
								<my-datepicker id="dateEnrPortefeuille" v-model="trans.enr_date" @change="setModify(trans)"></my-datepicker>
							</div>
							<div></div>
							<div></div>
						</div>
						<div>
							<div>
								Transaction réalisée par 
								<input type="text" v-model="trans.info_trans" @keyup="setModify(trans)" class="noBorder"/>
							</div>
							<div>
								Id Excel
								<input type="number" step="1" v-model="trans.id_excel" @keyup="setModify(trans)" />
							</div>
							<div></div>
							<div></div>
						</div>
					</div>

					<h4 style="margin-top:40px;">Documents justificatifs</h4>
					<div class="traitOrange"></div>
					<div class="blockTransactionDocuments">
						<document-btn class="btnTransactionDocument" v-for="typeDocument in $store.state.transactions.lstTypeDocument" id_entity="8" :link_entity="trans.id" :type_document="typeDocument.id" :key="typeDocument.id" >
							{{ typeDocument.name }}
						</document-btn>
					</div>
					<h4 style="margin-top:40px;">Commentaires</h4>
					<div class="traitOrange"></div>
					<ck-editor @change="setModify(trans)" id="transactionCom" height="140px" v-model="trans.commentaire"></ck-editor>
					<div class="align-btn-center">
						<button class="btn-mscpi" v-if="trans.isModify" @click="save(trans)">
							<i class="fa fa-floppy-o" aria-hidden="true"></i> ENREGISTRER
						</button>
						<button class="btn-mscpi btn-rouge" @click="setDelete(trans)">
							<i class="fa fa-times" aria-hidden="true"></i> SUPPRIMER
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/x-template" id="portefeuilleTable">
	<div>
		<div class="syntheseCLientList">
			<ul>
				<li class="BtnTransactionBeneficiaire" :class="{BtnTransactionBeneficiaireSelected : selectedBen == ben.id_benf}" v-for="ben in $store.getters.getBeneficiaireForDh($store.getters.getSelectedDh.id)"  @click="setSelectedBen(ben.id_benf)">
					<img :src="'<?=$this->getPath()?>img/' + ben.imgName"  alt="imgName" />
					{{ ben.shortName }}
				</li>
				<li class="BtnTransactionBeneficiaire" :class="{BtnTransactionBeneficiaireSelected : selectedBen == 0}" @click="setSelectedBen(0)" style="min-height: 10px;">
					Total
				</li>
				<li class="BtnTransactionBeneficiaire" :class="{BtnTransactionBeneficiaireSelected : seePotentiel}" @click="toogleSeePotentiel()" style="min-height: 10px;cursor:pointer !important;">
					Transaction potentielles
				</li>
				<?php
				if ($this->collaborateur->getType() == "yoda")
				{
					?>
					<li class="btn-mscpi btn-orange" style="margin: 10px 0px;">
						<a target="_blank" href="?p=ExportTransaction&client=<?=$GLOBALS['GET']['client']?>">Télécharger en csv</a>
					</li>
					<?php
				}

				if ($this->collaborateur->getType() == "yoda" || $this->collaborateur->getType() == "conseiller" || $this->collaborateur->getType() == "assistant" || $this->collaborateur->getType() == "prospecteur")
				{
					?>
					<li class="btn-mscpi btn-orange" style="margin: 10px 0px;">
						<a target="_blank" href="?p=ShowPatrimoine&client=<?=$GLOBALS['GET']['client']?>">Situation patrimoine</a>
					</li>
					<?php
				}

				if ($this->dh->isf == 1)
				{
					/*
					<li class="btn-mscpi btn-orange" style="margin: 10px 0px;">
						<a target="_blank" href="?p=ShowValeurIsf&client=<?=$GLOBALS['GET']['client']?>">Valeurs ISF <?=date('Y')?></a>
					</li>
					*/
					?>
					<li class="btn-mscpi btn-orange" style="margin: 10px 0px;">
						<a target="_blank" href="?p=ShowValeurIfi&client=<?=$GLOBALS['GET']['client']?>">Valeurs IFI <?=date('Y')?></a>
					</li>
					<li class="btn-mscpi btn-orange" style="margin: 10px 0px;">
						<a target="_blank" href="?p=ShowValeurIfi&expatrie=1&client=<?=$GLOBALS['GET']['client']?>">Valeurs IFI expatrié <?=date('Y')?></a>
					</li>
					<?php
					}
				?>
			</ul>
		</div>
		<div style="padding:10px 15px;overflow-x:hidden;">
			<table class="tablePortefeuille">
				<tbody>
					<tr class="subTr" v-if="getPP.length > 0">
						<td colspan="11">Pleine propriété</td>
					</tr>
					<tr v-if="getPP.length > 0">
						<th @click="setColumnToSort('doByMscpi')" style="min-width: 100px;"></th>
						<th @click="setColumnToSort('scpi')" >SCPI</th>
						<th @click="setColumnToSort('nbr_part')" >Nombre de parts</th>
						<th @click="setColumnToSort('enr_date')" >Date d'enregistrement</th>
						<th @click="setColumnToSort('date_entre_joui_calc')" title="La date d'entree en jouissance est la date dentree en jouissance de la pleine propriete=nue propriete=usufruit">Date d'entrée en jouissance *</th>
						<th @click="setColumnToSort('dt')" >Durée démembrement</th>
						<th @click="setColumnToSort('fin_demembrement')" >Fin du démembrement</th>
						<th @click="setColumnToSort('prix_part')" >prix/part</th>
						<th @click="setColumnToSort('montantInvestissement')" stlye="min-width:190px;">Montant d'investissement</th>
						<th @click="setColumnToSort('reventePotentielle')" stlye="min-width:190px;">Montant global de revente estimé</th>
						<th  stlye="min-width:190px;">+/- value</th>
					</tr>
					<tr v-for="trans in getPP"  @click="editTransaction(trans)" class="clickable" v-if="getPP.length > 0">
						<?php include("innerTable.php"); ?>
					</tr>
					<tr class="subTotal" v-if="getPP.length > 0">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementPP | euros }}</td>
						<td>{{ reventePP | euros }}</td>
						<td>{{ calcPlusMoinValue(investissementPP, reventePP) }}</td>
					</tr>
					<tr class="subTr" v-if="getNU.length > 0">
						<td colspan="11">Nue  propriété</td>
					</tr>
					<tr v-if="getNU.length > 0">
						<th @click="setColumnToSort('doByMscpi')" style="min-width: 100px;"></th>
						<th @click="setColumnToSort('scpi')" >SCPI</th>
						<th @click="setColumnToSort('nbr_part')" >Nombre de parts</th>
						<th @click="setColumnToSort('enr_date')" >Date d'enregistrement</th>
						<th @click="setColumnToSort('date_entre_joui_calc')" >Date d'entrée en jouissance</th>
						<th @click="setColumnToSort('dt')" >Durée démembrement</th>
						<th @click="setColumnToSort('fin_demembrement')" >Fin du démembrement</th>
						<th @click="setColumnToSort('prix_part')" >prix/part</th>
						<th @click="setColumnToSort('montantInvestissement')" stlye="min-width:190px;">Montant d'investissement</th>
						<th @click="setColumnToSort('reventePotentielle')" stlye="min-width:190px;">Montant global de revente estimé</th>
						<th  stlye="min-width:190px;">+/- value</th>
					</tr>
					<tr v-for="trans in getNU"  @click="editTransaction(trans)" class="clickable" v-if="getNU.length > 0">
						<?php include("innerTable.php"); ?>
					</tr>
					<tr class="subTotal" v-if="getNU.length > 0">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementNU | euros }}</td>
						<td>{{ reventeNU | euros }}</td>
						<td>{{ calcPlusMoinValue(investissementNU, reventeNU) }}</td>
					</tr>
					<tr class="subTr" v-if="getUS.length > 0">
						<td colspan="11">Usufruit</td>
					</tr>
					<tr v-if="getUS.length > 0">
						<th @click="setColumnToSort('doByMscpi')" style="min-width: 100px;"></th>
						<th @click="setColumnToSort('scpi')" >SCPI</th>
						<th @click="setColumnToSort('nbr_part')" >Nombre de parts</th>
						<th @click="setColumnToSort('enr_date')" >Date d'enregistrement</th>
						<th @click="setColumnToSort('date_entre_joui_calc')" >Date d'entrée en jouissance</th>
						<th @click="setColumnToSort('dt')" >Durée démembrement</th>
						<th @click="setColumnToSort('fin_demembrement')" >Fin du démembrement</th>
						<th @click="setColumnToSort('prix_part')" >prix/part</th>
						<th @click="setColumnToSort('montantInvestissement')" stlye="min-width:190px;">Montant d'investissement</th>
						<th @click="setColumnToSort('reventePotentielle')" stlye="min-width:190px;">Montant global de revente estimé</th>
						<th  stlye="min-width:190px;">+/- value</th>
					</tr>
					<tr v-for="trans in getUS"  @click="editTransaction(trans)" class="clickable" v-if="getUS.length > 0">
						<?php include("innerTable.php"); ?>
					</tr>
					<tr class="subTotal" v-if="getUS.length > 0">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementUS | euros }}</td>
						<td>{{ reventeUS | euros }}</td>
						<td>-</td>
					</tr>




					<tr class="subTr subTrPotentiel" v-if="getPotentielPP.length > 0">
						<td colspan="11" style="font-style: italic;">Pleine propriété potentielle</td>
					</tr>
					<tr v-if="getPotentielPP.length > 0">
						<th @click="setColumnToSort('doByMscpi')" style="min-width: 100px;"></th>
						<th @click="setColumnToSort('scpi')" >SCPI</th>
						<th @click="setColumnToSort('nbr_part')" >Nombre de parts</th>
						<th @click="setColumnToSort('enr_date')" >Date d'enregistrement</th>
						<th @click="setColumnToSort('date_entre_joui_calc')" >Date d'entrée en jouissance</th>
						<th @click="setColumnToSort('dt')" >Durée démembrement</th>
						<th @click="setColumnToSort('fin_demembrement')" >Fin du démembrement</th>
						<th @click="setColumnToSort('prix_part')" >prix/part</th>
						<th @click="setColumnToSort('montantInvestissement')" stlye="min-width:190px;">Montant d'investissement</th>
						<th @click="setColumnToSort('reventePotentielle')" stlye="min-width:190px;">Montant global de revente estimé</th>
						<th  stlye="min-width:190px;">+/- value</th>
					</tr>
					<tr v-for="trans in getPotentielPP"  @click="editTransaction(trans)" class="clickable" v-if="getPotentielPP.length > 0">
						<?php include("innerTable.php"); ?>
					</tr>
					<tr class="subTotal" v-if="getPotentielPP.length > 0">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementPotentielPP | euros }}</td>
						<td>{{ reventePotentielPP | euros }}</td>
						<td>{{ calcPlusMoinValue(investissementPP, reventePP) }}</td>
					</tr>

					<tr class="subTr subTrPotentiel" v-if="getPotentielNU.length > 0">
						<td colspan="11" style="font-style: italic;">Nue  propriété potentielle</td>
					</tr>
					<tr v-if="getPotentielNU.length > 0">
						<th @click="setColumnToSort('doByMscpi')" style="min-width: 100px;"></th>
						<th @click="setColumnToSort('scpi')" >SCPI</th>
						<th @click="setColumnToSort('nbr_part')" >Nombre de parts</th>
						<th @click="setColumnToSort('enr_date')" >Date d'enregistrement</th>
						<th @click="setColumnToSort('date_entre_joui_calc')" >Date d'entrée en jouissance</th>
						<th @click="setColumnToSort('dt')" >Fin du démembrement</th>
						<th @click="setColumnToSort('fin_demembrement')" >Fin du démembrement</th>
						<th @click="setColumnToSort('prix_part')" >prix/part</th>
						<th @click="setColumnToSort('montantInvestissement')" stlye="min-width:190px;">Montant d'investissement</th>
						<th @click="setColumnToSort('reventePotentielle')" stlye="min-width:190px;">Montant global de revente estimé</th>
						<th  stlye="min-width:190px;">+/- value</th>
					</tr>
					<tr v-for="trans in getPotentielNU"  @click="editTransaction(trans)" class="clickable" v-if="getPotentielNU.length > 0">
						<?php include("innerTable.php"); ?>
					</tr>
					<tr class="subTotal" v-if="getPotentielNU.length > 0">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementPotentielNU | euros }}</td>
						<td>{{ reventePotentielNU | euros }}</td>
						<td>{{ calcPlusMoinValue(investissementNU, reventeNU) }}</td>
					</tr>

					<tr class="subTr subTrPotentiel" v-if="getPotentielUS.length > 0">
						<td colspan="11" style="font-style: italic;">Usufruit potentielle</td>
					</tr>
					<tr v-if="getPotentielUS.length > 0">
						<th @click="setColumnToSort('doByMscpi')" style="min-width: 100px;"></th>
						<th @click="setColumnToSort('scpi')" >SCPI</th>
						<th @click="setColumnToSort('nbr_part')" >Nombre de parts</th>
						<th @click="setColumnToSort('enr_date')" >Date d'enregistrement</th>
						<th @click="setColumnToSort('date_entre_joui_calc')" >Date d'entrée en jouissance</th>
						<th @click="setColumnToSort('dt')" >Fin du démembrement</th>
						<th @click="setColumnToSort('fin_demembrement')" >Fin du démembrement</th>
						<th @click="setColumnToSort('prix_part')" >prix/part</th>
						<th @click="setColumnToSort('montantInvestissement')" stlye="min-width:190px;">Montant d'investissement</th>
						<th @click="setColumnToSort('reventePotentielle')" stlye="min-width:190px;">Montant global de revente estimé</th>
						<th  stlye="min-width:190px;">+/- value</th>
					</tr>
					<tr v-for="trans in getPotentielUS"  @click="editTransaction(trans)" class="clickable" v-if="getPotentielUS.length > 0">
						<?php include("innerTable.php"); ?>
					</tr>
					<tr class="subTotal" v-if="getPotentielUS.length > 0">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementPotentielUS | euros }}</td>
						<td>{{ reventePotentielUS | euros }}</td>
						<td>-</td>
					</tr>

					<tr class="tablePortefeuilleTotal">
						<td colspan="7"></td>
						<td>Total :</td>
						<td>{{ investissementTotal | euros }}</td>
						<td>{{ reventeTotal | euros }}</td>
						<td>-</td>
					</tr>
					<tr>
						<td colspan="11" style="border: none;">
							<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" style="height:32px;cursor:pointer;" @click="createTransaction()"/>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</script>
<script type="text/javascript" charset="utf-8">
	Vue.component(
		'portefeuilleModal',
		{
			computed: {
				trans: function (){
					return (this.$store.getters.getSelectedTransaction);
				}
			},
			methods: {
				save: function(trans) {
					this.$store.dispatch('TRANSACTIONS_UPDATE', trans).then(
						function() {
							$('#bodyPortefeuilleModal').modal("hide");
						}
					);
				},
				getScpi: function(id) {
					return (this.$store.getters.getScpi(id));
				},
				setModify: function (elm) {
					//elm.isModify = true;
				},
				setDelete: function(elm) {
					var that = this;
					msgBox.show("Voulez-vous vraiment supprimer cette transaction ?",[
						{
							text: "Oui",
							action: function() { 
								that.$store.dispatch("TRANSACTIONS_DELETE", elm).then(function() {
									$('#bodyPortefeuilleModal').modal("hide");
								});
							}
						},
						{
							text: "Non",
							action: function() {  }
						},
					]);
				},
				createTransaction: function () {
					this.$store.dispatch("TRANSACTIONS_CREATE", {
						id_dh: this.$store.getters.getSelectedDh.id,
						id_projet: -1,
						status_trans: "-1",
						info_trans: "",
						marcher: "Primaire"
					});
				}
			},
			template: '#portefeuilleModal'
		}
	);
	Vue.component(
		'portefeuilleTable',
		{
			data: function() {
				return ({
					selectedBen: 0,
					seePotentiel: false,
					sortedChoice: "scpi",
					sortReverse: false
				});
			},
			computed: {
				investissementTotal: function() {
					return (
						this.investissementPP + this.investissementNU + this.investissementUS +
						this.investissementPotentielPP + this.investissementPotentielNU + this.investissementPotentielUS
					);
				},
				reventeTotal: function() {
					return (
						this.reventePP + this.reventeNU + this.reventeUS +
						this.reventePotentielPP + this.reventePotentielNU + this.reventePotentielUS
					);
				},
				investissementPP: function() {
					var rt = 0;
					this.getPP.forEach(function(elm) {
						rt += elm.prix_part * elm.nbr_part;
					});
					return (rt);
				},
				investissementNU: function() {
					var rt = 0;
					this.getNU.forEach(function(elm) {
						rt += elm.prix_part * elm.nbr_part * elm.cle_repartition / 100;
					});
					return (rt);
				},
				investissementUS: function() {
					var rt = 0;
					this.getUS.forEach(function(elm) {
						rt += elm.prix_part * elm.nbr_part * elm.cle_repartition / 100;
					});
					return (rt);
				},
				reventePP: function() {
					var rt = 0;
					var that = this;
					this.getPP.forEach(function(elm) {
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part;
					});
					return (rt);
				},
				reventeNU: function() {
					var rt = 0;
					var that = this;
					this.getNU.forEach(function(elm) {
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part * elm.cle_repartition_dynamique / 100;
					});
					return (rt);
				},
				reventeUS: function() {
					var rt = 0;
					var that = this;
					this.getUS.forEach(function(elm) {
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part * elm.cle_repartition_dynamique / 100;
					});
					return (rt);
				},
				investissementPotentielPP: function() {
					var rt = 0;

					if (!this.seePotentiel)
						return (0);
					this.getPotentielPP.forEach(function(elm) {
						rt += elm.prix_part * elm.nbr_part;
					});
					return (rt);
				},
				investissementPotentielNU: function() {
					var rt = 0;

					if (!this.seePotentiel)
						return (0);
					this.getPotentielNU.forEach(function(elm) {
						rt += elm.prix_part * elm.nbr_part * elm.cle_repartition / 100;
					});
					return (rt);
				},
				investissementPotentielUS: function() {
					var rt = 0;

					if (!this.seePotentiel)
						return (0);
					this.getPotentielUS.forEach(function(elm) {
						rt += elm.prix_part * elm.nbr_part * elm.cle_repartition / 100;
					});
					return (rt);
				},
				reventePotentielPP: function() {
					var rt = 0;
					var that = this;

					if (!this.seePotentiel)
						return (0);
					this.getPotentielPP.forEach(function(elm) {
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part;
					});
					return (rt);
				},
				reventePotentielNU: function() {
					var rt = 0;
					var that = this;

					if (!this.seePotentiel)
						return (0);
					this.getPotentielNU.forEach(function(elm) {
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part * elm.cle_repartition_dynamique / 100;
					});
					return (rt);
				},
				reventePotentielUS: function() {
					var rt = 0;
					var that = this;

					if (!this.seePotentiel)
						return (0);
					this.getPotentielUS.forEach(function(elm) {
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part * elm.cle_repartition_dynamique / 100;
					});
					return (rt);
				},



				getPP: function() {
					return (this.getTransactions.filter(function(elm) {
						return (elm.type_pro === "Pleine propriété");
					}));
				},
				getNU: function() {
					return (this.getTransactions.filter(function(elm) {
						return (elm.type_pro === "Nue propriété");
					}));
				},
				getUS: function() {
					return (this.getTransactions.filter(function(elm) {
						return (elm.type_pro === "Usufruit");
					}));
				},
				getPotentielPP: function() {
					if (!this.seePotentiel)
						return ([]);
					return (this.getTransactionsPotentielles.filter(function(elm) {
						return (elm.type_pro === "Pleine propriété");
					}));
				},
				getPotentielNU: function() {
					if (!this.seePotentiel)
						return ([]);
					return (this.getTransactionsPotentielles.filter(function(elm) {
						return (elm.type_pro === "Nue propriété");
					}));
				},
				getPotentielUS: function() {
					if (!this.seePotentiel)
						return ([]);

					return (this.getTransactionsPotentielles.filter(function(elm) {
						return (elm.type_pro === "Usufruit");
					}));
				},
				getSorted5_6: function() {
					var that = this;

					return (this.$store.getters.getTransactionsForDh_5_6(this.$store.getters.getSelectedDh.id).sort(function(a, b) {
						var val = 0;

						if (that.sortedChoice == "scpi") {
							val = String(that.getScpi(a["id_scpi"]).name.toLowerCase()).localeCompare(String(that.getScpi(b["id_scpi"]).name.toLowerCase()))
						}
						else {
							val =  a[that.sortedChoice] - b[that.sortedChoice];
						}
						if (that.sortReverse)
							return (-val);
						return (val);
					}));
				},
				getTransactions: function() {
					var that = this;

					if (this.selectedBen == 0)
						return (this.getSorted5_6);
					else
						return (this.getSorted5_6.filter(function(trans) {
							return (trans.id_beneficiaire == that.selectedBen);
						}));
				},
				getTransactionsPotentielles: function() {
					var that = this;

					if (!this.seePotentiel)
						return ([]);
					return (this.$store.getters.getTransactionsForDh(this.$store.getters.getSelectedDh.id).filter(function(trans) {
						if (that.selectedBen == 0)
							return (trans.status_trans != "5-0" && trans.status_trans != "6-0" && trans.doByMscpi);
						else
							return (trans.status_trans != "5-0" && trans.status_trans != "6-0" && trans.doByMscpi && trans.id_beneficiaire == that.selectedBen);
					}));
				},
			},
			methods: {
				getPlusMoinValue: function(elm) {
					if (elm.type_pro === "Usufruit")
						return ('-');
					return (this.calcPlusMoinValue(elm.montantInvestissement, this.getReventePotentielle(elm)));
				},
				calcPlusMoinValue: function(buy, sell) {
					var val = (((sell / buy) - 1) * 10000);
					val = Math.round(val) / 100;
					return (val + " %");
				},
				getReventePotentielle: function(elm) {
					var rt = 0;
					var that = this;
					if (elm.type_pro === "Pleine propriété")
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part;
					else if (elm.type_pro === "Nue propriété")
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part * elm.cle_repartition_dynamique / 100;
					else if (elm.type_pro === "Usufruit")
						rt += that.getScpi(elm.id_scpi).value * elm.nbr_part * elm.cle_repartition_dynamique / 100;
					return (rt);
				},
				setColumnToSort: function(name) {
					if (this.sortedChoice == name)
						this.sortReverse = !this.sortReverse;
					else {
						this.sortReverse = false;
						this.sortedChoice = name;
					}
				},
				toogleSeePotentiel: function() {
					this.seePotentiel = !this.seePotentiel;
				},
				setSelectedBen: function(ben) {
					this.selectedBen = ben;
				},
				getScpi: function(id) {
					return (this.$store.getters.getScpi(id));
				},
				setModify: function (elm) {
					elm.isModify = true;
				},
				setDelete: function(elm) {
					var that = this;
					msgBox.show("Voulez-vous vraiment supprimer cette transaction ?",[
						{
							text: "Oui",
							action: function() { 
								that.$store.dispatch("TRANSACTIONS_DELETE", elm);
							}
						},
						{
							text: "Non",
							action: function() {  }
						},
					]);
				},
				createTransaction: function () {
					var that = this;
					this.$store.dispatch("TRANSACTIONS_CREATE", {
						id_dh: this.$store.getters.getSelectedDh.id,
						id_projet: -1,
						status_trans: "-1",
						info_trans: "",
						marcher: "Primaire"
					}).then(
						function(trans) {
							//var newTrans = that.$store.getters.getTransaction(trans.id);
							//console.log(newTrans);
							//that.editTransaction(newTrans);
						}
					);
				},
				editTransaction: function (trans) {
					// this.$store.state.transactions.selectedTransaction = JSON.parse(JSON.stringify(trans));
					//FIX HERE CALL STORE
					this.$store.commit("changeSelect", trans.id);
					$('#modal_transactio').modal("show");
					console.log(trans);
				}
			},
<?php if (!empty($GLOBALS['GET']['open_transac'])) : ?>
			mounted: function()
			{
				this.$store.dispatch('TRANSACTIONS_READ', {'id': <?= $GLOBALS['GET']['open_transac'] ?>})
				.then(function(){
					$('#modal_transactio').modal("show");
				});
			},
<?php endif; ?>
			template: '#portefeuilleTable'
		}
	);

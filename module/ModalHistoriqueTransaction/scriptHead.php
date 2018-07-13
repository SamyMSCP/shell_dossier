</script>
<script type="text/template" id="histo_transac">
<div>
	<div class="modal fade" v-bind:id="myIdModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
						<img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" />
					</button>
					<span class="pull-left modal-title">{{ SCPI | unprefix_scpi }}</span>
					<span class="pull-left modal-subtitle">[ {{ TypePro }} ]</span>
					<div class="pull-left modal-trait clear"></div>
					<div class="modal-title-desc clear">
						Vous détenez {{ totalPart | shares }} part<template v-if="totalPart > 1">s</template> de la {{ SCPI }} en {{ TypePro }}. Vous avez réalisé {{ totalTransac  }} transaction<template v-if="totalTransac > 1">s</template> pour cette SCPI.
					</div>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 0" v-if="Object.keys($store.getters.getTransactionsSCPITypeNotCompleted(this.SCPI, this.TypePro)).length > 0">
						<div class="histo_transac">
							<div class="histo_transac_title">
								<img class="pull-left" src="<?= $this->getPath() ?>/img/en-cours-realisation-blanc.svg" width="30px"/>
								<h5>TRANSACTIONS EN COURS</h5>
							</div>
							<table>
								<thead>
									<tr>
										<th style="width: 8%">Type de<br />transaction</th>
										<th style="">Nombre<br />de parts</th>
										<th>Prix<br />par part</th>
										<th>Montant de<br />la transaction</th>
										<th style="width: 50%">État</th>
										<th style="width: 15%">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(transac, key) in $store.getters.getTransactionsSCPITypeNotCompleted(this.SCPI, this.TypePro)" class="histo_transac_data_buy" @click="showTransac(transac.id)">
										<td>
											<template v-if="transac.type_transaction == 'A'">
												ACHAT
											</template>
											<template v-else>VENTE</template>
										</td>
										<td>
											{{ transac.nbr_part | shares }}
										</td>
										<td>
											{{ transac.prix_part | shares_price_eur }}
										</td>
										<td>
											{{ getMontantTransaction(transac.prix_part, transac.nbr_part) | euros }}
										</td>
										<td>
											{{ $store.getters.getStatusTitle(transac.status_trans) }}
										</td>
										<td>
											<button class="details">Voir les détails <img src="<?= $this->getPath() ?>/img/loupe-bleu.png" /></button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row" style="margin: 0" v-if="Object.keys($store.getters.getTransactionsSCPITypeCompleted(this.SCPI, this.TypePro)).length > 0">
						<div class="histo_transac">
							<div class="histo_transac_title">
								<img class="pull-left" src="<?= $this->getPath() ?>/img/fleche-validee-Blanc.png" width="30px" />
								<h5>TRANSACTIONS RÉALISÉES</h5>
							</div>
<template v-for="(trans, key, index) in $store.getters.getPrecalculSCPIType(this.SCPI, this.TypePro)">
							<div v-if="index > 0 && index != Object.keys($store.getters.getPrecalculSCPIType(this.SCPI, this.TypePro)).length" style="padding: 15px">
								<div class="trait"></div>
							</div>
							<table>
								<caption><span>TRANSACTION Nº{{ index + 1 }}</span><img src="<?=$this->getPath()?>img/crayon-inactif@2x.png">Cliquez sur une transaction pour la modifier.</caption>
								<thead>
									<tr>
										<th>Type de<br />transaction</th>
										<th>Date de la<br />transaction</th>
										<th>Nombre<br />de parts</th>
										<th>Prix<br />par part</th>
										<th>Montant de<br />la transaction</th>
										<th>Valeur potentielle<br />de revente</th>
										<th>+ ou - value<br />(en %)</th>
										<th>+ ou - value<br />(en €)</th>
										<th style="width: 18%">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr class="histo_transac_data_buy">
										<td @click="showTransac(trans.buy.id)"> Achat </td>
										<td @click="showTransac(trans.buy.id)">{{ trans.buy.enr_date | date }}</td>
										<td @click="showTransac(trans.buy.id)">{{ trans.buy.nbr_part | shares }}</td>
										<td @click="showTransac(trans.buy.id)">{{ trans.buy.prix_part | shares_price_eur }}</td>
										<td @click="showTransac(trans.buy.id)">{{ getMontantTransaction( trans.buy.prix_part, trans.buy.nbr_part) | euros }}</td>
	<template v-if="!trans.hasOwnProperty('sell') && trans.hasOwnProperty('precalcul')">
										<td @click="showTransac(trans.buy.id)">{{ trans.precalcul.ventePotentielle | euros }}</td>
										<td @click="showTransac(trans.buy.id)">{{ trans.precalcul.plusMoinValuePourcent | signed_percent }}</td>
										<td @click="showTransac(trans.buy.id)">{{ trans.precalcul.plusMoinValueEuro | signed_euros }}</td>
	</template>
	<template v-else>
										<td @click="showTransac(trans.buy.id)">-</td>
										<td @click="showTransac(trans.buy.id)">-</td>
										<td @click="showTransac(trans.buy.id)">-</td>
	</template>
	<template v-if="!trans.hasOwnProperty('sell') && typepro != 'Usu'">
										<td>
											<button class="sell" @click="prepareSellTransaction( trans.buy.id, trans.buy.enr_date, trans.buy.nbr_part, trans.precalcul.prix_actuel)">Vendre <img src="<?= $this->getPath() ?>img/vente-jaune.svg" /></button>
										</td>
	</template>
	<template v-else>
										<td @click="showTransac(trans.buy.id)">-</td>
	</template>
									</tr>
	<template v-if="trans.hasOwnProperty('sell')">
									<tr class="histo_transac_data_sell" v-for="trans_sell in trans.sell">
										<td @click="showTransac(trans_sell.id)"> Vente </td>
										<td @click="showTransac(trans_sell.id)">{{ trans_sell.enr_date | date }}</td>
										<td @click="showTransac(trans_sell.id)">{{ trans_sell.nbr_part_vente | shares }}</td>
										<td @click="showTransac(trans_sell.id)">{{ trans_sell.prix_part_vente | shares_price_eur }}</td>
										<td @click="showTransac(trans_sell.id)">{{ getMontantTransaction( trans_sell.prix_part_vente, trans_sell.nbr_part_vente) | euros }}</td>
										<td @click="showTransac(trans_sell.id)">-</td>
										<td @click="showTransac(trans_sell.id)">{{ trans_sell.plusMoinValuePourcent | signed_percent  }}</td>
										<td @click="showTransac(trans_sell.id)">{{ trans_sell.plusMoinValueEuro | signed_euros }}</td>
										<td @click="showTransac(trans_sell.id)">-</td>
									</tr>
		<template v-if="trans.hasOwnProperty('precalcul')">
									<tr class="histo_transac_data_precalcul">
										<td>Sous-total</td>
										<td>-</td>
										<td>{{ trans.precalcul.nbr_part | shares }}</td>
										<td>{{ trans.precalcul.prix_part | shares_price_eur }}</td>
										<td>{{ getMontantTransaction( trans.sell.prix_part, trans.precalcul.nbr_part, trans.sell.nbr_part) | euros }}</td>
										<td>{{ trans.precalcul.ventePotentielle | euros }}</td>
										<td>{{ trans.precalcul.plusMoinValuePourcent | signed_percent }}</td>
										<td>{{ trans.precalcul.plusMoinValueEuro | signed_euros }}</td>
										<td>
											<button v-if="(typepro != 'Usu' && trans.precalcul.nbr_part != 0)" class="sell" @click="prepareSellTransaction( trans.buy.id, trans.buy.enr_date, trans.precalcul.nbr_part, trans.precalcul.prix_actuel)">Vendre <img src="<?= $this->getPath() ?>img/vente-jaune.svg" /></button>
											<template v-else>-</template>
										</td>
									</tr>
		</template>
	</template>
								</tbody>
							</table>
</template>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<button class="bttn-mscpi-plainorange" data-dismiss="modal" aria-label="Close">
						FERMER
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/x-template" id="transac_sell">
<div>
	<div class="modal fade modal_transac_sell" tabindex="-1" role="dialog" aria-labelledby="modal_transac_sell">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-right" aria-label="Close" data-dismiss="modal">
						<img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" />
					</button>
					<div class="text-center">
						<span class="modal-title">CESSION DE PARTS</span>
					</div>
					<div class="trait" style="margin: 15px auto"></div>
				</div>
				<div class="modal-body">
					<div class="row text-center">
						J’ai cédé <input type="text" v-model="$store.state.transactions.transactionSell.nbr_part_sell"> parts de la <span class="modal_title_sell">{{ $store.state.transactions.transactionSell.sell_scpi }}</span>
					</div>
					<div class="row text-center"><div class="form-inline"><div class="form-group"> le <my-datepicker id="sell_part" v-model="$store.state.transactions.transactionSell.date_sell" ></my-datepicker>
						au prix unitaire <span style="font-weight: bold">net vendeur</span> de <input type="text" v-model="$store.state.transactions.transactionSell.prix_part_sell" style="width: 110px"> euros.</div></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-mscpi" data-dismiss="modal">ANNULER</button>
					<input type="submit" class="btn-mscpi btn-orange" @click="modalToOpen" value="VALIDER" />
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script type="text/javascript">
	Vue.component('transac-sell',{
		methods:{
			modalToOpen: function()
			{
				if (this.$store.state.transactions.transactionSell != null)
				{
					this.$store.dispatch('TRANSACTIONS_SELL', this.$store.state.transactions.transactionSell)
					.then( function(res) {
						if (this.modal_to_open != '')
							setTimeout(function() { $( this.modal_to_open ).modal('show') }, 500);
						$('.modal_transac_sell').modal('hide');
					}, function(res) {
						if (typeof res.body.err != 'undefined')
							msgBox.show(res.body.err);
					})
				}
			}
		},
		template: '#transac_sell'
	});
</script>
<script type="text/javascript">
	Vue.component('historique-transaction',
	{
		props: ['idmodal','nomscpi', 'typepro'],
		computed: {
			myIdModal: function() {
				return "modal_histotransac_" + this.idmodal;
			},
			modalDel: function()
			{
				return ".modal_del" + this.idmodal;
			},
			SCPI: function() {
				return this.nomscpi;
			},
			TypePro: function() {
				if (this.typepro == "Pleine")
					return "Pleine Propriété";
				if (this.typepro == "Usu")
					return "Usufruit";
				if (this.typepro == "Nue")
					return "Nue-propriété";
			},
			totalPart: function() {
				if (typeof this.TypePro == 'undefined')
					return 0;
				var totPart = 0;
				var trNotCompleted = this.$store.getters.getTransactionsSCPITypeNotCompleted(this.SCPI, this.TypePro);

				if (typeof trNotCompleted.length != 'undefined' && trNotCompleted.length > 0)
				{
					for (var tr in trNotCompleted)
					{ totPart += Number(trNotCompleted[tr].nbr_part); }
				}

				//var precalcul = this.$store.getters.getPrecalculSCPIType(this.SCPI, this.TypePro);
				var precalcul = this.$store.getters.getTransactionsSCPITypeCompleted(this.SCPI, this.TypePro);

				if (!Array.isArray(precalcul))
				{
					for (var tr in precalcul)
					{ totPart += Number(precalcul[tr].precalcul.nbr_part); }
				}
				return totPart;
			},
			totalTransac: function() {
				return Object.keys(this.$store.getters.getTransactionsSCPITypeNotCompleted(this.SCPI, this.TypePro)).length + Object.keys(this.$store.getters.getTransactionsSCPITypeCompleted(this.SCPI, this.TypePro)).length;
				//return Object.keys(this.$store.getters.getTransactionsSCPITypeNotCompleted(this.SCPI, this.TypePro)).length + Object.keys(this.$store.getters.getPrecalculSCPIType(this.SCPI, this.TypePro)).length;
			}
		},
		methods: {
			getMontantTransaction: function( nbr_part, prix_part )
			{
				if (parseFloat(nbr_part) > 0 && parseFloat(prix_part) > 0)
					return (parseFloat(nbr_part) * parseFloat(prix_part));
				return '-';
			},
			showTransac: function( id_transac )
			{
				this.$store.dispatch('TRANSACTIONS_READ', {'id': id_transac}).then(
					function() {
						$('#modal_transactio').modal('show');
					}
				);
			},
			prepareSellTransaction: function( trans_id, date, parts_restantes, prix_actuel ) {
				if (date == null)
					date = 0;

				this.$store.state.transactions.transactionSell = {
					'transaction_id': trans_id,
					'sell_scpi': this.SCPI + " - " + this.TypePro, 
					'date_sell': date,
					'prix_part_sell': prix_actuel.toFixed(5),
					'nbr_part_sell': parts_restantes,
					'modal_to_open': ''
				};
				$('.modal_transac_sell').modal('show');
			}
		},
		mounted: function()
		{
			$('#' + this.myIdModal).modal('handleUpdate');
		},
		template: '#histo_transac'
	});

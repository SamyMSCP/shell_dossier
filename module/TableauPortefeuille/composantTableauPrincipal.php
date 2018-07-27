</script></script>
<script type="text/x-template" id="tableau_portefeuille_principal_component">
	<div>
		<div class='tableauPortefeuilleTitre'>
			<div>
				{{ getTypePro }}
			</div>
			<div class='sousTotal'>
				SOUS-TOTAL : {{ getCache.precalcul["ventePotentielle" + type_pro ] | euros }}
			</div>
		</div>
		<table class='tablePortefeuille'>
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>
						<tooltip content="C’est la dénomination précise de la SCPI, comme indiqué dans les statuts de la SCPI.">
							Nom de la SCPI
						</tooltip>
					</th>
					<th class="cacher3">
						<tooltip size="big" content="C’est la date à laquelle a été réalisée votre souscription.">
							Date d'enregistrement
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro == "Pleine"'>
						<tooltip content="Il s’agit de savoir si votre souscription a été réalisée sur le marché primaire ou secondaire.">
							Marché 
						</tooltip>
					</th>
					<th class="cacher3">
						<tooltip content="C’est le nombre de parts de SCPI que vous avez souscrit dans le cadre de cette souscription.">
							Nombre de parts 
						</tooltip>
					</th>
					<th class="cacher3" v-if='type_pro != "Pleine"'>
						<tooltip content="Dans le cadre d’une souscription en démembrement, le prix de souscription des parts de SCPI est réparti entre le nu-propriétaire et l’usufruitier. Cette répartition se fait selon des clés de valeurs. Ces clés de valeurs varient en fonction de la durée du démembrement et du rendement prévisionnel de la SCPI sur cette même période.">
							Clé de répartition
						</tooltip>
					</th>
					<th class="cacher3">
						<tooltip content="C’est le prix unitaire par part, payé au moment de la souscription ou vendu.">
							Prix par part 
						</tooltip>
					</th>
					<th class="cacher2">
						<tooltip content="Ce montant se calcul de la manière suivante : Nombre de parts X Prix par parts au moment de la souscription X Clé de répartition.">
							Montant de la transaction 
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro == "Nue"'>
						<tooltip content="Dans le cadre d’une souscriptions en démembrement temporaire, il existe une durée rattachée à ce démembrement. À la fin de cette période, la nu-propriétaire récupère la pleine jouissance des parts de SCPI, c’est la date de fin de démembrement indiquée dans votre convention de démembrement temporaire.">
							Date de recouvrement de pleine propriété 
						</tooltip>
					</th>
					<th v-if='type_pro == "Pleine"'>
						<tooltip content="Ce montant se calcul de la manière suivante : Nombre de parts X Valeur de retrait par parts. On utilise la dernière valeur de retrait de la SCPI.">
							Valeur potentielle de revente 
						</tooltip>
					</th>
					<th v-else-if='type_pro == "Nue"'>
						<tooltip content="Au même titre que la pleine propriété, la nue-propriété est valorisée. La valorisation est faite en fonction de la valeur de retrait actuelle par parts, en prenant en compte la durée du démembrement (notamment la durée restante avant le recouvrement de la pleine propriété).">
							Valorisation nue propriété estimée 
						</tooltip>
					</th>
					<th v-else-if='type_pro == "Usu"'>
						<tooltip content="Au même titre que la pleine propriété, l‘usufruit est valorisé. La valorisation est faite en fonction de la valeur actuelle de retrait par parts, en prenant en compte la durée du démembrement (notamment la durée restante avant le recouvrement de la pleine propriété).">
							Valorisation usufruit 
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro != "Usu"'>
						<tooltip content="C’est la différence entre le montant de la transaction et la valorisation nue-propriété estimée. Cette différence est exprimée en pourcentage.">
							+ ou - value 
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro == "Pleine"'>
						<tooltip content="Ce sont les  dividendes annuels que vous recevez, par rapport au montant de la souscription, exprimés en pourcentage.">
							TDVS
						</tooltip>
					</th>
					<th class="cacher2" v-if='type_pro == "Pleine"'>
						<tooltip content="C’est le montant total de dividende reçu depuis l’année en cours, relatif à votre souscription.">
							Dividende 2017
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro == "Nue"'>
						<tooltip content="Ce montant se calcul de la manière suivante : Nombre de parts X Valeur de retrait par parts actuelle. On utilise la dernière valeur de retrait de la SCPI.">
							Valeur potentielle de revente PP
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro == "Usu"'>
						<tooltip content="Dans le cadre d’une souscriptions en démembrement temporaire, il existe une durée rattachée à ce démembrement. À la fin de cette période, l’usufruitier ne dispose plus d’aucuns droits sur ces parts de SCPI (ne touche plus les dividendes), c’est la date de fin de démembrement indiquée dans votre convention de démembrement temporaire. ">
							Date d'extinction usufruit 
						</tooltip>
					</th>
					<th class="cacher1" v-if='type_pro == "Usu"'>
						<tooltip content="C’est le montant cumulé de tous les dividendes perçus par l’usufruitier dans le cadre de cette souscription.">
							Dividendes perçus 
						</tooltip>
					</th>
					<th v-if='type_pro == "Usu" && false'>
						<tooltip title="Nom de la SCPI" size="big" content="Nom de la SCPI">
							Estimation des dividendes restants à toucher 
						</tooltip>
					</th>
				</tr>
			</thead>
			<tbody>

				<template v-for='(elm, key) in getCache'>
					<template v-for='(elm1, key1) in elm' v-if='key != "precalcul"'>
						<template v-for='(elm2, key2) in elm1' v-if='key1 != "precalcul" && ((elm2.buy.non_pp_fin_demembrement == 0 &&  type_pro == "Nue" && key1 == type_pro) || (type_pro == "Pleine" && elm2.buy.non_pp_fin_demembrement == 1 && (key1 == "Nue" || key1 == "Pleine")) || (type_pro == "Usu" && key1 == type_pro ))'>
							<tr v-if="elm2.buy.non_pp_fin_demembrement == 1 &&  type_pro == 'Usu'"  style="background-color:lightgrey; cursor: pointer" title=" Cette Usufruit est terminée" @click='setTransactionIntermediaire(key2, elm2)' class='editable'>
								<td><i v-if="elm2.buy.non_pp_fin_demembrement==1 && elm2.buy.type_pro != 'Pleine propriété'" class="fa fa-star text-primary" aria-hidden="true" data-toggle="tooltip" title="Il s'agit ici d'une transaction Usufruit arrivee a terme."></i> </td>
								<td v-if="elm2.buy.doByMscpi"><img class="icon-tableau" src="/assets/mscpi_icon/ms-logo-miniature.svg" title="Il s'agit ici d'une transaction MSCPI."></td>
								<td v-else></td>
								<td style="width: 5%;"> <img  class="icon-tableau" src="/assets/CP-Fleche-GrisFonce.svg" @click.stop='toggle(key2)'  v-if='typeof elm2.sell != "undefined" && getShow(key2) == false' > <img class="icon-tableau-ok"  src="/assets/CP-Fleche-GrisFonce.svg" style="transform: rotate(90deg);" @click.stop='toggle(key2)' v-else-if="getShow(key2)"/> </td>
								<td> {{ key }} </td>
								<td  class="cacher3">{{ elm2.buy.enr_date | date }}</td>
								<td class="cacher1" v-if='type_pro == "Pleine"'>{{ elm2.buy.marche }}</td>
								<td  class="cacher3" v-if='typeof elm2.sell == "undefined"'> {{ (elm2.buy.nbr_part > 0) ? elm2.buy.nbr_part : '-'}} </td>
								<td  class="cacher3" v-if='typeof elm2.sell != "undefined"'> {{ elm2.precalcul.nbr_part}} </td>
								<td class="cacher3" v-if='type_pro != "Pleine"'>{{ (elm2.buy.cle_repartition > 0) ? elm2.buy.cle_repartition : '-' | pourcent }} </td>
								<td class="cacher3"> {{ (elm2.buy.prix_part > 0) ? elm2.buy.prix_part : '-' | euros}}</td>
								<td class="cacher2"> {{ (elm2.precalcul.MontantInvestissement > 0) ? elm2.precalcul.MontantInvestissement : '-' | euros}}</td>
								<td class="cacher2" v-if='type_pro == "Nue"'>{{ (elm2.buy.debut_dividendes != null) ? elm2.buy.debut_dividendes : '-' | date }}</td>
								<td > {{ (elm2.precalcul.ventePotentielle > 0) ? elm2.precalcul.ventePotentielle : '-' | euros}}</td>
								<td class="cacher1" v-if='type_pro != "Usu"'> {{ elm2.precalcul.plusMoinValueEuro | euros }}</td>
								<td class="cacher1" v-if='type_pro == "Pleine"'> {{ (elm2.precalcul.TDVS > 0) ? elm2.precalcul.TDVS * 100 : '-' | pourcent }}</td>
								<td class="cacher2" v-if='type_pro == "Pleine"'> {{ (elm2.precalcul.lastDividendes > 0) ? elm2.precalcul.lastDividendes : '-' | euros}}</td>
								<td class="cacher1" v-if='type_pro == "Nue"'>{{ elm2.precalcul.ventePotentiellePleinPro | euros }}</td>
								<td class="cacher1" v-if='type_pro == "Usu"'>{{ (elm2.buy.fin_valorisation != null) ? elm2.buy.fin_valorisation : '-' | date }}</td>
								<td class="cacher1" v-if='type_pro == "Usu"'> {{ (elm2.precalcul.dividendes_percu != null) ? elm2.precalcul.dividendes_percu : '-' | euros }}</td>
								<td v-if='type_pro == "Usu" && false' style='color:red;'>????????????????????</td>
							</tr>
							<tr v-else @click='setTransactionIntermediaire(key2, elm2)' class='editable'>
								<td><i v-if="elm2.buy.non_pp_fin_demembrement==1 && elm2.buy.type_pro != 'Pleine propriété'" class="fa fa-star text-primary" style="color: red" aria-hidden="true" data-toggle="tooltip" title="Il s'agit ici d'une transaction Nue propriete arrivee a terme."></i> </td>
								<td v-if="elm2.buy.doByMscpi"><img class="icon-tableau" src="/assets/mscpi_icon/ms-logo-miniature.svg" title="Il s'agit ici d'une transaction MSCPI."></td>
								<td v-else></td>
								<td style="width: 5%;"> <img  class="icon-tableau" src="/assets/CP-Fleche-GrisFonce.svg" @click.stop='toggle(key2)'  v-if='typeof elm2.sell != "undefined" && getShow(key2) == false' > <img class="icon-tableau-ok"  src="/assets/CP-Fleche-GrisFonce.svg" style="transform: rotate(90deg);" @click.stop='toggle(key2)' v-else-if="getShow(key2)"/> </td>
								<td> {{ key }} </td>
								<td  class="cacher3">{{ elm2.buy.enr_date | date }}</td>
								<td class="cacher1" v-if='type_pro == "Pleine"'>{{ elm2.buy.marche }}</td>
								<td class="cacher3" v-if='typeof elm2.sell == "undefined"'> {{ (elm2.buy.nbr_part > 0) ? elm2.buy.nbr_part : '-'}} </td>
								<td class="cacher3" v-if='typeof elm2.sell != "undefined"'> {{ elm2.precalcul.nbr_part}} </td>
								<td class="cacher3" v-if='type_pro != "Pleine"'>{{ (elm2.buy.cle_repartition > 0) ? elm2.buy.cle_repartition : '-' | pourcent }} </td>
								<td class="cacher3"> {{ (elm2.buy.prix_part > 0) ? elm2.buy.prix_part : '-' | euros}}</td>
								<td class="cacher2"> {{ (elm2.precalcul.MontantInvestissement > 0) ? elm2.precalcul.MontantInvestissement : '-' | euros}}</td>
								<td class="cacher1" v-if='type_pro == "Nue"'>{{ (elm2.buy.debut_dividendes != null) ? elm2.buy.debut_dividendes : '-' | date }}</td>
								<td > {{ (elm2.precalcul.ventePotentielle > 0) ? elm2.precalcul.ventePotentielle : '-' | euros}}</td>
								<td class="cacher1" v-if='type_pro != "Usu"'> {{ elm2.precalcul.plusMoinValueEuro | euros }}</td>
								<td class="cacher1" v-if='type_pro == "Pleine"'> {{ (elm2.precalcul.TDVS > 0) ? elm2.precalcul.TDVS * 100 : '-' | pourcent }}</td>
								<td class="cacher2" v-if='type_pro == "Pleine"'> {{ (elm2.precalcul.lastDividendes > 0) ? elm2.precalcul.lastDividendes : '-' | euros}}</td>
								<td class="cacher1" v-if='type_pro == "Nue"'>{{ elm2.precalcul.ventePotentiellePleinPro | euros }}</td>
								<td class="cacher1" v-if='type_pro == "Usu"'>{{ (elm2.buy.fin_valorisation != null) ? elm2.buy.fin_valorisation : '-' | date }}</td>
								<td class="cacher1" v-if='type_pro == "Usu"'> {{ (elm2.precalcul.dividendes_percu != null) ? elm2.precalcul.dividendes_percu : '-' | euros }}</td>
								<td v-if='type_pro == "Usu" && false' style='color:red;'>????????????????????</td>
							</tr>
							<template v-if='typeof elm2.sell != "undefined" && getShow(key2)'>

								<tr class='small editable' @click.stop='setTransaction(key2)'>
									<td colspan="3"></td>
									<td>Acquisition</td>
									<td  class="cacher3">{{ elm2.buy.enr_date | date }}</td>
									<td class="cacher1" v-if='type_pro == "Pleine"'></td>
									<td class="cacher3"> {{ elm2.buy.nbr_part }} </td>
									<td class="cacher3" v-if='type_pro != "Pleine"'>{{ (elm2.buy.cle_repartition > 0) ? elm2.buy.cle_repartition : '-' | pourcent }} </td>
									<td class="cacher3"> {{ elm2.buy.prix_part | euros }} </td>
									<td class="cacher2"> {{ elm2.buy.MontantInvestissement | euros }} </td>
									<td class="cacher1" v-if='type_pro == "Nue"'></td>
									<td class="cacher2"></td>
									<td class="cacher1" v-if='type_pro != "Usu"'></td>
									<td class="cacher1" v-if='type_pro == "Pleine"'></td>
									<td class="cacher2" v-if='type_pro == "Pleine"'></td>
									<td class="cacher1" v-if='type_pro == "Nue"'></td>
									<td class="cacher1" v-if='type_pro == "Usu"'></td>
									<td class="cacher1" v-if='type_pro == "Usu"'>Dividendes perçus</td>
									<td v-if='type_pro == "Usu"'>Estimation des dividendes restants à toucher</td>
								</tr>

								<tr  v-for='(elm3, key3) in elm2.sell' class='small editable' @click.stop='setTransaction(key3)'>
									<td colspan="3"></td>
									<td>Cession</td>
									<td  class="cacher3">{{ elm3.enr_date | date }}</td>
									<td class="cacher1" v-if='type_pro == "Pleine"'></td>
									<td class="cacher3"> {{ elm3.nbr_part_vente }} </td>
									<td class="cacher3" v-if='type_pro != "Pleine"'>{{ (elm3.cle_repartition > 0) ? elm3.cle_repartition : '-' | pourcent }} </td>
									<td class="cacher3"> {{ elm3.prix_part_vente | euros }} </td>
									<td class="cacher2"> {{ elm3.MontantRevente | euros }} </td>
									<td class="cacher1" v-if='type_pro == "Nue"'></td>
									<td class="cacher2"></td>
									<td class="cacher1" v-if='type_pro != "Usu"'></td>
									<td class="cacher1" v-if='type_pro == "Pleine"'></td>
									<td class="cacher2" v-if='type_pro == "Pleine"'></td>
									<td class="cacher1" v-if='type_pro == "Nue"'></td>
									<td class="cacher1" v-if='type_pro == "Usu"'></td>
									<td class="cacher1" v-if='type_pro == "Usu"'>Dividendes perçus</td>
									<td v-if='type_pro == "Usu"'>Estimation des dividendes restants à toucher</td>
								</tr>
							</template>
						</template>
					</template>
				</template>
			</tbody>
		</table>
	</div>
</script>
<script>
	Vue.component(
		'tableau-portefeuille-principal', {
			data: function() {
				return ({
					id:{},
				});
			},
			props: [
				"type_pro"
			],
			computed: {
				getTypePro: function() {
					if (this.type_pro == "Pleine")
						return ("PLEINE PROPRIÉTÉ");
					else if (this.type_pro == "Nue")
						return ("NUE PROPRIÉTÉ");
					else if (this.type_pro == "Usu")
						return ("USUFRUIT");
					return ("-");
				},
				getCache: function(){
					return(this.$store.state.dh.precalcul);
				},

				getShow: function () {
					return function (id) {
						if (typeof this.id[id] == "undefined"){
							return false;
						}

						return this.id[id];
					}
				}
			},

			methods: {
				setTransaction: function(idTransaction) {
					this.$store.dispatch('SET_SELECTED_TRANSACTION', idTransaction)
					$('#tableau-transaction-edit-modal').modal('show')

				},

				setTransactionIntermediaire: function(idTransaction, data) {
					this.$store.dispatch('SET_SELECTED_TRANSACTION', idTransaction)
					this.$store.state.transactions.selectedTransactionIntermediaire=data
					if('sell' in data){
						$('#tableau-transaction-intermediaire-modal').modal('show')
					}
					else{
						$('#tableau-transaction-edit-modal').modal('show')
					}
				},
				toggle: function(id) {
					if (typeof this.id[id] == "undefined") {
						this.$set(this.id, id, false);
					}
					this.$set(this.id, id, !this.id[id]);
					//this.$set(this.id, id, !this.id[id]);
					//this.id[id] != this.id[id]
				},

			},
			template: "#tableau_portefeuille_principal_component"
		}
	);


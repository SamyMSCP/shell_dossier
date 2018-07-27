</script>
<script type="text/x-template" id="tableau_portefeuille_principal_potentielles_component">
	<div>
		<div class='tableauPortefeuilleTitre'>
			<div v-if='getTypePro=== "USUFRUIT"'>
				{{ getTypePro }} POTENTIEL
			</div>
            <div v-else>
                {{ getTypePro }} POTENTIELLE
            </div>
		</div>
		<table class='tablePortefeuille'>
			<thead>
				<tr>
					<th><tooltip content="C’est la dénomination précise de la SCPI, comme indiqué dans les statuts de la SCPI.">Nom de la SCPI</tooltip></th>
					<th><tooltip content="c’est le nombre de parts de SCPI que vous avez souscrit dans le cadre de cette souscription.">Nombre de parts</tooltip></th>
					<th class="cacher2" v-if='type_pro != "Pleine"'><tooltip content="Dans le cadre d’une souscription en démembrement, le prix de souscription des parts de SCPI est réparti entre le nu-propriétaire et l’usufruitier. Cette répartition se fait selon des clés de valeurs. Ces clés de valeurs varient en fonction de la durée du démembrement et du rendement prévisionnel de la SCPI sur cette même période.">Clé de répartition</tooltip></th>
					<th class="cacher2" v-if='type_pro != "Pleine"'><tooltip content=" Dans le cadre d’une souscriptions en démembrement temporaire, il existe une durée rattachée à ce démembrement. ">Durée du démembrement</tooltip></th>
					<th><tooltip content="C’est le prix de la part en pleine propriété au moment de la souscription.">Prix d'achat par part</tooltip></th>
					<th class="cacher2"><tooltip content="Ce montant se calcul de la manière suivante : Nombre de parts X Prix par parts au moment de la souscription X Clé de répartition.">Montant de la transaction</tooltip></th>
					<th class="cacher2" v-if='type_pro == "Nue"'><tooltip content="Ce montant se calcul de la manière suivante : Nombre de parts X Valeur de retrait par parts actuelle. On utilise la dernière valeur de retrait de la SCPI.">Valeur potentielle de revente PP</tooltip></th>
				</tr>
			</thead>
			<tbody>
				<tr v-for='(elm, key) in getDatas'>
						<td>{{ elm.scpi }}</td>
						<td>{{ elm.nbr_part }}</td>
						<td class="cacher2" v-if='type_pro != "Pleine"'>{{ elm.cle_repartition }}</td>
						<td class="cacher2" v-if='type_pro != "Pleine"'>{{ elm.demembrement }}</td>
						<td>{{ elm.prix_part | euros }}</td>
						<td class="cacher2">{{ elm.MontantInvestissement | euros }}</td>
						<td class="cacher2" v-if='type_pro == "Nue"'>{{ elm.ventePotentiellePleinPro | euros }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</script>
<script>
	Vue.component(
		'tableau-portefeuille-principal-potentielles', {
			data: function() {
				return ({});
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
				getDatas: function() {
					return(this.$store.getters['getTransactionPotentielles' + this.type_pro]);
				}
			},
			template: "#tableau_portefeuille_principal_potentielles_component"
		}
	);


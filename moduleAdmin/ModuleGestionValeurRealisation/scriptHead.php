</script>

<script type="text/x-template" id="gestion-valeur-realisation">
	<div>
		<button class="btn-mscpi">Regenerer le cache</button>
		<table border="1" class="tableScpi">
			<thead>
				<tr>
					<th>Id scpi</th>
					<th>Nom scpi</th>
					<th>Dernière de vente</th>
					<th>Valeur de realisation</th>
					<th>Valeur manuelle</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(scpi, key) in sortedScpi">
					<td>{{scpi.data.id}}</td>
					<td>{{scpi.data.name}}</td>
					<td>{{scpi.data.prix_vendeur}}</td>
					<td>{{scpi.data.ValeurRealisation}}</td>
					<td>
						<input type="number" v-model="sortedScpi[key].value" v-on:keyup="setValueChange(key, this.event)" step="0.01" min="0"/>
						<button @click="updateValue(key)" class="btn-mscpi" v-if="sortedScpi[key].changed">Enregistrer</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</script>

<script type="text/javascript" charset="utf-8">

function ScpiStore() {
	var that = this;
	this.lstScpi = <?=json_encode($this->temoin)?>;
	return (this);
}

var myScpiStore = new ScpiStore();

Vue.component(
	'tableValeurRealisation',
	{
		data: function() {
			return (myScpiStore);
		},
		template: '#gestion-valeur-realisation',
		methods: {
			'setValueChange': function(id, e) {
				if (e.target.value != this.sortedScpi[id].value_base)
					this.lstScpi[id].changed = true;
				else
					this.lstScpi[id].changed = false;
			},
			'updateValue': function(id) {
				var id_scpi = this.sortedScpi[id].data.id;
				var newValue = this.sortedScpi[id].value;
				this.$http.post('ajax_request.php', {
					req: 'ValeurRealisation',
					data: {
						req: 'update',
						id_scpi: id_scpi,
						value: newValue
					},
					token: "<?=$_SESSION['csrf'][0]?>"
				}, {emulateJSON: true}).then(
					function (res) {
						this.lstScpi = this.lstScpi.map(function(elm) {
							if (elm.data.id == res.body.id_scpi)
							{
								elm.value = res.body.value;
								elm.value_base = res.body.value;
								elm.changed = false;
							}
							return (elm);
						});
						//console.log(elm.data.id);
						//console.log(res.body.id);
						console.log(res.body);
						//msgBox.show("Valeur de réalisation mise a jours !");
					},
					function (res) {
						msgBox.show("La nouvelle valeur n'a pas pu etre enregistrée ! Désolé :(");
					}
				);
				return ;
			}
		},
		computed: {
			sortedScpi: function() {
				var that = this;
				return (this.lstScpi.sort(function(a, b) {
					return (String(a.data.name).localeCompare(String(b.data.name)));
				}));
			}
		}
	}
);

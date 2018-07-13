</script>
<script type="text/javascript" charset="utf-8">

function DelaiJouissanceStore() {
	var that = this;
	this.DJDatas = {};
	this.getDJForScpi = function(id_scpi) {
		if (!this.DJDatas.hasOwnProperty(id_scpi))
		// Si on a pas les delais de jouissance pour un scpi alors on les recupere dans DJDatas
		{
			this.$http.post('ajax_request.php', {
				req: 'DelaiJouissance',
				data: {
					req: 'get',
					id_scpi: id_scpi
					},
				token: "<?=$_SESSION['csrf'][0]?>"
			}, {emulateJSON: true}).then(
				function (res) {
					Vue.set(that.DJDatas, id_scpi, res.body);
					$('#modalDelaiJouissance').modal('show');
					that.selectedScpi = JSON.parse(JSON.stringify(that.DJDatas[id_scpi]));
				},
				function (res) {
					console.log('bug');
					msgBox.show("Les informations de delai de jouissance ne sont pas accessibles.");
				}
			);
		}
		else
		{
			$('#modalDelaiJouissance').modal('show');
			that.selectedScpi = that.DJDatas[id_scpi];
		}
	};
	this.createNewDelaiJouissance = function() {
		return ({
			id: 0,
			id_scpi: this.selectedScpiId,
			value: 1,
			unite: 0,
			value_vente: 1,
			unite_vente: 0,
			date_execution: Number.parseInt(moment().format('X'))
		});
	};
	this.removeOne = function(id) {
		this.$http.post('ajax_request.php', {
			req: 'DelaiJouissance',
			data: {
				req: 'delete',
				id_scpi: that.selectedScpiId,
				id: id
				},
			token: "<?=$_SESSION['csrf'][0]?>"
		}, {emulateJSON: true}).then(
			function (res) {
				Vue.set(that.DJDatas, that.selectedScpiId, res.body);
				//that.selectedScpi = JSON.parse(JSON.stringify(that.DJDatas[that.selectedScpiId]));
				that.selectedScpi = that.selectedScpi.filter(function(elm) {
					return (elm.id != id)
				});
			},
			function (res) {
				msgBox.show("La suppression à echoué !.");
			}
		);
	};
	this.saveSelected = function() {
		this.$http.post('ajax_request.php', {
			req: 'DelaiJouissance',
			data: {
				req: 'save',
				id_scpi: that.selectedScpiId,
				lst: that.selectedScpi
				},
			token: "<?=$_SESSION['csrf'][0]?>"
		}, {emulateJSON: true}).then(
			function (res) {
				Vue.set(that.DJDatas, that.selectedScpiId, res.body);
				$('#modalDelaiJouissance').modal('hide');
				//msgBox.show("Les modifications ont bien été enregistrées.");
			},
			function (res) {
				msgBox.show("Les modifications n'ont pas pu etre enregistrées.");
			}
		);
	};
	this.selectedScpi = {};
	this.selectedScpiId = 0;
	this.selectedScpiName = "";
}

var myDelaiJouissanceStore= new DelaiJouissanceStore();

Vue.component(
	'btnEditDelaiJouissance',
	{
		props: ['scpiId', 'scpiName'],
		data: function() {
			return (myDelaiJouissanceStore);
		},
		template: `
			<button class="btn-mscpi" @click="editDelaiJouissance()">Editer</button>
		`,
		methods: {
			editDelaiJouissance: function () {
				this.getDJForScpi(this.scpiId);
				this.selectedScpiName = this.scpiName;
				this.selectedScpiId = this.scpiId;
			},
		}
	}
);

Vue.component(
	'modalDelaiJouissance',
	{
		data: function() {
			return (myDelaiJouissanceStore);
		},
		template :`
			<div class="modal fade" id="modalDelaiJouissance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" style="min-width: 1280px;">
					<div class="modal-content">
						<div class="modal-body">
							<h2>{{selectedScpiName}}</h2>
							<div class="traitOrange"></div>
							<table border="0" style="width:100%;" class="tableModalDJ">
								<thead>
									<tr>
										<th colspan="2">Delai Entrée en jouissance</th>
										<th colspan="2">Delai sortie de jouissance</th>
										<th>Date</th>
										<th>Supprimer</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(DJData, key) in selectedScpi">
										<td><input min="0"type="number" class="form-control" v-model="DJData.value"></td>
										<td>
											<my-select v-model="DJData.unite">
												<option value="0">mois</option>
												<option value="1">trimestres</option>
												<option value="2">semestres</option>
											</my-select>
										</td>
										<td><input min="0" type="number" class="form-control" v-model="DJData.value_vente"></td>
										<td>
											<my-select v-model="DJData.unite_vente">
												<option value="0">mois</option>
												<option value="1">trimestres</option>
												<option value="2">semestres</option>
											</my-select>
										</td>
										<td><my-datepicker :id="'datePicker_' + key" v-model="DJData.date_execution"></my-datepicker></td>
										<td><img @click="removeDJ(DJData.id)" src="<?=$this->getPath()?>img/BTN-Close-01.png"/></td>
									</tr>
								</tbody>
							</table>
							<div class="blockBtn">
								<button @click="addNew" class="btn-mscpi">Ajouter</button>
								<button @click="save" class="btn-mscpi btn-orange">Sauvegarder</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		`,
		computed: {
		},
		methods: {
			addNew: function() {
				this.selectedScpi.push(this.createNewDelaiJouissance());
			},
			save: function() {
				this.saveSelected();
			},
			removeDJ: function(id) {
				var that = this;
				msgBox.show("Voulez vous vraiment supprimer cette ligne ?",[
					{
						text: "Oui",
						action: function() {
							that.removeOne(id);
						}
					},
					{
						text: "Non",
						action: function() {}
					},
				]);
			}
		}
	}
);

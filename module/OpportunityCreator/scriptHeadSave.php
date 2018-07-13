</script>
<script type="text/x-template" id="moduleOpportunityCreator">
	<div>
		<div class="container-fluid form-inline">
			<div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12">
				<div class="row">
					<div class="form-group">
						Je souhaite investir en
						<select  v-model="m_type" class="inline">
							<option value="0">Nue Propri&eacute;t&eacute;</option>
							<option value="1">Usufruit</option>
						</select>
						en d&eacute;menbrement pour une dur&eacute;e de
						<input type="number" min="3" max="20" v-model="dem" class="form-control input-sm inline"/> ans
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						dans la SCPI
						<select v-model="m_scpi" @change="update_price">
							<option v-for="line in scpiList" v-bind:value="line.id">{{line.name}}</option>
						</select>
						avec une cl&eacute; de r&eacute;partition de
						<div class="input-group" style="float: right">
							<input type="number" step="0.01" min="50" max="100" v-model="crnp" @change="update_crnp" class="form-control input-sm inline"/>
							<span class="input-group-addon colorized">%</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						pour le nu-propri&eacute;taire et
						<div class="input-group" style="float: right">
							<input type="number" step="0.01" min="0" max="50" v-model="cru" @change="update_cru" class="form-control input-sm inline"/>
							<span class="input-group-addon colorized">%</span>
						</div>
						pour l'usufruitier.
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						Je souhaite investir dans <input type="number" min="1" v-model="nb_part" @change="update_all" @blur="update_all"/> part(s) dont le prix pleine propriet&eacute; est de
						<div class="input-group">
							<input type="number" class="form-control input-sm inline" step="0.01" min="0" v-model="price_per_part" @change="update_all" @blur="update_all"/>
							<span class="input-group-addon colorized">&euro;</span>
						</div>
					</div>
				</div>
			<div class="row">
				<div class="form-group">
					soit un investissement de <span class="price">{{montantNuFixed}} &euro;</span> pour le nu-propri&eacute;taire et de
					<span class="price">{{montantUsuFixed}} &euro;</span> pour l'usufruitier.
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<select v-model="partial">
						<option value="1" selected="">J'accepte</option>
						<option value="0">Je ne souhaite pas</option>
					</select> que ma souscription soit faite en plusieurs fois.
				</div>
			</div>
		</div>
		</div>
		<div class="container-fluid">
			<button class=" col-lg-4 col-lg-offset-4 btn btn-primary" @click="sendData">JE VALIDE MA DEMANDE</button>
		</div>
	</div>
</script>
<script>
Vue.component(
	'moduleOpportunityCreator',
	{
		data: function () {
			return ({
				scpiList: [
					<?php
					$s = Scpi::getAll();
					foreach ($s as $value){
						if ($value->online == false)
							continue;
						$price = floatVal($value->getPrixAcquereur());
						?>
						{
							name: "<?=$value->name?>",
							id: "<?=$value->id?>",
							value: parseFloat("<?=$price?>").toFixed(2)
						},
						<?php
					}
					?>
				],
				crnp: 100.0,
				cru: 0.0,
				nb_part: 1,
				price_per_part: 0,
				m_usufruit: 0,
				m_nue: 0,
				m_global: 0,
				m_type: 0,
				m_scpi: "",
				dem: 3,
				partial: 0,
				showcreator: false,
				token: "<?=$_SESSION['csrf'][0]?>"
			});
		},
		computed: {
			type_format: function (){
				if (this.m_type == 0)
					return ("Nue Propriété");
				else
					return ("Usufruit");
			},
			montantGlobalFixed: function () {
				return (parseFloat(this.m_global).toFixed(2));
			},
			montantUsuFixed: function () {
				return (parseFloat(this.m_usufruit).toFixed(2));
			},
			montantNuFixed: function () {
				return (parseFloat(this.m_nue).toFixed(2));
			}
		},
		methods: {
			update_all(){
				this.update_cru();
				this.update_total();
			},
			update_price() {
				for (var i = 0; i < this.scpiList.length; i++)
				{
					if (this.scpiList[i].id == this.m_scpi)
					{
						this.price_per_part = this.scpiList[i].value;
						this.update_all();
					}
				}
			},
			update_cru() {
				if (this.cru > 50)
					this.cru = 50;
				else if (this.cru < 0)
					this.cru = 0;
				this.cru = parseFloat(this.cru).toFixed(2);
				if (isNaN(this.cru) == true)
					this.cru = 50.0;
				this.crnp = (100.0 - this.cru).toFixed(2);
				this.update_usu();
				this.update_nue();
			},
			update_crnp() {
				if (this.crnp > 100)
					this.crnp = 100;
				else if (this.crnp < 50)
					this.crnp = 50;
				this.crnp = parseFloat(this.crnp).toFixed(2);
				if (isNaN(this.crnp) == true)
					this.crnp = 50.0;
				this.cru = (100.0 - this.crnp).toFixed(2);
				this.update_usu();
				this.update_nue();
			},
			update_total() {
				if (isNaN(this.price_per_part) == true)
					this.price_per_part = 0.0;
				this.m_global = parseInt(this.nb_part) * this.price_per_part;
				this.m_global = parseFloat(this.m_global).toFixed(2);
				if (isNaN(parseFloat(this.m_global)) == true)
					this.m_global = 0.0;
			},
			update_usu() {
				this.m_usufruit = parseFloat(this.m_global) * (parseFloat(this.cru) / 100);
				//this.m_usufruit = parseFloat(this.m_usufruit).toFixed(2);
			},
			update_nue() {
				this.m_nue = parseFloat(this.m_global) * (parseFloat(this.crnp) / 100);
				//this.m_nue = parseFloat(this.m_nue).toFixed(2);
			},
			sendData() {
				var self = this;
				Vue.http.post('ajax_request_client.php',{
					req: "OpportunitySet",
					action: "add",
					data: {
						crnp: self.crnp,
						cru: self.cru,
						nb_part: self.nb_part,
						price_per_part: self.price_per_part,
						m_usufruit: self.m_usufruit,
						m_nue: self.m_nue,
						m_global: self.m_global,
						m_type: self.m_type,
						m_scpi:  self.m_scpi,
						dem: self.dem,
						partial: self.partial,
					},
					token: self.token
				},
				{emulateJSON: true})
				.then(
					function (res) {
						msgBox.show("Votre demande a été enregistrée. Elle sera disponible une fois validée par nos équipes.");
						self.crnp = 100.0;
						self.cru = 0.0;
						self.nb_part = 1;
						self.price_per_part = 0;
						self.m_usufruit = 0;
						self.m_nue = 0;
						self.m_global = 0;
						self.m_type = 0;
						self.m_scpi = "";
						self.dem = 3;
						self.partial = 0;
						$('.modal_creator').modal('toggle')
					},
					function (res) {
						msgBox.show("Impossible de poster cette demande. Verifiez les données ou réessayez plus tard.");
						self.token = res.body.token;
					}
				);
			},
		},
		template: '#moduleOpportunityCreator'
	}
);
</script>

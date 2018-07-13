</script>
<script type="text/x-template" id="moduleOpportunityCreator">
	<div class="modalOpportuniteCreator">
		<div class="flexParagraph">
			Je souhaite investir en
			<select  v-model="m_type">
				<option value="0">Nue Propri&eacute;t&eacute;</option>
				<option value="1">Usufruit</option>
			</select>
			 en démembrement temporaire pour une durée de 
			<select v-model="dem">
				<option v-for="duree in 20" :value="duree" v-if="duree > 2"> {{ duree }}</option>
			</select>
			<div>ans</div>
			dans la 
			<select v-model="m_scpi" @change="update_price">
				<option value="0">-</option>
				<option v-for="line in $store.getters.getScpiOpportunite" v-bind:value="line.id">{{line.name}}</option>
			</select>
			<div style="margin-right: 50px;">avec une cl&eacute; de r&eacute;partition</div>
			pour le nu-propri&eacute;taire de
			<input type="number" step="0.01" min="50" max="100" v-model="crnp" @change="update_crnp" class="noBorderRight"/>
			<div class="unity">%</div>
			et pour l'usufruitier de 
			<input type="number" step="0.01" min="0" max="50" v-model="cru" @change="update_cru" class="noBorderRight"  style="width: 80px;"/>
			<div class="unity">%</div>.
		</div>
		<div class="flexParagraph">
			Je souhaite investir dans
			<input type="number" min="1" v-model="nb_part" @change="update_all" @blur="update_all" style="width: 80px;"/>
			part(s) dont le prix pleine propriet&eacute; est de
			<input type="number" class="noBorderRight" step="0.01" min="0" v-model="price_per_part" @change="update_all" @blur="update_all" style="width: 80px;"/>
			<div class="unity">&euro;</div>
			soit un investissement de {{montantNuFixed | euros }} pour le nu-propri&eacute;taire et de {{montantUsuFixed | euros }} pour l'usufruitier.
		</div>
		<div class="flexParagraph">
			<select v-model="partial" style="margin-left:0;">
				<option value="1" selected="">J'accepte</option>
				<option value="0">Je ne souhaite pas</option>
			</select>
			que ma souscription soit faite en plusieurs fois.
		</div>
		<div class="btnCreateOpportunite" >
			<button @click="sendData">JE VALIDE MA DEMANDE</button>
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
				m_scpi: 0,
				dem: 3,
				partial: 1,
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
			update_all: function(){
				this.update_cru();
				this.update_total();
			},
			update_price: function() {
				for (var i = 0; i < this.$store.getters.getScpiOpportunite.length; i++)
				{
					if (this.$store.getters.getScpiOpportunite[i].id == this.m_scpi)
					{
						this.price_per_part = this.$store.getters.getScpiOpportunite[i].value;
						this.update_all();
					}
				}
			},
			update_cru: function() {
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
			update_crnp: function() {
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
			update_total: function() {
				if (isNaN(this.price_per_part) == true)
					this.price_per_part = 0.0;
				this.m_global = parseInt(this.nb_part) * this.price_per_part;
				this.m_global = parseFloat(this.m_global).toFixed(2);
				if (isNaN(parseFloat(this.m_global)) == true)
					this.m_global = 0.0;
			},
			update_usu: function() {
				this.m_usufruit = parseFloat(this.m_global) * (parseFloat(this.cru) / 100);
				//this.m_usufruit = parseFloat(this.m_usufruit).toFixed(2);
			},
			update_nue: function() {
				this.m_nue = parseFloat(this.m_global) * (parseFloat(this.crnp) / 100);
				//this.m_nue = parseFloat(this.m_nue).toFixed(2);
			},
			sendData: function() {
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
						if (typeof res.body.err != 'undefined')
							msgBox.show(res.body.err);
						else 
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

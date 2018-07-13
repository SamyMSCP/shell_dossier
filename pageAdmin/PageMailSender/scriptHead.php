</script>
<script type="text/javascript" charset="utf-8">

Vue.component(
	'SendMail',
	{
		data: function()
		{
			return ({	'LstSCPI':  this.$store.getters.getAllScpiSorted,
						'lstCI': this.$store.getters.getLstCentreInteret,
						'selscpi' : {},
						'selci' : {},
						'message' : `<?= nl2br($this->message) ?>`,
						'message_hasError' : false,
						'title' : "<?= $this->title ?>",
						'title_hasError' : false,
						'include_sign' : true
					});
		},
<?php if (!empty($this->lstscpi) || !empty($this->lstci)): ?>
		mounted: function()
		{
<?php
	if (!empty($this->lstscpi))
	{
		echo 'var S = ', $this->lstscpi, ';';
?>
			S.forEach(function(elt) {
				this.LstSCPI.some( function(scpi, key)
				{
					if (scpi.id == elt)
					{
						this.$set(this.lstselscpi, key, scpi);
						return true;
					}
				}, this)
			}, this);
<?php
	}
	if (!empty($this->lstci))
	{
		echo 'var C = ', $this->lstci, ';';
?>
			C.forEach(function(elt) {
				this.lstCI.some( function(ci, key)
				{
					if (ci.id == elt)
					{
						this.$set(this.lstselci, key, ci);
						return true;
					}
				}, this)
			}, this);
<?php
	}
?>			setTimeout(function() { this.$store.dispatch('UPDATE_DEST', this.GetListCISCPI()) }.bind(this), 1000);
		},
<?php endif; ?>
		props:
		{
			'lstselscpi': {type: Object, default: function() { return {} }},
			'lstselci': {type: Object, default: function() { return {} }}
		},
		template:
		`<div>
			<div class="row">
				<div class="col-md-4 text-right">
					<div class="row">
						<div class="form-inline">
							<div class="form-group">
								<label for="scpi">SCPI : </label>
								<select class="form-control" v-model="selscpi" v-on:keyup.enter="AddSCPI()">
									<option v-for="(SCPI, key) in LstSCPI" :value="key">{{ SCPI.name | unprefix_scpi }}</option>
								</select>
								<button class="btn-mscpi btn-not-check" v-if="selscpi != undefined" @click=AddSCPI()>+</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-inline">
							<div class="form-group">
								<label for="ci">Opportunités :</label>
								<select class="form-control" v-model="selci" v-on:keyup.enter="AddCI()">
									<option v-for="(CI, key) in lstCI" :value="key">{{ CI.nom }}</option>
								</select>
								<button class="btn-mscpi btn-not-check" v-if="selci != undefined" @click=AddCI()>+</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="listObjectOut">
						<div class="listObjectIn pull-left" v-for="(scpi, key) in lstselscpi" @click="RemoveSCPI(key)">
							{{ $store.getters.getAllScpiSorted[key].name | unprefix_scpi }}
							<span class="btn-close">X</span>
						</div>
						<div class="listObjectIn pull-left" v-for="(ci, key) in lstselci" @click="RemoveCI(key)">
							{{ $store.getters.getLstCentreInteret[key].nom }}
							<span class="btn-close">X</span>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="listObjectOut">
						<div class="row col-md-push-1 col-md-11">
							<p class="text-center">
								<span>Destinataires :</span>
								<b v-if="$store.getters.NbDh >= 0">{{ $store.getters.NbDh }}</b>
							</p>
						</div>
						<div class="row text-center col-md-push-1 col-md-11">
							<button class="btn-mscpi" :disabled="$store.getters.NbDh <= 0" data-toggle="modal" data-target=".confirm_send">Envoyer</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-horizontal">
					<div class="form-group" v-bind:class="{ 'has-error' : title_hasError }">
						<label class="control-label col-md-1" for="title">Titre :</label>
						<div class="col-md-7">
							<input class="form-control" type="text" name="title" v-model="title">
						</div>
						<div class="col-md-1">
							<p class="text-right">
								<img class="_tooltip_r" src="<?= $this->getPath() ?>img/i_Bleu-MS.png" onmouseover="display_tooltip('Variables', ' ##CIVPRENOMNOM## : <i>Civilité Prénom Nom</i> du destinataire<br /> ##CONSEILLER## : <i>Prénom Nom</i> du conseiller<br /> ##CONSEILLER_TEL## : Téléphone du conseiller <br /> ##CONSEILLER_MAIL## : Courriel du conseiller', event)" onmouseout="disable_msg(event)"/>
							</p>
						</div>
						<div class="col-md-2">
							<div class="checkbox">
								<label>
									<input type="checkbox" v-model="include_sign"> Inclure signature
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<ck-editor id="calvin-klein-editor" name="ckMail" v-model="message" v-bind:class="{ 'has-error' : message_hasError }"></ck-editor>
			<div class="modal fade confirm_send" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-std">
					<div class="modal-content" style="background-color: rgb(235,235,235)">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" style="text-align: center;">Confirmation d'envoi</h4>
						</div>
						<div class="trait"></div>
						<div class="modal-body">
							<p class="text-center">Envoyer l'email aux {{ $store.getters.NbDh }} destinataires concernés ?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class=" btn-mscpi btn-not-selected" data-dismiss="modal">Retour</button>
							<button type="button" class=" btn-mscpi btn-orange" @click="SendMail" data-dismiss="modal" >Envoyer</button>
						</div>
					</div>
				</div>
			</div>
		</div>`,
		methods: {
			AddCI: function() {
				if (Number.isInteger(this.selci) && Object.keys(this.lstselci).indexOf(this.selci.toString()) == -1)
				{
					this.$set(this.lstselci, this.selci, this.$store.getters.getLstCentreInteret[this.selci].id);
					this.$store.dispatch('UPDATE_DEST', this.GetListCISCPI());
				}
			},
			AddSCPI: function() {
				if (Number.isInteger(this.selscpi) && Object.keys(this.lstselscpi).indexOf(this.selscpi.toString()) == -1)
				{
					this.$set(this.lstselscpi, this.selscpi, this.$store.getters.getAllScpiSorted[this.selscpi].id);
					this.$store.dispatch('UPDATE_DEST', this.GetListCISCPI());
				}
			},
			GetListCISCPI: function()
			{			
				return {'ci' : Object.keys(this.lstselci).map(function(ci){return this.$store.getters.getLstCentreInteret[ci].id;}, this),
				'scpi': Object.keys(this.lstselscpi).map(function(scpi){return this.$store.getters.getAllScpiSorted[scpi].id;}, this)};
			},
			RemoveCI: function(id) {
				this.$delete(this.lstselci, id);
				this.$store.dispatch('UPDATE_DEST', this.GetListCISCPI());
			},
			RemoveSCPI: function(id) {
				this.$delete(this.lstselscpi, id);
				this.$store.dispatch('UPDATE_DEST', this.GetListCISCPI());
			},
			SendMail: function()
			{
				var data = this.GetListCISCPI();
				this.sel_hasError = (Object.keys(data).length == 0) ? true : false;
				this.title_hasError = (this.title.length < 10) ? true : false;
				this.message_hasError = (this.message.length < 40) ? true : false;
				if (!this.sel_hasError && !this.title_hasError && !this.message_hasError)
				{
					data.title = this.title;
					data.message = this.message;
					data.sign = this.include_sign;
					if (data.message != "" && data.title != "" && this.$store.getters.NbDh > 0)
						this.$store.dispatch('SEND_MAIL', data);
				}
			}
		}
	}
);

store.registerModule('sendmail', {
	state : {
		nb_dh : -1,
		token: "<?=$_SESSION['csrf'][0]?>"
	},
	getters: {
		NbDh: function(state, getters) {
			return (state.nb_dh);
		},
		Token: function(state, getters) {
			return (state.token);
		}
	},
	mutations: {
		UPDATE_NB_DH: function (state, nb) {
			state.nb_dh = nb;
		},
		UPDATE_TOKEN: function (state, token) {
			state.token = token;
		}
	},
	actions: {
		UPDATE_DEST: function(context, data) {
			if (data.ci.length || data.scpi.length)
			{
				Vue.http.post('ajax_request.php', {
					req: 'MailSender',
					action: 'count',
					data: data,
					token: context.getters.Token
				},
				{emulateJSON: true}
				)
				.then (
					function (res) {
						context.commit('UPDATE_NB_DH', res.body.nb);
						context.commit('UPDATE_TOKEN', res.body.token);
					},
					function (res) {
						context.commit('UPDATE_TOKEN', res.body.token);
					}
				);
			}
			else
				context.commit('UPDATE_NB_DH', -1);
		},
		SEND_MAIL: function(context, data) {
			Vue.http.post('ajax_request.php', {
				req: 'MailSender',
				action: 'send',
				data: data,
				token: context.getters.Token
			},
			{emulateJSON: true}
			)
			.then (
				function (res) {
					context.commit('UPDATE_TOKEN', res.body.token);
				},
				function (res) {
					context.commit('UPDATE_TOKEN', res.body.token);
				}
			);
		}
	}
})

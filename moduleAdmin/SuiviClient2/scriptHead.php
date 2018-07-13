</script>
<script type="text/javascript" charset="utf-8">

// TODO : Il faut avoir un lien dans la modale qui permet directement d'accéder au projet qui est lié si il y en a un.

function CrmStore() {
	var that = this;
	this.contacts = <?=json_encode(Crm2::$_contacts)?>;
	this.sujets  = <?=json_encode(Crm2::$_sujets)?>;
	this.listCrm = <?=json_encode($this->data)?>;
	this.columnToSort = 6;
	this.reverseSort = true;
	this.whatShow = 0;
	this.showProject = false;
	this.showCommentaire = true;
	this.currentTime = (new Date()).getTime() / 1000;
	this.pageSelected = 0;
	this.newCrm = function(id_client) {
		if (typeof id_client === 'undefined')
			id_client = <?=isset($GLOBALS['GET']['client']) ? $GLOBALS['GET']['client'] : 0 ?>;
		return ({
			id : 0,
			priority: "0",
			id_client : id_client,
			contactSelected : null,
			sujetSelected : null,
			lstIdProject: [],
			projectsId: [],
			isOkay: false,
			date_execution: moment().set({
				minutes: 0,
				second: 0,
				millisecond: 0
			}).add({hour: 1}).format("X"),
			duree : "-2700",
			commentaire : ""
		});
	};
	this.commentaire = "";
	this.selectedCrm = this.newCrm();
	this.sendSelectedCrm = function () {
		this.$http.post('ajax_request.php', {
			req: 'Crm',
			data: this.selectedCrm,
			token: "<?=$_SESSION['csrf'][0]?>"
		}, {emulateJSON: true}).then(
			function (res) {
				that.listCrm = res.body;
				$('#modalCrm').modal('hide');
			},
			function (res) {
				if (typeof res.body.err != 'undefined')
					msgBox.show(res.body.err);
				else 
					msgBox.show("La tache n'a pas pu etre modifiée !");
			}
		);
		return ;
	};
	this.updateOneSelectedCrm = function () {
		this.$http.post('ajax_request.php', {
			req: 'Crm',
			config: 'all',
			data: this.selectedCrm,
			token: "<?=$_SESSION['csrf'][0]?>"
		}, {emulateJSON: true}).then(
			function (res) {
				that.listCrm = that.listCrm.map(function(elm){
					if (res.body.id == elm.id)
						return (res.body);
					return (elm)
				})
				msgBox.show("La tache à été modifiée !");
				$('#modalCrm').modal('hide');
			},
			function (res) {
				if (typeof res.body.err != 'undefined')
					msgBox.show(res.body.err);
				else 
					msgBox.show("La tache n'a pas pu etre modifiée !");
			}
		);
		return ;
	};
	this.updateSelectedCrm = function () {
		this.$http.post('ajax_request.php', {
			req: 'Crm',
			data: this.selectedCrm,
			token: "<?=$_SESSION['csrf'][0]?>"
		}, {emulateJSON: true}).then(
			function (res) {
				that.listCrm = res.body;
				msgBox.show("La tache à été modifiée !");
				if (that.listCrm.every(function(elm) {
					return (elm.isOkay == 1);
				}))
				{
					msgBox.show("Vous n'avez plus de taches en cours pour ce client. Voulez-vous inserer une nouvelle tache ?",[
						{
							text: "Oui",
							action: function() { 
								that.selectedCrm = that.newCrm();
								if (!$('#modalCrm').hasClass('in'))
									$('#modalCrm').modal('show');
							}
						},
						{
							text: "Non",
							action: function() { console.log("non") }
						},
					]);
				}
				else
				{
					$('#modalCrm').modal('hide');
				}
			},
			function (res) {
				if (typeof res.body.err != 'undefined')
					msgBox.show(res.body.err);
				else 
					msgBox.show("La tache n'a pas pu etre modifiée !");
			}
		);
		return ;
	};
	return (this);
}

var myCrmStore = new CrmStore();

Vue.component(
	'btnNewCrm',
	{
		data: function() {
			return (myCrmStore);
		},
		template: `
			<button type="submit" @click="setNewCrm()">AJOUTER UNE TACHE</button>
		`,
		methods: {
			setNewCrm: function () {
				this.selectedCrm = this.newCrm();
				$('#modalCrm').modal('show');
			},
		}
	}
);


Vue.component(
	'tableCrm',
	{
		data: function() {
			return (myCrmStore);
		},
		template :`
			<div>
				<div class="btnFilterCrm">
					<button class="btn-mscpi" :class="{'btn-not-check' : whatShow != 0}" @click="setWhatShow(0)">Tout</button>
					<button class="btn-mscpi" :class="{'btn-not-check' : whatShow != 1}" @click="setWhatShow(1)">Fait</button>
					<button class="btn-mscpi" :class="{'btn-not-check' : whatShow != 2}" @click="setWhatShow(2)">À faire</button>
				</div>
				<table border="0">
					<thead>
						<tr>
							<th>Valider</th>
							<th class="sortable" @click="setColumn(0)">Priority <span v-if="columnToSort == 0 && reverseSort == false">^</span><span v-if="columnToSort == 0 && reverseSort == true">V</span></th>
							<?php
								if (isset($this->forConseiller) && $this->forConseiller == true)
									echo "<th  class='sortable'  @click='setColumn(1)' >Client  <span v-if='columnToSort == 1 && reverseSort == false'>^</span><span v-if='columnToSort == 1 && reverseSort == true'>V</span></th>"
							?>
							<th  class="sortable"  @click="setColumn(2)" style="min-width: 133px;">Contact <span v-if="columnToSort == 2 && reverseSort == false">^</span><span v-if="columnToSort == 2 && reverseSort == true">V</span></th>
							<th  class="sortable"  @click="setColumn(3)" style="min-width: 173px;">Executant  <span v-if="columnToSort == 3 && reverseSort == false">^</span><span v-if="columnToSort == 3 && reverseSort == true">V</span></th>
							<?php
								if (isset($this->showConseiller) && $this->showConseiller == true)
									echo '<th  class="sortable"  @click="setColumn(4)"style="min-width: 174px;">Conseiller  <span v-if="columnToSort == 4 && reverseSort == false">^</span><span v-if="columnToSort == 4 && reverseSort == true">V</span></th>';
							?>
							<th  class="sortable"  @click="setColumn(5)">Sujet  <span v-if="columnToSort == 5 && reverseSort == false">^</span><span v-if="columnToSort == 5 && reverseSort == true">V</span></th>
							<th  class="sortable"  @click="setColumn(6)">Date  <span v-if="columnToSort == 6 && reverseSort == false">^</span><span v-if="columnToSort == 6 && reverseSort == true">V</span></th>
							<th>Commentaire</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="crm in filteredCrm" :class="{crmOkay: crm.isOkay == '1'}">
							<td @click.stop="valider(crm)">
								<img class="picto-small" :class="{crmNotValidate : crm.isOkay != 1}"  src="<?=$this->getPath()?>img/Termine-Vert.svg" alt="" />
							</td>
							<td style="width:160px;">
								<priority-stars :entity="crm" :value="crm.priority" :size="5" @change="changePriority"></priority-stars>
							</td>
							<?php
								if (isset($this->forConseiller) && $this->forConseiller == true)
									echo '<td  @click="modifyCrm(crm)" >{{ crm.clientShortName }}</td>'
							?>
							<td @click="modifyCrm(crm)" >
								<img class="picto-small" :src="'<?=$this->getPath()?>img/' + contacts[crm.contactSelected].img"/>
								{{contacts[crm.contactSelected].name}}
							</td>
							<td @click="modifyCrm(crm)" >{{ crm.executantShortName }}</td>
							<?php
								if (isset($this->showConseiller) && $this->showConseiller == true)
									echo '<td>{{ crm.conseillerShortName }}</td>';
							?>
							<td @click="modifyCrm(crm)" >{{sujets[crm.sujetSelected].name}}</td>
							<td :class="{crmLast: haveError(crm)}">{{crm.date_execution | tsDate}}</td>
							<td v-html="crm.commentaire" style="text-align:left;"></td>
						</tr>
					</tbody>
				</table>
			</div>
		`,
		computed: {
			filteredCrm: function() {
				<?php
				if ($this->collaborateur->type != "yoda" && $this->collaborateur->type != "prospecteur" && $this->collaborateur->type != "assistant" && $this->collaborateur->type != "backoffice" && $this->collaborateur->id_dh != $this->dh->conseiller)
				{
					?>
					return (this.filteredCrm2.filter(function(elm) {
						return (elm.id_executant == <?=$this->collaborateur->id_dh?>);
					}));
					<?php
				}
				else
				{
					?>
					return (this.filteredCrm2);
					<?php
				}
				?>
			},
			filteredCrm2: function() {
				if (this.whatShow == 0)
					return (this.sortedCrm);
				else if (this.whatShow == 1)
				{
					return (this.sortedCrm.filter(function(elm) {
						return (elm.isOkay == '1')
					}));
				}
				else if (this.whatShow == 2)
				{
					return (this.sortedCrm.filter(function(elm) {
						return (elm.isOkay != '1')
					}));
				}
			},
			sortedCrm: function() {
				var that = this;
				if (this.columnToSort == 0)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.priority - b.priority);
						else
							return (b.priority - a.priority);
					}));
				}
				else if (this.columnToSort == 1)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.id_client - b.id_client);
						else
							return (b.id_client - a.id_client);
					}));
				}
				else if (this.columnToSort == 2)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.contactSelected - b.contactSelected);
						else
							return (b.contactSelected - a.contactSelected);
					}));
				}
				else if (this.columnToSort == 3)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.id_executant - b.id_executant);
						else
							return (b.id_executant - a.id_executant);
					}));
				}
				else if (this.columnToSort == 4)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.id_user - b.id_user);
						else
							return (b.id_user - a.id_user);
					}));
				}
				else if (this.columnToSort == 5)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.sujetSelected - b.sujetSelected);
						else
							return (b.sujetSelected - a.sujetSelected);
					}));
				}
				else if (this.columnToSort == 6)
				{
					return (this.listCrm.sort(function(a, b){
						if (that.reverseSort == false)
							return (a.date_execution - b.date_execution);
						else
							return (b.date_execution - a.date_execution);
					}));
				}
			}
		},
		mounted: function() {
			<?php
				if (isset($GLOBALS['GET']['id_crm']))
				{
					?>
					this.selectedCrm = this.listCrm.find(function(elm) {
						return (elm.id == <?=intval($GLOBALS['GET']['id_crm'])?>)
					});
					$('#modalCrm').modal('show');
					<?php
				}
				else
				{
					?>
					this.selectedCrm = this.newCrm();
					<?php
				}
			?>
		},
		methods: {
			setColumn: function(col) {
				if (this.columnToSort == col)
				{
					this.reverseSort = ! this.reverseSort;
					return;
				}
				this.columnToSort = col;
				this.reverseSort = false;
			},
			changePriority: function(data) {
				var that = this;
				msgBox.show("Voulez-vous vraiment définir la priorité de cette tache  a [" + data.value + "] ?", [
					{
						text: "Oui",
						action: function() { 

							var tmp = JSON.parse(JSON.stringify(data.entity));
							tmp.priority = data.value;
							that.selectedCrm = tmp;
							that.updateOneSelectedCrm();
						}
					},
					{
						text: "Non",
						action: function() {  }
					},
				]);
			},
			valider: function(elm) {
				this.selectedCrm = JSON.parse(JSON.stringify(elm));
				this.selectedCrm.isOkay = (this.selectedCrm.isOkay == '1') ? "0" : "1" ;
				<?php
				if (isset($this->forConseiller) && $this->forConseiller == true)
				{
					?>
					this.updateOneSelectedCrm();
					<?php
				}
				else
				{
					?>
					this.updateSelectedCrm();
					<?php
				}
				?>
			},
			haveError: function(crm) {
				return ((crm.date_execution <= this.currentTime) && crm.isOkay != '1');
			},
			setWhatShow: function (val) {
				this.whatShow = val;
			},
			modifyCrm: function(elm) {
				<?php
				if (isset($this->isLink) && $this->isLink == true)
				{
					?>
					window.open("?p=EditionClient&client=" + elm.id_client + "&onglet=SUIVI&id_crm=" + elm.id, "_blank");
					<?php
				}
				else
				{
					?>
					this.selectedCrm = JSON.parse(JSON.stringify(elm));
					$('#modalCrm').modal('show');
					<?php
				}
				?>
			}
		}
	}
);

Vue.component(
	'lstProjectCrm',
	{
		props: ['value', 'lstProject'],
		methods: {
			changeValue: function(elm) {
				this.$emit('input', $('#id_lst_project_crm').val());
			}
		},
		mounted: function() {
			$('#id_lst_project_crm').val(this.value);
		},
		beforeUpdate: function() {
			$('#id_lst_project_crm').val(this.value);
		},
		watch: {
			value: function() {
				$('#id_lst_project_crm').val(this.value);
			}
		},
		template:`
			<select multiple  @change="changeValue" id="id_lst_project_crm">
				<option v-for="project in lstProject" :value="project.id">
					<span v-if="typeof $store.getters.getPersonnePhysiqueForBeneficiaire(project.id_beneficiaire) != 'undefined'">
						[
						<span v-for="Pp in $store.getters.getPersonnePhysiqueForBeneficiaire(project.id_beneficiaire)" >
							{{ (Pp.civilite == "Monsieur") ? "M." : "Mme" }}
							{{ Pp.prenom }}
							{{ Pp.nom}}
						</span>
						]
					</span> - {{ project.nom }}
				</option>
			</select>
		`
	}
);

Vue.component(
	'modalCrm',
	{
		data: function() {
			return (myCrmStore);
		},
		template :`
			<div class="modal fade" id="modalCrm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" style="border-radius: 15px;">
					<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
						<div class="modal-body">

							<div class="modalStar">
								<priority-stars :entity="selectedCrm" v-model="selectedCrm.priority" :size="5" ></priority-stars>
							</div>
							<h1>CRM</h1>
							<div class="trait"></div>
							<?php
							//<p style="margin-top: 20px;">Type de contact :</p>
							?>
							<div class="blockContact">
								<button style="height:80px;width: 80px;flex:0;" v-for="contact in contacts" @click="changeContact(contact)" class="btn-mscpi" :class="{'btn-not-check' : contact.id != selectedCrm.contactSelected}">
									<img :src="'<?=$this->getPath()?>img/' + contact.img" v-if="contact.id != selectedCrm.contactSelected"/>
									<img :src="'<?=$this->getPath()?>img/' + contact.img2" v-else/>
								</button>

								<?php
								if (!isset($this->forConseiller) || $this->forConseiller == false)
								{
									?>
									<button style="height:80px;width: 80px;flex:0;" class="btn-mscpi" @click="toggleProject()" :class="{'btn-not-check' : !showProject}" >
										Lier des Projets
									</button>
									<?php
								}
								?>
							</div>
							<?php
							//<p style="margin-top: 20px;">Sujets :</p>
							?>
							<div class="blockSujet">
								<button style="" v-for="sujet in sujets" @click="changeSujet(sujet)"  class="btn-mscpi"  :class="{'btn-not-check' : sujet.id != selectedCrm.sujetSelected}">
									{{sujet.name}}
								</button>
							</div>
							<div class="blockDate">
								<div>
									<p>Date :</p>
									<my-datepicker id="dateExecutionCrm" v-model="selectedCrm.date_execution"></my-datepicker>
								</div>
								<div>
									<p>Heure : </p>
									<my-time-picker v-model="selectedCrm.date_execution"></my-time-picker>
								</div>
								<div>
									<p>Durée : </p>
									<my-time-picker v-model="selectedCrm.duree"></my-time-picker>
								</div>
							</div>
							<div class="blockSelectProject" v-if="showProject">
								Maintenez la touche command pour sectionner plusieurs projets.
								<lstProjectCrm v-model="selectedCrm.projectsId" :lstProject="$store.getters.getProjectsForDh($store.getters.getSelectedDh)"></lstProjectCrm>
							</div>
							<div class="blockCommentaire">
								Commentaires :
								<ck-editor id="crmCommentaire" height="140px" v-model="selectedCrm.commentaire"></ck-editor>
							</div>
							<div>
							</div>
							<div class="blockValidation">
								<div class="inputForm" style="margin-top: -6px;"> 
									<label style="margin:20px;" class="radio-inline" for="isOkay">
										<input type="checkbox" v-model="selectedCrm.isOkay" id="isOkay" v-bind:true-value="'1'" v-bind:false-value="'0'"/>
										<span></span>Cette tache à été effectuée !
									</label> 
								</div>
								<button v-if="selectedCrm.id == 0" @click="sendForm" class="btn-mscpi" :class="{'btn-not-check': !formValide}">Ajouter</button>
								<button v-if="selectedCrm.id != 0" @click="updateForm" class="btn-mscpi" :class="{'btn-not-check': !formValide}">Modifier</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		`,
		computed: {
			formValide: function() {
			return (true);
				return (
					this.selectedCrm.contactSelected &&
					this.selectedCrm.sujetSelected
				);
			},
		},
		methods: {
			toggleProject() {
				this.showProject = !this.showProject;
			},
			sendForm: function() {
				this.sendSelectedCrm();
			},
			updateForm: function() {
				<?php
				if (isset($this->forConseiller) && $this->forConseiller == true)
				{
					?>
					this.updateOneSelectedCrm();
					<?php
				}
				else
				{
					?>
					this.updateSelectedCrm();
					<?php
				}
				?>
			},
			changeContact: function(contact) {
				this.selectedCrm.contactSelected = contact.id;
			},
			changeSujet: function(sujet) {
				this.selectedCrm.sujetSelected = sujet.id;
			},
		}
	}
)

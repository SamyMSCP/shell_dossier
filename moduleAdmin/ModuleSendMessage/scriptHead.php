
</script>
<script type="text/javascript" charset="utf-8">

function TemplateStore () {
	var that = this;
	this.listTypeDocument = <?=json_encode($this->typeCommunication)?>;
	this.listTemplate = <?=json_encode($this->listTemplates)?>;
	this.selectedApi = "MailSender";
	this.selectedTemplate = this.listTemplate[0];
	this.host = "<?=$_SERVER['HTTP_HOST']?>";
	this.token = "<?=$_SESSION['csrf'][0]?>";
	this.title = "";
	this.preview = false;

	this.message = "";
	this.prepare = {footer: `<?=$this->footer?>`};

<?php
/*
	//this.userList = <?=json_encode($this->clientList)?>;
	*/
	?>
	this.userList = [];

	//this.selectedUser = this.userList[0];
	this.selectedUser = null;

	//this.sendMail= function() {
	this.sendmail = function() {
		let arr = that.userList.map(function(elm) {
			return (elm.id);
		});
		arr = JSON.stringify(arr)
		var f = document.createElement("form");
		f.setAttribute('method',"post");
		<?php
		$page = isset($GLOBALS['GET']['p']) ? $GLOBALS['GET']['p'] : "Accueil";
		?>
		f.setAttribute('action',"?p=<?=$page?>");
		f.setAttribute('accept-charset',"utf-8");

		var csrf = document.createElement("input");
		csrf.setAttribute('type',"hidden");
		csrf.setAttribute('name',"token");
		csrf.setAttribute('value', that.token);
		f.appendChild(csrf);

		var api = document.createElement("input");
		api.setAttribute('type',"hidden");
		api.setAttribute('name',"api");
		api.setAttribute('value', that.selectedApi);
		f.appendChild(api);

		var id = document.createElement("input");
		id.setAttribute('type',"hidden");
		id.setAttribute('name',"idUser");
		id.setAttribute('value', arr);
		f.appendChild(id);

		var template = document.createElement("input");
		template.setAttribute('type',"hidden");
		template.setAttribute('name',"idTemplate");
		template.setAttribute('value', that.selectedTemplate.id);
		f.appendChild(template);

		var title = document.createElement("input");
		title.setAttribute('type',"hidden");
		title.setAttribute('name',"title");
		title.setAttribute('value', that.title);
		f.appendChild(title);

		var content = document.createElement("input");
		content.setAttribute('type',"hidden");
		content.setAttribute('name',"message");
		content.setAttribute('value', that.message);
		f.appendChild(content);

		var s = document.createElement("input"); //input element, Submit button
		s.setAttribute('type',"hidden");
		s.setAttribute('name',"action");
		s.setAttribute('value',"sendMail");

		f.appendChild(s);
		document.body.appendChild(f);
		f.submit();
	};
	return (this);
}

var myTemplateStore = new TemplateStore();

Vue.component(
	'sendMessageModale',
	{
		data: function() {
			return (myTemplateStore);
		},
		template: `
			<div class="modal fade sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content" style="background-color: rgb(235, 235, 235);padding: 20px;">
						<h1>Envoi de messages</h1>
						<div class="trait"></div>
						<p>Liste des destinataires :</p>
						<div class="listObjectOut">
							<div @click="changeSelectedUser(user)" class="listObjectIn" :class="{listObjectInSelected: user == selectedUser}" v-for="user in userList">{{user.shortName}} <span class="btn-close" @click.stop="removeUser(user.id)">X</span></div>
						</div>
						<div class="btnLst">
							<edit-template-api></edit-template-api>
							<edit-template-select></edit-template-select>
							<mail-title></mail-title>
							<send-mail></send-mail>
						</div>
						<edit-message-preview></edit-message-preview>
					</div>
				</div>
			</div>
		`,
		methods: {
			removeUser: function (idRemove) {
				this.userList = this.userList.filter(function(idElm) {
					return (idRemove != idElm.id);
				});
			},
			changeSelectedUser: function (usr) {
				this.selectedUser = usr;
			}
		}
	}
)

Vue.component(
	'sendMessageBtn',
	{
		props: {
			users: {
				type: Array,
				default: function() { return ([
				]); }
			}
		},
		data: function() {
			return (myTemplateStore);
		},
		template: `
			<button @click="setUsers()" class="btn-mscpi"  data-toggle="modal" data-target=".sendMessageModal">
				<slot></slot>
			</button>
		`,
		methods: {
			setUsers: function() {
				this.userList = this.users;
				if (this.userList.length > 0)
					this.selectedUser = this.userList[0];
				else
					alert('ya rien');
			}
		}
	}
)

Vue.component(
	'editTemplateApi',
	{
		data: function() {
			return (myTemplateStore);
		},
		template: `
			<div>
				<div class="arrSelect">
					<select v-model="selectedApi">
						<option v-for="lst in listTypeDocument">{{lst}}</option>
					</select>
				</div>
			</div>
		`	}
);

Vue.component(
	'selectUser',
	{
		data: function() {
			return (myTemplateStore);
		},
		template: `
			<div>
				<div class="arrSelect">
					<select v-model="selectedUser">
						<option v-for="lst in userList" v-bind:value="lst">{{lst.shortName}} - <{{lst.mail}}> <{{lst.phone}}></option>
					</select>
				</div>
			</div>
		`
	}
);


Vue.component (
	'editTemplateSelect',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<div class="arrSelect">
					<select v-model="selectedTemplate">
						<option v-for="lst in templateShow" v-bind:value="lst">{{lst.name}}</option>
					</select>
				</div>
			</div>
		`,
		computed: {
			templateShow: function() {
				var that = this;
				return (this.listTemplate.filter(function(elm) {
					return (elm.classname == that.selectedApi);
				}));
			}
		}
	}
);

Vue.component (
	'sendMail',
	{

		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<button class="btn-mscpi" @click="sendMail()">Envoyer</button>
			</div>
		`,
		methods: {
			sendMail: function() {
				this.sendmail();
			}
		}
	}
);

Vue.component (
	'mailTitle',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<input class="form-control" type="text" v-model="title" placeolder="Titre"/>
			</div>
		`
	}
);


Vue.component (
	'edit-message-preview',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<button class="btn-mscpi" :class="{'btn-not-check': !preview}" @click="tooglePreview()">Preview</button>
				<div class="editTemplatePreview">
					<ck-editor id="id_test" v-model="message" v-if="!preview"></ck-editor>
					<div class="previewContour" v-html="getContentRender" v-else></div>
				</div>
			</div>
		`,
		methods: {
			tooglePreview: function() {
				this.preview = !this.preview;
			}
		},
		computed: {
			getContentRender: function () {
				let rt = this.selectedTemplate.content;
				let replace = {
					"##HOST##": this.host,
					"##FOOTER##": this.prepare.footer,
					"##MESSAGE##": this.message
				}
				Object.keys(replace).forEach(function (key) {
					rt = rt.replace(new RegExp(key, 'g'), replace[key]);
				});
				if (this.selectedUser != null)
				{
					let replace = {
						"##SHORT_NAME##": this.selectedUser.shortName,
						"##NAME##": this.selectedUser.name,
						"##FIRSTNAME##": this.selectedUser.firstName
					}
					Object.keys(replace).forEach(function (key) {
						rt = rt.replace(new RegExp(key, 'g'), replace[key]);
					});
				}
				Object.keys(replace).forEach(function (key) {
					rt = rt.replace(new RegExp(key, 'g'), replace[key]);
				});
				return (rt);
			}
		}
	}
);

</script>
<script type="text/javascript" charset="utf-8">

function TemplateStore () {
	var that = this;
	this.listTypeDocument = <?=json_encode($this->typeCommunication)?>;
	this.listTemplate = <?=json_encode($this->listTemplates)?>;
	this.selectedApi = this.listTypeDocument[0];
	this.selectedTemplate = this.listTemplate[0];
	this.testuser = {
		name: "<?=$this->userTest->getName()?>",
		firstName: "<?=$this->userTest->getFirstName()?>",
		shortName: "<?=$this->userTest->getShortName()?>",
	}
	this.host = "<?=$_SERVER['HTTP_HOST']?>";
	this.token = "<?=$_SESSION['csrf'][0]?>";

	this.prepare = {footer: `<?=$this->footer?>`};

	this.setNew = function() {
		that.listTemplate.push({
			id: 0,
			name: "Template sans nom",
			content: "",
			classname: that.selectedTemplate.classname
		});
		that.selectedTemplate = that.listTemplate[that.listTemplate.length - 1];
	};
	this.saveSelectedTemplate = function() {
		var f = document.createElement("form");
		f.setAttribute('method',"post");
		f.setAttribute('action',"?p=<?=$GLOBALS['GET']['p']?>");
		f.setAttribute('accept-charset',"utf-8");

		var csrf = document.createElement("input");
		csrf.setAttribute('type',"hidden");
		csrf.setAttribute('name',"token");
		csrf.setAttribute('value', that.token);
		f.appendChild(csrf);

		var id = document.createElement("input");
		id.setAttribute('type',"hidden");
		id.setAttribute('name',"id");
		id.setAttribute('value', that.selectedTemplate.id);
		f.appendChild(id);

		var name = document.createElement("input");
		name.setAttribute('type',"hidden");
		name.setAttribute('name',"name");
		name.setAttribute('value', that.selectedTemplate.name);
		f.appendChild(name);

		var content = document.createElement("input");
		content.setAttribute('type',"hidden");
		content.setAttribute('name',"content");
		// var content
		content.setAttribute('value', that.selectedTemplate.content);
		f.appendChild(content);

		var classname = document.createElement("input");
		classname.setAttribute('type',"hidden");
		classname.setAttribute('name',"classname");
		classname.setAttribute('value', that.selectedTemplate.classname);
		f.appendChild(classname);

		var clientpage = document.createElement("input");
		clientpage.setAttribute('type',"hidden");
		clientpage.setAttribute('name',"onclientpage");
		clientpage.setAttribute('value', that.selectedTemplate.on_clientpage);
		f.appendChild(clientpage);

		var s = document.createElement("input"); //input element, Submit button
		s.setAttribute('type',"hidden");
		s.setAttribute('name',"action");
		s.setAttribute('value',"saveTemplate");

		f.appendChild(s);
		document.body.appendChild(f);
		f.submit();
	};
	return (this);
}

var myTemplateStore = new TemplateStore();

Vue.component(
	'editTemplateApi',
	{
		data: function() {
			return (myTemplateStore);
		},
		template: `
			<div>
				<div class="input-group">
					<span class="input-group-addon">Categorie:</span>
					<select class="form-control" v-model="selectedApi">
						<option v-for="lst in listTypeDocument">{{lst}}</option>
					</select>
				</div>
			</div>
		`	}
);

Vue.component (
	'editTemplateSelect',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<div class="input-group">
					<span class="input-group-addon">Template:</span>
					<select class="form-control" v-model="selectedTemplate">
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
		},
		updated: function() {
			//console.log(this.selectedTemplate);
			//console.log(this.templateShow[0]);
			//this.selectedTemplate = this.templateShow[0];
		}

	}
);

Vue.component (
	'templateName',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<div class="input-group">
					<span class="input-group-addon">Nom:</span>
					<input type="text" class="form-control" v-model="selectedTemplate.name"/>
				</div>
			</div>
		`,
		methods: {
			addNewTemplate: function() {
				this.setNew();
			}
		}
	}
);

Vue.component (
	'newTemplateBtn',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<button class="btn btn-primary btn-block" @click="addNewTemplate()"><i class="fa fa-plus-square"></i> Nouveau Template</button>
			</div>
		`,
		methods: {
			addNewTemplate: function() {
				this.setNew();
			}
		}
	}
);

Vue.component (
	'saveTemplateBtn',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div>
				<button class="btn btn-success btn-block" @click="saveTemplate()"><i class="fa fa-floppy-o"></i> Sauvegarder</button>
			</div>
		`,
		methods: {
			saveTemplate: function() {
				this.saveSelectedTemplate();
			}
		}
	}
);

Vue.component (
	'edit-template-preview',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div class="editTemplatePreview">
				<ck-editor id="id_test" v-model="selectedTemplate.content"></ck-editor>
				<div class="previewContour" v-html="getContentRender"></div>
			</div>
		`,
		computed: {
			getContentRender: function () {
				let replace = {
					"##SHORT_NAME##": this.testuser.shortName,
					"##NAME##": this.testuser.name,
					"##FIRSTNAME##": this.testuser.firstName,
					"##HOST##": this.host,
					"##FOOTER##": this.prepare.footer,
					"##MESSAGE##": `Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Ut convallis ornare dolor ut auctor.
					Vestibulum tristique, metus quis porttitor eleifend, nibh metus aliquet massa, at maximus ipsum justo non velit.
					Donec euismod suscipit commodo.
					Sed sem ligula, venenatis non ante vitae, tristique semper ipsum.
					Quisque convallis laoreet venenatis. Phasellus at vestibulum diam.
					Morbi eget bibendum lectus. Suspendisse eu risus augue. Integer vel dignissim arcu. Curabitur ut quam et lectus fermentum mattis non ut arcu.`
				}
				let rt = this.selectedTemplate.content;
				Object.keys(replace).forEach(function (key) {
					rt = rt.replace(new RegExp(key, 'g'), replace[key]);
				});
				return (rt);
			}
		}
	}
);


Vue.component (
	'isClientPage',
	{
		data: function () {
			return (myTemplateStore);
		},
		template: `
			<div class="btn is-visible-client" v-bind:class="selectedTemplate.on_clientpage == '1' ? 'btn-success' : 'btn-danger'" @click="selectedTemplate.on_clientpage = (selectedTemplate.on_clientpage == '1') ? '0' : '1'">
				<span v-if="selectedTemplate.on_clientpage == '1'"><i class="fa fa-eye"></i> page du client</span>
				<span v-else="" ><i class="fa fa-eye-slash"></i> page du client</span>
			</div>
		`,
	}
);

Vue.component('varEditor',
	{
		data: function () {
			return ({});
		},
		template: `<b>TEST</b>`,
		methods: {
			addVar: function() {
				console.log("OK");
			}
		}
	});
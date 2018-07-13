</script>
<script>

var lorem = `Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Ut convallis ornare dolor ut auctor.
					Vestibulum tristique, metus quis porttitor eleifend, nibh metus aliquet massa, at maximus ipsum justo non velit.
					Donec euismod suscipit commodo.
					Sed sem ligula, venenatis non ante vitae, tristique semper ipsum.
					Quisque convallis laoreet venenatis. Phasellus at vestibulum diam.
					Morbi eget bibendum lectus. Suspendisse eu risus augue. Integer vel dignissim arcu. Curabitur ut quam et lectus fermentum mattis non ut arcu.`;


var vI = new Vue({
	el: '.vueApp',
	store: store,
	data: {
		selected: {
			category: 0,
			template: 0
		},
		template: {
			categorie: <?=json_encode($this->typeCommunication)?>,
			template:  <?=json_encode($this->listTemplates)?>
		},
		testuser: {
			name: "<?=$this->userTest->getName()?>",
			firstName: "<?=$this->userTest->getFirstName()?>",
			shortName: "<?=$this->userTest->getShortName()?>"
		},
		editor: {
			name: "",
			variable: false,
			clientvisible: '0',
			text: "",
			id: undefined
		},
		vall: [
			{name: "##SHORT_NAME##", content: "<?=$this->userTest->getShortName()?>"},
			{name: "##NAME##", content: "<?=$this->userTest->getName()?>"},
			{name: "##FIRSTNAME##", content: "<?=$this->userTest->getFirstName()?>"},
			{name: "##MESSAGE##", content: lorem},
			{name: "##HOST##", content: "<?=$_SERVER['HTTP_HOST']?>"},
			{name: "##FOOTER##", content: `<?=$this->footer?>`},
			{name: "##ADDRESSE##", content: `<div style="position: absolute; top: 4cm; right: 2cm;">
				MeilleureSCPI.com<br>
				4 rue de la michodiere<br>
				75002 Paris
            </div>`},
			{name: "##MSCPI##", content: '<img alt="" src="/moduleAdmin/Nav/img/logo-meilleurescpi.png" style="height:93px; width:200px" />', force: true}
		]
	},
	methods: {
		change_categorie: function () {
			this.selected.template = 0;
			this.change_template();
		},
		change_template: function () {
			let self = this;
			let template = self.template.template.filter(temp => temp.classname == self.template.categorie[self.selected.category])[self.selected.template];
			self.editor.clientvisible = (template.on_clientpage === '1') ? '1' : '0';
			self.editor.text = template.content;
			self.editor.name = template.name;
			self.editor.id = template.id;
//			console.log(template_list[self.selected.template]);
		},
		create_new: function () {
//			console.log("creating new");
			let self = this;
			self.template.template.push({
				classname: self.template.categorie[self.selected.category],
				content: "##MESSAGE##",
				id: undefined,
				name: "nouveau template",
				on_clientpage: "0",
			});

			self.selected.template = self.template.template
				.filter(temp => temp.classname == self.template.categorie[self.selected.category])
				.length - 1;
			self.change_template();
		},
		save_template: function () {
			let self = this;

			console.log(self.editor.id);
			Vue.http.post('ajax_request.php', {
				req: "AjaxTemplate",
				action: (typeof self.editor.id === "undefined") ? "create" : "update",
				data: {
					on_client: self.editor.clientvisible,
					name: self.editor.name,
					content: self.editor.text,
					id: self.editor.id,
					categorie: self.template.categorie[self.selected.category]
				},
				token: "<?=$_SESSION['csrf'][0]?>"
			}, {emulateJSON: true})
				.then(
					function (res) {
						let content = JSON.parse(res.bodyText);
						self.template = content;
						self.change_template();
						swal({
							position: 'top-end',
							type: 'success',
							title: 'Mise à jour du template effectuée',
							showConfirmButton: false,
							timer: 1500
						});
					},
					function (res) {
//						console.log(res.bodyText);
						swal({
							position: 'top-end',
							type: 'error',
							title: JSON.parse(res.bodyText).err,
							showConfirmButton: false,
							timer: 1500
						});
					});
		}
	},
	computed: {
		getContentRender: function () {
			let replace = this.vall;
			let rt = this.editor.text;
			Object.keys(replace).forEach(function (key) {
				rt = rt.replace(new RegExp(replace[key].name, 'g'), replace[key].content);
			});
			return (rt);
		}
	},
	filters: {
		minify: function (txt) {
			if (txt.length > 12){
				txt = txt.substring(0,12) + "...";
			}
			return (txt);
		}
	},
	mounted: function () {
		this.change_template();
	}
});
<?= $this->Nav ?>
<div class="containerPerso vueApp">
	<div class="container-fluid">
		<div class="row">
			<h1>Gestionnaire de template</h1>
			<div class="trait"></div>
		</div>
		<div class="form">
			<div class="row">
				<div class="col-xs-3">
					<div class="input-group">
						<span class="input-group-addon">Catégorie</span>
						<select class="form-control" v-model="selected.category" @change="change_categorie">
							<option v-for="(el, index) in template.categorie" :value="index">{{el}}</option>
						</select>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="input-group">
						<span class="input-group-addon">Template</span>
						<select class="form-control" v-model="selected.template" @change="change_template">
							<option v-for="(el, index) in template.template.filter(temp => temp.classname == template.categorie[selected.category])" :value="index">{{el.name}}</option>
						</select>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="input-group">
						<span class="input-group-addon">Nom</span>
						<input class="form-control" v-model="editor.name"/>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="btn-group btn-group-justified">
						<div class="btn btn-default" @click="create_new">
							<i class="fa fa-plus"></i> Nouveau
						</div>
						<div class="btn btn-success" @click="save_template">
							<i class="fa fa-floppy-o"></i> Sauvegarder
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="btn-group">
						<div class="btn btn-with-span" :class="(editor.clientvisible == '1') ? 'btn-success' : 'btn-primary'" @click="editor.clientvisible = (editor.clientvisible == '0') ? '1' : '0'">
							<span v-if="editor.clientvisible == '1'">
								<i class="fa fa-eye"></i> page du client
							</span>
							<span v-else="">
								<i class="fa fa-eye-slash"></i> page du client
							</span>
						</div>
						<div type="button" class="btn btn-primary" :class="(editor.variable) ? 'active' : ''" @click="editor.variable = !editor.variable">
							<i class="fa fa-list-alt"></i> Variables
						</div>
					</div>
				</div>
			</div>
			<div class="row editor">
				<div class="col-xs-4" :class="(editor.variable) ? '' : 'hidden'">
					<div>
						<table class="table table-bordered">
							<tr>
								<th>Nom</th>
								<th>Valeur</th>
							</tr>
							<tr v-for="v in vall">
								<td>{{v.name}}</td>
								<td><samp>{{ v.content | minify }}</samp></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-xs-6">
					<ck-editor id="id_test" v-model="editor.text"></ck-editor>
				</div>
				<div class="col-xs-6">
					<div class="preview" v-html="getContentRender"></div>
				</div>
			</div>
		</div>
	</div>
</div>

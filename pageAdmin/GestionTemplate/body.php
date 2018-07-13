<?= $this->Nav ?>
<div class="containerPerso vueApp">
	<div class="container-fluid">
		<div class="row">
			<h1>page des gestion des templates</h1>
			<div class="trait"></div>

		</div>
		<div class="row btn-list">
			<edit-template-api class="col-xs-2"></edit-template-api>
			<edit-template-select class="col-xs-2"></edit-template-select>
			<template-name class="col-xs-2"></template-name>
			<div class="col-xs-6">

				<div class="btn-group btn-group-justified">
					<div class="btn btn-primary" @click="setNew()">
						<i class="fa fa-plus-square"></i> Nouveau Template
					</div>
					<div class="btn btn-primary">
						<i class="fa fa-list-alt"></i> Variables
					</div>
					<is-client-page></is-client-page>
					<div class="btn btn-success" @click="saveSelectedTemplate()">
						<i class="fa fa-floppy-o"></i> Sauvegarder
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<edit-template-preview></edit-template-preview>
			<var-editor></var-editor>
		</div>
	</div>
</div>

<div class="container-fluid vue-app-mailer">
	<div class="row">
		<h1 class="col-lg-12 text-center">Envoyer un Mail</h1>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="input-group">
				<span class="input-group-addon">Template:</span>
				<select class="form-control" @change="changeItem(null, $event)">
					<option selected value="">-</option>
					<option value="#header#<br>#ajd#<br>#contact#<br>#footer#">Simple</option>
					<option v-for="el in template_lst" v-bind:value="el.value">{{el.name}}</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row editor-row">
		<div class="row">
			<div class="col-lg-8">
				<div class="row">
					<div class="col-lg-12">
						<div class="input-group">
							<span class="input-group-addon">Sujet:</span>
							<input class="form-control" v-model="subject" placeholder="sujet du mail"/>
						</div>
					</div>
				</div>
				<div class="row">
					<?php include('template/editor.php'); ?>
				</div>
			</div>
			<div class="col-lg-4">
				<?php include('template/var.php'); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12"><h3>Preview:</h3></div>
		<div class="col-lg-12">
			<div v-html="getContentMail()" class="previewer"></div>
		</div>
	</div>
	<div class="row">
		<a class="col-lg-4 col-lg-offset-4 btn btn-success btn-lg" href="#" data-toggle="modal"
		   data-target="#mail-sender">
			Envoyer le mail
		</a>
	</div>
	<div class="modal fade" id="mail-sender">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">Validation de l'envoi du mail</h2>
					<button class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div v-html="getContentMail()" class="previewer" id="preview-modal-content"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-7 col-xs-offset-1">
							<div class="input-group">
								<span class="input-group-addon">Expediteur: </span>
								<select class="form-control" v-model.number="who">
									<option value="0">Moi (<?= Dh::getCurrent()->getLogin() ?>)</option>
									<option value="1">Le conseiller (<?= $this->dh->getConseiller()->getLogin() ?>)</option>
								</select>
								<span class="input-group-btn">
									<a class="btn btn-success " @click="sendMail()" data-dismiss="modal">
										<i class="fa fa-lg fa-paper-plane-o"></i>
									</a>
								</span>
							</div>
						</div>
						<a class="btn btn-danger col-xs-2 col-xs-offset-1" data-dismiss="modal"><i
									class="fa fa-lg fa-times"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="mail-success">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">Envoi du mail reussi</h2>
					<button class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							L'envoi du mail a &eacute;t&eacute; un succes !
						</div>
					</div>
					<div class="row">
						<a class="btn btn-success btn-lg col-lg-4 col-lg-offset-7" data-dismiss="modal"><i
									class="fa fa-lg fa-check"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
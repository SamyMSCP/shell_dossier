<?= $this->Nav ?>
<div class="containerPerso container-fluid" id="email-search">
	<div class="row">
		<div class="col-lg-12 text-center">
			<h3>Recherche par Mail/T&eacute;l&eacute;phone</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="input-group">
				<input class="form-control" type="text" v-model="searched_email" placeholder="Contenu a rechercher"
					   @keydown.enter="search_mail">
				<span class="input-group-btn">
					<div class="drowdown">
						<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
							Rechercher
							<span class="caret"></span>
						</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#" @click="search_mail"><i class="fa fa-lg fa-envelope-o"></i> - Mail</a></li>
						<li class=""><a href="#" @click="search_phone"><i class="fa fa-lg fa-phone"></i> - T&eacute;l&eacute;phone</a></li>
					</ul>
					</div>
				</span>
			</div>
		</div>
	</div>
	<div class="row" v-show="has_result">
		<div class="col-lg-8 col-lg-offset-2">
			<table class="table table-responsive text-center">
				<tr class="text-center">
					<td>
						<b>id</b>
					</td>
					<td>
						<b>Nom</b>
					</td>
					<td>
						<b>Acces profil</b>
					</td>
				</tr>
				<tr class="text-center" v-for="el in content">
					<td>
						{{ el.id }}
					</td>
					<td>
						{{ el.shortname }}
					</td>
					<td>
						<a class="btn btn-success" v-bind:href="el.url">Profil</a>
					</td>
				</tr>
			</table>

		</div>
	</div>
	<div class="row" v-if="!has_result">
		<div class="col-lg-offset-2 col-lg-8 text-center">
			<h4>Aucun resultat</h4>
			<h5>en cas de numero de telephone, peut-etre l'indicateur de pays est incorrect.</h5>
		</div>
	</div>
</div>

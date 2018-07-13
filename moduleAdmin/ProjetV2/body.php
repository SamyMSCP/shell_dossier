<div class='vueOngletProjet'>
	<button 
		class='btn-mscpi btn-orange'
		style='margin-left:auto;margin-right:auto;display:block;'
		onclick='window.location.href="?p=PageCreationProjet&client=<?=intval($_GET['client'])?>"' >
			CRÉER UN PROJET
	</button>
	<component-list-projet-noname :data='this.$store.state.mscpi.datas.Projet2.lst'></component-list-projet-noname>
	<div class="row">
		<h6 style="margin-top: 0px;">LES DIFFÉRENTES ÉTAPES D’UN PROJET</h6>
	</div>
	<div class="traitOrange"></div>
	<div class="infoProjetStatus">
		<div>
			<div>
				<img src="assets/EnCoursCreation-Orange.svg" alt="" >
				<div style="color:#ff9f1c">
					Projet en cours de création
				</div>
			</div>
			<p>
				Vous avez entamé la création d’un projet et nous en sommes heureux. Il ne vous reste que quelques étapes à finaliser avant de pouvoir déclencher votre projet.
			</p>
		</div>

		<div>
			<div>
				<img src="assets/Proposition_BleuClair.png" alt="">
				<div style="color:#1781e0;">
					Projet créé
				</div>
			</div>
			<p>
				Bravo, votre projet a été créé ! MeilleureSCPI.com va se charger de prendre contact avec vous dans les plus brefs délais.
			</p>
		</div>

		<div>
			<div>
				<img src="assets/ProjetReflexionPlan de travail 1.svg" alt="">
				<div style="color:#1781e0;">
					Projet en cours de réflexion
				</div>
			</div>
			<p>
				Vous et votre conseiller êtes en cours de finalisation sur les derniers détails de votre projet.
			</p>
		</div>

		<div>
			<div>
				<img src="assets/EnCoursRealisation-Bleu.svg" alt="">
				<div style="color:#1781e0;">
					Projet en cours de réalisation
				</div>
			</div>
			<p>
				Vous avez validé le projet auprès de votre conseiller, MeilleureSCPI.com se charge du reste !
			</p>
		</div>


		<div>
			<div>
				<img src="assets/Termine-Vert.svg" alt="">
				<div style="color:#20bf55;">
					Projet finalisé
				</div>
			</div>
			<p>
				Votre projet a été réalisé avec succès ! Vous êtes désormais détenteur de parts de SCPI que vous pouvez consulter dans la rubrique <b>Mon portefeuille.</b>
			</p>
		</div>

		<div>
			<div>
				<img src="assets/Annule-Gris.svg" alt="">
				<div style="color:#969696;">
					Projet annulé
				</div>
			</div>
			<p>
				Votre projet n’a pas abouti
			</p>
		</div>
	</div>
</div>

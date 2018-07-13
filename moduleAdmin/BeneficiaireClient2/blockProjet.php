<div v-if="onglet == 0" style="position: relative;display: flex;justify-content: center;align-items: center;">
	<div class="projetGlob2" style="width:100%;">
		<div v-for="elm in $store.getters.getProjetForBeneficiaire(selectedBeneficiaire.id_benf)" class="projetElement1">
			<div class="projetElement2" @click="showProjectDetails(elm)"  :class="{projectNotComplete: elm.etat_du_projet == -1 }">
				<h3>{{ elm.nom }}</h3>
				<div>
					<img v-if="elm.etat_du_projet >= 8" src="<?=$this->getPath()?>img/Dossiers-blanc_closed.png">
					<img v-else="elm.etat_du_projet >= 8" src="<?=$this->getPath()?>img/Dossiers-blanc_open.png">
				</div>
				<h2 v-if="elm.etat_du_projet >= 8" >
					FINALISE
				</h2>
				<h2 v-else>
					EN COURS
				</h2>
			</div>
		</div>
	</div>
</div>

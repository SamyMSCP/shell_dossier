<div class="vueDevtools">
	<component-devtools-noname>

		<div slot="PAGES">
			<div  v-for="(elm, key) in $store.state.mscpi.global.pages" class="pages_btn">
				<button @click='$store.commit("set_page", key)'>{{ elm.title }}</button>
			</div>
		</div>
		<div slot="ENTITY">
		
			<div class="block">
				<div class="entete">DONNEUR D'ORDRES</div>
				<?= ComponentListTable2Table::getHtmlTag(
					"DonneurDOrdre",
					[':data' => '$store.state.mscpi.datas.DonneurDOrdre.lst'])
				?>

				<div class="entete">editer</div>
				<?= ComponentTable2EditTable::getHtmlTag(
					"DonneurDOrdre",
					[':data' => '$store.state.mscpi.datas.DonneurDOrdre'])
				?>
			</div>

			<div class="block">
				<div class="entete">PERSONNE PHYSIQUES</div>
				<?= ComponentListTable2Table::getHtmlTag(
					"PersonnePhysique",
					[':data' => '$store.getters.getPersonnesPhysiquesForDonneurDOrdre'])
				?>

				<div class="entete">editer</div>
				<?= ComponentTable2EditTable::getHtmlTag(
					"PersonnePhysique",
					[':data' => '$store.state.mscpi.datas.PersonnePhysique'])
				?>
			</div>

			<div class="block">
				<div class="entete">BÉNÉFICIAIRES</div>
				<?= ComponentListTable2Table::getHtmlTag(
					"Beneficiaire2",
					[':data' => '$store.getters.getBeneficiaire2ForDonneurDOrdre'])
				?>
				<div class="entete">editer</div>
				<?= ComponentTable2EditTable::getHtmlTag(
					"Beneficiaire2",
					[':data' => '$store.state.mscpi.datas.Beneficiaire2'])
				?>
			</div>

			<div class="block">
				<div class="entete">PROJETS</div>
				<?= ComponentListTable2Table::getHtmlTag(
					"Projet2",
					[':data' => '$store.getters.getProjet2ForBeneficiaire2'])
				?>
				<div class="entete">editer</div>
				<?= ComponentTable2EditTable::getHtmlTag(
					"Projet2",
					[':data' => '$store.state.mscpi.datas.Projet2'])
				?>
			</div>

			<div class="block">
				<div class="entete">SITUATION PHYSIQUE</div>
				<?= ComponentListTable2Table::getHtmlTag(
					"SituationPhysique",
					[':data' => '$store.getters.getAllSituationPhysique'])
				?>
				<div class="entete">editer</div>
				<?= ComponentTable2EditTable::getHtmlTag(
					"SituationPhysique",
					[':data' => '$store.state.mscpi.datas.SituationPhysique'])
				?>
			</div>

			<div class="block">
				<div class="entete">PROFIL INVESTISSEUR</div>
				<?= ComponentListTable2Table::getHtmlTag(
					"ProfilInvestisseur2",
					[':data' => '$store.getters.getAllProfilInvestisseur2'])
				?>
				<div class="entete">editer</div>
				<?= ComponentTable2EditTable::getHtmlTag(
					"ProfilInvestisseur2",
					[':data' => '$store.state.mscpi.datas.ProfilInvestisseur2'])
				?>
			</div>

		</div>
	</component-devtools-noname>
</div>

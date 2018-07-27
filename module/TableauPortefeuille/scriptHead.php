
</script>

<script type="text/javascript" charset="utf-8">
	function showMsgBoxIfi() {
		//msgBox.show("Vous voulez générer le document pour quel résidence fiscale ?",[
		msgBox.show("Pouvez-vous nous indiquer votre résidence fiscale au 01/01/2018 ?",[
			{
				text: "France",
				action: function()
				{
					window.open('index.php?p=ShowValeurIfi')
				}
			},
			{
				text: "Autre",
				action: function() {
					window.open('index.php?p=ShowValeurIfi&expatrie=1')
				}
			}
		]);
	}
</script>

<script type="text/x-template" id="tableau_portefeuille_component">
	<div class='tableau_portefeuille'>
		<div class='barreTitre tableauportefeuillestyle'>
			<img src="assets/Portefeuille/Portefeuille-Blanc.svg" class="icon">
			<span> DÉTAILS DE MON PORTEFEUILLE </span>


			<div
				class="btn-mscpi-blanc txtDownloadRecap"
				<?php if ($this->nb_transac > 0 && $this->dh->getConfirmation() == "3") { ?>
					onclick="window.open('index.php?p=ShowPatrimoine')" 
				<?php } else { ?>
					onmouseover="display_tooltip('Information','Merci de valider votre numéro de téléphone et/ou votre mail pour accéder à votre récapitulatif.')"
				onmouseout="disable_msg()"<?php } ?>
			>
				<img src="<?= $this->getPath()?>img/telechargerblanc.png" alt="">
				<span >TÉLÉCHARGER UN RÉCAPITULATIF</span>
			</div> 
	<?php
		if (ENABLE_VALEUR_ISF && $this->dh->isf == 1) { 
			?>
			<div style='flex: 0 1 auto;' <?php if($this->nb_transac === 0) echo 'disabled'?> class="btn-tableau-orange btnIsf" onclick="showMsgBoxIfi()"><span >VALEUR IFI <?=date('Y')?></span></div>
	<?php } ?>

			<div class='btn-tableau-orange' @click='showRegroupement()'>
				<img src="/assets/cog/white.svg">
				GÉRER MON PORTEFEUILLE
			</div>
		</div>
		<div class='block-contenu' v-if="this.$store.getters.getAllTransactions.length > 0">
			<tableau-portefeuille-stats v-if='getTotalValorisation !== 0'></tableau-portefeuille-stats>
			<tableau-portefeuille-principal type_pro="Pleine" v-if='getCache.precalcul.havePleine'></tableau-portefeuille-principal>
			<tableau-portefeuille-principal type_pro="Nue" v-if='getCache.precalcul.haveNue'></tableau-portefeuille-principal>
			<tableau-portefeuille-principal type_pro="Usu" v-if='getCache.precalcul.haveUsu'></tableau-portefeuille-principal>
			<tableau-portefeuille-principal-potentielles
					type_pro="Pleine"
					v-if="this.$store.getters.getTransactionPotentiellesPleine.length > 0"
			>
			</tableau-portefeuille-principal-potentielles>
			<tableau-portefeuille-principal-potentielles
					type_pro="Nue"
					v-if="this.$store.getters.getTransactionPotentiellesNue.length > 0"
			>
			</tableau-portefeuille-principal-potentielles>
			<tableau-portefeuille-principal-potentielles
					type_pro="Usu"
					v-if="this.$store.getters.getTransactionPotentiellesUsu.length > 0"
			>


			</tableau-portefeuille-principal-potentielles>
            <div>
                <small>
										
					

                    <i class="fa fa-star text-primary" style="color: red"></i>: Transaction en nue-propriété arrivée à terme (remembrement en pleine propriété).<br/>
                    <i class="fa fa-star text-primary"></i>: Transaction usufruit arrivée à terme (extinction de l’usufruit).<br/>
                    <i class="text-warning fa fa-exclamation-triangle"></i>: Des informations sont manquantes sur la transaction.
                </small>
            </div>
			<div class='block_total'>
				<div class="total">
					PLEINE PROPRIÉTÉ + NUE-PROPRIÉTÉ + USUFRUIT
				</div>
				<div>
					TOTAL : {{ getCache.precalcul.ventePotentielle | euros }}
				</div>
			</div>
		</div>
		<div class='block-contenu' v-if="this.$store.getters.getAllTransactions.length == 0">
			<div class="portefeuile-vide">
				<div class="portefeuile-vide-texte">
					<br />
				Mon portefeuille est vide ?<br />Je peux dès à présent commencer à ajouter mes SCPI en cliquant sur :
				</div>
				<div class='btn-tableau-orange portefeuile-vide-bouton' @click='showRegroupement()' >
					<img src="/assets/cog/white.svg">
                    <div class="bouton-accueil">GÉRER MON PORTEFEUILLE</div>

				</div>
			</div>
		</div>

		<multi-action-modale></multi-action-modale>
		<modal-reinvest-scpi></modal-reinvest-scpi>
		<modal-vente-scpi></modal-vente-scpi>
		<modal-modifier-scpi></modal-modifier-scpi>
		<modal-intermediaire-scpi></modal-intermediaire-scpi>
		<tableau-transaction-edit></tableau-transaction-edit>
	</div>

</script>
<script>
	Vue.component(
		'tableau-portefeuille', {
			data: function () {
				return ({});
			},
			methods: {
				showRegroupement: function () {
					$('#tableau-transaction-regroupement-modal').modal('show');
				}
			},
			computed: {
			
				getTotalValorisation: function() {
					return (this.$store.state.dh.precalcul.precalcul.ventePotentielle);
				},

				getCache: function () {
					return (this.$store.state.dh.precalcul);
				}
			},
			<?php
			if (isset($GLOBALS['_GET']['mod']) && $GLOBALS['_GET']) {
				$id_transaction = intval($GLOBALS['_GET']['mod']);
				?>
				mounted: function() {
					console.log("SET_SELECTED_TRANSACTION", <?=$id_transaction?>);
					this.$store.dispatch("SET_SELECTED_TRANSACTION", <?=$id_transaction?>);
					$('#tableau-transaction-edit-modal').modal('show')
				},
				<?php
			}
			?>
			template: "#tableau_portefeuille_component"
		}
	);

	<?php include('composantTableauPrincipal.php');?>
	<?php include('composantTableauPrincipalPotentielles.php');?>
	<?php include('composantTableauEdition.php');?>
	<?php include('stats.php');?>
	<?php include('composantRegroupement.php');?>
	<?php include('composantReinvestScpi.php');?>
	<?php include('composantVenteScpi.php');?>
	<?php include('composantModifierScpi.php');?>
	<?php include('ComposantModaleIntermediaire.php');?>


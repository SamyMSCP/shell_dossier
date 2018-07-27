<?php
require_once("typeInput.php");
?>
</script>

<script type="text/x-template" id="selectScpiTemplate">
	<div class='input_component'>
		<select v-model='getData.id_scpi'   :class='{input_have_error: haveError}' :disabled="disabled">
			<?php
				foreach (Scpi::getForFrontStore() as $key => $elm) {
					?>
					<option :value='<?=$elm['id']?>'><?=str_replace("SCPI ", "", $elm['name'])?></option>
					<?php
				}
			?>
		</select>
		<transaction-error column='id_scpi'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-id_scpi',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectScpiTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['id_scpi'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectBeneficiaireTemplate">
	<div class='input_component'>
		<select v-model='getData.id_beneficiaire'  :class='{input_have_error: haveError}'  :disabled="disabled">
			<option v-for="ben in getList" :value="ben.id_benf">{{ ben.shortName }}</option>
		</select>
		<transaction-error column='id_beneficiaire'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-id_beneficiaire',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectBeneficiaireTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['id_beneficiaire'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			},
			getList: function() {
				return (this.$store.state.dh.Beneficiaires);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectConseillerTemplate">
	<div class='input_component'>
		<select v-model='getData.id_cons'  :class='{input_have_error: haveError}'  :disabled="disabled">
			<?php
				foreach (Dh::getConseillers(1) as $key => $elm) {
					?>
					<option :value='<?=$elm->id_dh?>'><?=$elm->getShortName()?></option>
					<?php
				}
			?>
		</select>
		<transaction-error column='id_cons'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-id_cons',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectConseillerTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['id_cons'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);

</script>
<script type="text/x-template" id="selectMarcheTemplate">
	<div class='input_component'>
        <select v-model='getData.marche'   :class='{input_have_error: haveError}'  :disabled="disabled">
            <option value='Primaire'>Primaire</option>
            <?php
            foreach (Transaction::getMarcheLst() as $elm) {
                ?>
                <option v-if="'<?=$elm?>' != 'Primaire'" value='<?=$elm?>'><?=$elm?></option>
                <?php
            }
            ?>
        </select>
		<transaction-error column='marche'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-marche',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectMarcheTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['marche'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectTypeproTemplate">
	<div class='input_component'>
		<select v-model='getData.type_pro'   :class='{input_have_error: haveError}'  :disabled="disabled">
			<option :value='null'></option>
			<?php
				foreach (Transaction::getTypeProLst() as $elm) {
					?>
					<option value='<?=$elm?>'><?=$elm?></option>
					<?php
				}
			?>
		</select>
		<transaction-error column='type_pro'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-typepro',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectTypeproTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['type_pro'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectClerepartitionTemplate">
	<div class='input_component'>
		<input-pourcent v-model='getData.cle_repartition'  :disabled="getData.type_pro == 'Pleine propriété' || getData.type_pro == null || disabled"   :class='{input_have_error: haveError}'/>
		<transaction-error column='cle_repartition'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-cle_repartition',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectClerepartitionTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['cle_repartition'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectSocieteTemplate">
	<div class='input_component'>
		<select v-model='getData.societe' :class='{input_have_error: haveError}'  :disabled="disabled">
			<option value="-">-</option>
			<option value="Société de gestion">une Société de gestion</option>
			<option value="CGPI">un CGPI</option>
			<option value="Banque">ma Banque</option>
			<option value="Assureur">mon Assureur</option>
		</select>
		<transaction-error column='societe'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-societe',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectSocieteTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['societe'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>


<script type="text/x-template" id="selectInfoTransTemplate">
	<div class='input_component'>
		<input v-model='getData.info_trans'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='info_trans'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-info_trans',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectInfoTransTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['info_trans'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectDemembrementTemplate">
	<div class='input_component'>
		<input v-model='getData.demembrement' max='20' min='1' type="number"  :disabled="getData.type_pro == 'Pleine propriété' || getData.type_pro == null || disabled"   :class='{input_have_error: haveError}'/>
		<transaction-error column='demembrement'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-demembrement',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectDemembrementTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['demembrement'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectNbrpartTemplate">
	<div class='input_component'>
		<input v-model='getData.nbr_part'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='nbr_part'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-nbr_part',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectNbrpartTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['nbr_part'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectPrixpartTemplate">
	<div class='input_component'>
		<input-euros v-model='getData.prix_part'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='prix_part'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-prix_part',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectPrixpartTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['prix_part'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectEnrdateTemplate">
	<div class='input_component'>
		<my-datepicker :id='id' v-model='getData.enr_date'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='enr_date'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-enr_date',
	{
		props: [
			'data',
			'disabled',
			'id'
		],
		template: "#selectEnrdateTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['enr_date'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="transactionErrorTemplate">
	<div v-if="typeof getError != 'undefined'" class='input_error'>{{ getError }}</div>
</script>

<script type="text/javascript" charset="utf-8">

Vue.component(
	'transaction-error',
	{
		props: [ 'column' ],
		template: "#transactionErrorTemplate",
		computed: {
			getError: function() {
				return (this.$store.getters.getTransactionError[this.column]);
			},
		},
	}
);


</script>

<script type="text/x-template" id="selectMontantempruntTemplate">
	<div class='input_component'>
		<input-euros v-model='getData.montant_emprunt'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='montant_emprunt'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-montant_emprunt',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectMontantempruntTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['montant_emprunt'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>






<script type="text/x-template" id="selectTypeempruntTemplate">
	<div class='input_component'>
		<select v-model='getData.type_emprunt'   :class='{input_have_error: haveError}'  :disabled="disabled">
			<option :value='null'>-</option>
			<option value='Amortissable'>Amortissable</option>
			<option value='In Fine'>In Fine</option>
		</select>
		<transaction-error column='type_emprunt'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-type_emprunt',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectTypeempruntTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['type_emprunt'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>


<script type="text/x-template" id="selectDureeempruntTemplate">
	<div class='input_component'>
		<input type='number' min="0" v-model='getData.duree_emprunt'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='duree_emprunt'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-duree_emprunt',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectDureeempruntTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['duree_emprunt'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectDatedebutempruntTemplate">
	<div class='input_component'>
		<my-datepicker id='date_debut_emprunt_editor' v-model='getData.date_debut_emprunt'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='date_debut_emprunt'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-date_debut_emprunt',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectDatedebutempruntTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['date_debut_emprunt'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectTauxempruntTemplate">
	<div class='input_component'>
		<input-pourcent v-model='getData.taux_emprunt'   :class='{input_have_error: haveError}'  :disabled="disabled"/>
		<transaction-error column='taux_emprunt'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-taux_emprunt',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectTauxempruntTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['taux_emprunt'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>

<script type="text/x-template" id="selectMensualiteempruntTemplate">
	<div class='input_component'>
		<input-euros v-model='getData.mensualite_emprunt'   :class='{input_have_error: haveError}' :disabled="disabled"/>
		<transaction-error column='mensualite_emprunt'> </transaction-error>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
Vue.component(
	'edit-transaction-mensualite_emprunt',
	{
		props: [
			'data',
			'disabled'
		],
		template: "#selectMensualiteempruntTemplate",
		computed: {
			haveError: function() {
				return (typeof this.$store.getters.getTransactionError['mensualite_emprunt'] != 'undefined');
			},
			getData: function() {
				return (this.data);
			}
		}
	}
);
</script>



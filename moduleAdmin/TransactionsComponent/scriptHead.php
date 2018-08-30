</script>
<script type="text/x-template" id="transac_tpl">
	<?php require_once("template.php"); ?>
</script>
<script type="text/x-template" id="courriers_template">
	<?php require_once("courriers.php"); ?>
</script>
<script type="text/x-template" id="select_template">
	<?php require_once("template_select.php"); ?>
</script>

<script type="text/javascript">

	Vue.component('transaction',
	{
		data : function(){
			return {
				/*'$store.state.transactions.selectedTransaction' : {
					id: null,
					shortName: null,
					scpi: null,
					conseiller: null,
					info_trans: null,
					marcher: null,
					cle_repartition: null,
					type_pro: null,
					dt: null,
					nbr_part: null,
					prix_part: null,
					enr_date: 0,
					montant_emprunt: null,
					type_emprunt: null,
					duree_emprunt: null,
					date_debut_emprunt: 0,
					taux_emprunt: null,
					mensualite_emprunt: null,
					date_entre_joui: null,
					date_fin_joui: null,
					date_entre_joui_calc: null,
					date_fin_joui_calc: null,
					date_bs: null,
					commentaires: null
				},*/
				isEditable :  true,
				lstConseiller: <?= json_encode($this->lstConseiller) ?>,
				SomethingChanged: false,
				formFileIdTypeDocument: null,
			}
		},
		computed:
		{
			editableIfNotPleinePro: function()
			{
				//if (this.isEditable && this.$store.state.transactions.selectedTransaction.type_pro != "Pleine propriété")
				if (this.isEditable && this.$store.state.transactions.selectedTransaction.type_pro != "Pleine propriété")
					return true;
				return false;
			},
			editableIfBuy: function()
			{
				if (this.isEditable && this.$store.state.transactions.selectedTransaction.type == 'A')
					return true;
				return false;
			}
		},
		methods: {
			isNumValid: function( num, mandatory ){
				if (mandatory && (typeof num != "string" || num == "" || parseFloat(num) == 0))
					return "data_invalid";
				if (!num.match(/^\d{1,2}((\.|,)(\d{1,5}))?$/))
					return "data_invalid";
			},
			isPleinePro: function( type_pro )
			{
				if (type_pro == "Pleine propriété")
					return true;
				return false;
			},
			getDoc: function( transaction, id_type_document )
			{
				if (transaction.docs[id_type_document].length > 0)
					window.open('ajax_request_client.php?req=RestDocuments&id_doc=' + transaction.docs[id_type_document][0].id);
				else
				{
					this.formFileIdTypeDocument = id_type_document;
					this.$refs.formFileInput.click();
				}
			},
			getDocClass: function( elt )
			{
				if (elt === "validated")
					return "docu_bouton_verified";
				else if (elt === "pending")
					return "docu_bouton_uploaded";
				return "docu_bouton";
			},
			hasDoc: function( id_type_document )
			{
				var doc = this.$store.getters.getHaveDocument(8, this.$store.state.transactions.selectedTransaction.id, id_type_document);
				if (typeof doc != 'undefined' && doc.length > 0)
				{
					if (Number(doc[0].validated_by) != 0)
						return "validated";
					return "pending";
				}
				return "none";
			},
			montantInvestissement: function(prix_part, nbr_part, cle_repartition)
			{
				if (cle_repartition == null)
					cle_repartition = 100;
				if (typeof prix_part == "string" && typeof nbr_part == "string")
					return (parseFloat(prix_part.replace(',','.')) * parseFloat(nbr_part.replace(',','.')) * ( cle_repartition / 100));
				return '-';
			},
			toggleEditable: function( state_transaction )
			{
				this.isEditable = (this.isEditable)? 0 : 1;
			},
			doneOrCancelled: function(done, cancelled)
			{
				if (done)
					return 1;
				if (cancelled)
					return -1;
				return null;
			},
			getStatusTitle: function(status, statusList)
			{
				var status_sup = status.substr(0,1);
				var status_sub = status.substr(2,1);
				return statusList[status_sup][status_sub].title;
			},
			getStatuslineColor: function(nb, status)
			{
				var status_sup = status.substr(0,1);
				//var status_sub = status.substr(2,1);
				if (this.doneOrCancelled == -1 || status_sup == 7)
					return "timeline-red";
				if (nb > status_sup || (nb == 7 && this.doneOrCancelled))
					return "timeline-grey";
				if (nb == status_sup && nb != 6)
					return "timeline-orange";
				if (this.doneOrCancelled == 1 || nb <= status_sup)
					return "timeline-green";
			},
			getStatusLineColorNonMscpi: function(nb, done )
			{
				if (done)
					return "timeline-green";
				else if (nb == 1)
					return "timeline-orange";
				return "timeline-grey";
			},
			getTransactionCreationDate: function( status )
			{
				if (typeof status[0] != 'undefined' && status[0] != null && typeof status[0].date_creation != 'undefined')
					return status[0].date_creation;
				return null;
			},
			returnHyphenIfEmpty: function( $data )
			{
				if (typeof $data == 'undefined' || $data == null || $data == "" || $data == 0)
					return "-";
				return $data;
			},
			ifEmpty: function( $data )
			{
				if (typeof $data == 'undefined' || $data == null || $data == "" || $data == 0)
					return true;
				return false;
			},
			setTr: function()
			{
				this.$store.dispatch('TRANSACTIONS_UPDATE', this.$store.state.transactions.selectedTransaction)
					.then(
						function(res)
						{
							msgBox.show("Changements enregistrés !");
							//$('#modal_transactio').modal('hide');
						},
						function(res){
							//msgBox.show("Erreur");
						}
					);
			},
			delTr: function()
			{
				var that = this;
				msgBox.show("Voulez-vous vraiment supprimer cette transaction ?",[
				{
					text: "Oui",
					action: function()
					{
						setTimeout(function(){
						 that.$store.dispatch('TRANSACTIONS_DELETE', that.$store.state.transactions.selectedTransaction)
						.then(
							function(res)
							{
								msgBox.show("Transaction supprimée !");
								$('#modal_transactio').modal('hide');
							},
							function(res){
								//msgBox.show("Erreur");
							}
						)}, 1000);
					}
				},
				{
					text: "Non",
					action: function() {  }
				}
				]);
			},
			forceGrey: function( curr_key )
			{
				if (curr_key == 6 && this.$store.state.transactions.selectedTransaction.status_trans.substr(0,1) == "6")
					return 'forcegrey';
				return '';
			},
		},
		mounted: function ()
		{
			<?php if (isset($GLOBALS['GET']['transac'])) { ?>
				this.$store.commit("changeSelect", <?=$GLOBALS['GET']['transac']?>);
			<?php } ?>
			this.$watch('$store.state.transactions.selectedTransaction',function() {
				if (typeof this.$store.state.transactions.selectedTransaction != 'undefined')
				{
					if (this.$store.state.transactions.selectedTransaction.type_pro == "Pleine propriété")
					{
						this.$store.state.transactions.selectedTransaction.cle_repartition = null;
						this.$store.state.transactions.selectedTransaction.dt = null;
					}
				}
				},
				{deep: true});
		},
		template: "#transac_tpl"
	});

	<?php
			function sort_listTemplate($a) {
				return($a->classname == "courrier");
			}

			$ret = (json_encode(array_filter($this->listTemplates, "sort_listTemplate")));
	?>
	Vue.component('courriersComponent', {
		template: `#courriers_template`,
		data: function () {

            return ({

                contact: "",
				civilite: "Monsieur",
				courrier_selected: 0,
				addresse: {
					societe: "js",
                    nomDeLaVoie: "",
                    numeroRue: "",
					ville: "",
                    zip: "",
					full: ""
				},
                prenom: "",
                nomFamille: "",
                nameGestion:"",
                rue: "",
                ok:"",
                bebe: "",
                adresse:"",
				courriers: <?=$ret?>,
        });

        }, //$store.state.transactions.selectedTransaction.id_scpi

        methods: {
            showCourriers: function(id) {
              //  this.ok = id;

this.ok = id;
                this.bebe = this.$store.state.scpi.lst;
              for(var i = 0; i < this.bebe.length; i++){
if (this.bebe[i].id == this.ok) {
    this.addresse.ville = this.bebe[i].societeDeGestionAdresse.ville;
    this.nameGestion = this.bebe[i].societeDeGestion.name;
    this.addresse.zip = this.bebe[i].societeDeGestionAdresse.zip;
    this.addresse.numeroRue = this.bebe[i].societeDeGestionAdresse.numeroRue;
    this.addresse.nomDeLaVoie = this.bebe[i].societeDeGestionAdresse.nomDeLaVoie;

}


}


              /*  var trie = [
                ];

                for(var i = 0; i < this.bebe.length; i++){

                   // if (this.bebe[i].id == this.ok) {
                        console.log('ok c good');
                        this.addresse.ville = this.bebe[i].societeDeGestionAdresse.ville;
                        this.addresse.zip = this.bebe[i].societeDeGestionAdresse.zip;
                        this.addresse.numeroRue = this.bebe[i].societeDeGestionAdresse.numeroRue;
                        this.addresse.nomDeLaVoie = this.bebe[i].societeDeGestionAdresse.nomDeLaVoie;



                        /*

                        complementAdresse
                        extension
                        nomDeLaVoie
                        numeroRue
                        pays
                        typeDeVoie
                        ville
                        zip

if (this.bebe[i].societeDeGestionAdresse.ville == null ||
    this.bebe[i].societeDeGestionAdresse.extension == null ||
    this.bebe[i].societeDeGestionAdresse.nomDeLaVoie == null ||
    this.bebe[i].societeDeGestionAdresse.numeroRue == null ||
    this.bebe[i].societeDeGestionAdresse.pays == null ||
    this.bebe[i].societeDeGestionAdresse.typeDeVoie == null ||
    this.bebe[i].societeDeGestionAdresse.ville == null ||
    this.bebe[i].societeDeGestionAdresse.zip == null ) {
    trie.push("-------------");
    trie.push("-------------");

    trie.push(this.bebe[i].societeDeGestionName);
    trie.push(this.bebe[i].societeDeGestionId);
}

if (this.bebe[i].societeDeGestionAdresse.ville == null){
    trie.push("Il manque la ville");

}

                    if (this.bebe[i].societeDeGestionAdresse.complementAdresse == null){
                        trie.push("Il manque le complementAdresse");

                    }
                    if (this.bebe[i].societeDeGestionAdresse.extension == null){
                        trie.push("Il manque l extension");

                    }

                    if (this.bebe[i].societeDeGestionAdresse.nomDeLaVoie == null){
                        trie.push("Il manque le nomDeLaVoie");

                    }

                    if (this.bebe[i].societeDeGestionAdresse.numeroRue == null){
                        trie.push("Il manque le numeroRue");

                    }

                    if (this.bebe[i].societeDeGestionAdresse.pays == null){
                        trie.push("Il manque le pays");

                    }

                    if (this.bebe[i].societeDeGestionAdresse.typeDeVoie == null){
                        trie.push("Il manque le typeDeVoie");

                    }

                    if (this.bebe[i].societeDeGestionAdresse.ville == null){
                        trie.push("Il manque la ville");

                    }

                    if (this.bebe[i].societeDeGestionAdresse.zip == null){
                        trie.push("Il manque le zip");

                    }


                   // }


                }

                console.log(trie); */

                $("#modal_transactio").animate({ scrollTop: 0 }, "slow");
                $('#modal-courrier').modal();
            },
		},
		computed: {



            get_url: function () {
				var url = "?p=Courriers&c=" +  this.courrier_selected;
				url += '&transac=' + this.$store.state.transactions.selectedTransaction.id;
				url += '&contact=' + this.civilite + ' ' + this.contact;
				url += '&nomFamille=' + this.nomFamille;
				url += '&prenom=' + this.prenom;
				url += "&ville=" + this.addresse.ville;
                url += '&zip=' + this.addresse.zip ;
                url += '&numeroRue=' + this.addresse.numeroRue ;
                url += '&nomDeLaVoie=' +  this.addresse.nomDeLaVoie ;
                url += '&nameGestion=' +  this.nameGestion ;

                return url;
			},



		}

	});

	Vue.component('selectStatus', {
		template: '#select_template',
		data: function () {
			return ({
				selected: "0-0",
				rules: JSON.parse(`<?= file_get_contents(__DIR__ . '/config.json') ?>`)
			});
		},
		methods: {
			set_selected: function () {
				this.$store.state.transactions.selectedTransaction.status_trans = this.selected;
			}
		},
		watch: {
			selected: function(val, old) {
				// const val = val_new;
				if (val === old)
					return;
				this.rules.forEach((rule) => {
					if (rule.type === "lock") {
						let condition = rule.condition.split(":");
						let action = rule.action.split(":");

						var test_old = old.match(action[0]);
						var test_val = val.match(action[1]);

						if (test_old !== null && test_val !== null) {
							var is_ok = false;
							if (condition[0] === "Document") {
								if (typeof this.$store.state.transactions.selectedTransaction.docs[parseInt(condition[1])] !== "undefined"){
									if (this.$store.state.transactions.selectedTransaction.docs[parseInt(condition[1])].length > 0){
										is_ok = true;
									}
								}
							}
							if (!is_ok) {
								swal({
									title: "Impossible !",
									html: "Une condition est invalide.<br>Vérifiez que tous les documents nécessaires sont bien upload",
									type: "error",
									width: '720px'
								});
								this.selected = old;
							}
						}
					}
					else if (rule.type === "event") {
						var action= rule.action.split('.');
						var condition = rule.condition.split(':');
						var test_old = old.match(condition[0]);
						var test_val = val.match(condition[1]);
						if (test_old !== null && test_val !== null) {
							//IF CHANGE IS OK
							if (action[0] === "php"){
								if (action[1] === "mail"){
									swal({
										title: "Envoyer un mail ?",
										text: "Voulez vous envoyer le mail \"" + action[2] + "\"",
										type: "question",
										showCancelButton: true,
										showConfirmButton: true
									}).then((res) => {
										if (typeof res.value !== "undefined" && res.value === true) {
											$(".modal").modal('hide');
											showOnglet('MAILS');
											eval('init_MailClientSend();');

											let trans = this.$store.state.transactions.selectedTransaction;
											let scpi = this.$store.state.scpi.lst.find((el) => { return (trans.id_scpi === el.id)}).name;
											let nb_part = trans.nbr_part;
											let montant = trans.montantInvestissement.toLocaleString("fr", {style: "currency", currency: "EUR"}) + "";

											mail_app.add_var_from_outside({nom: "transaction.scpi", valeur: scpi}, "supp");
											mail_app.add_var_from_outside({nom: "transaction.parts", valeur: nb_part}, "supp");
											mail_app.add_var_from_outside({nom: "transaction.total", valeur: montant}, "supp");
											mail_app.add_var_from_outside({nom: "transaction.missing", valeur: ""}, "supp");
											mail_app.add_var_from_outside({nom: "transaction.date_valid", valeur: ""}, "supp");
											mail_app.change_mail_from_outside(action[2]);
										}
									})
								}
							}
						}
						// console.groupEnd();
					}
					// console.groupEnd();
				});
				this.$store.state.transactions.selectedTransaction.status_trans = this.selected;
			}
		}

	});

</script>
<script type="text/x-template" id="transac_tpl">
	<?php require_once("template/modale_template.php"); ?>
</script>
<script type="text/javascript">
	Vue.component('transaction',
	{
		data : function(){
			return {
				'editableTransaction' : {
					id: null,
					id_beneficiaire: null,
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
					mensualite_emprunt: null
				},
				'isEditable' : true,
				'investCredit': false,
				'formFileIdTypeDocument': null
			}
		},
		computed:
		{
			hasCreditInfo: function()
			{
				var transaction = this.$store.state.transactions.selectedTransaction;
				if (this.investCredit || parseInt(transaction.montant_emprunt) ||  parseInt(transaction.type_emprunt) ||  parseInt(transaction.duree_emprunt) ||  parseInt(transaction.date_debut_emprunt) ||  parseInt(transaction.taux_emprunt) ||  parseInt(transaction.mensualite_emprunt))
				{
					return true;
				}
				return false;
			},
			editableIfNotPleinePro: function()
			{
				if (this.isEditable && this.$store.state.transactions.selectedTransaction.type_pro != "Pleine propriété")
					return true;
				return false;
			},
			editableIfBuy: function()
			{
				if (this.isEditable && this.$store.state.transactions.selectedTransaction.type_transaction == 'A')
					return true;
				return false;
			}
		},
		methods: {
			isNumValid: function( num, mandatory )
			{
				if (mandatory && (typeof num == "undefined" || num == null || parseFloat(num) == 0))
					return "data_invalid";
				if (typeof num != "undefined" && num != null)
				{
					if (typeof num == "number")
						num = num.toString();
					if (parseFloat(num) > 0 && !num.match(/^\d{1,}((\.|,)(\d{1,5}))?$/))
						return "data_invalid";
				}
			},
			Undo: function()
			{
				this.isEditable = true;
			},
			isPleinePro: function( type_pro )
			{
				if ((!this.isEditable && type_pro == "Pleine propriété")
					|| (this.isEditable && this.$store.state.transactions.selectedTransaction.type_pro == "Pleine propriété"))
					return true;
				return false;
			},
			sendDoc: function( event )
			{
				if (this.$refs.formFileInput.files.length)
				{
					var FD = new FormData(this.$refs.formFile);
					FD.set('data[id_transaction]', this.$store.state.transactions.selectedTransaction.id);
					FD.set('data[id_type_document]', this.formFileIdTypeDocument);
					showLoading();
					this.$store.dispatch('TRANSACTIONS_ADD_DOCUMENT', FD ).then(
						function(res) { $("#loading").css("display", "none"); },
						function(res) { $("#loading").css("display", "none"); });
				}
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
				if (elt === 1)
					return "docu_bouton_verified";
				else if (elt === 0)
					return "docu_bouton_uploaded";
				return "docu_bouton";
			},
			hasDoc: function( transaction, id_type_document )
			{
				if (transaction.docs[id_type_document].length > 0)
				{
					if (Number(transaction.docs[id_type_document][0].validated_by) != 0)
						return 1;
					return 0;
				}
				return -1;
			},
			nbDocs: function( transaction )
			{
				var nb = 0;
				Object.keys(transaction.docs).forEach(function(id_type_doc)
				{
					nb += transaction.docs[id_type_doc].length;
				});
				return nb;
			},
			montantInvestissement: function(prix_part, nbr_part, cle_repartition)
			{
				if (typeof nbr_part == String)
					nbr_part = Number(nbr_part.replace(',','.'));
				if (typeof prix_part == String)
					prix_part = Number(prix_part.replace(',','.'));
				//return prix_part * nbr_part * (100 / cle_repartition);
				return prix_part * nbr_part * (cle_repartition / 100);
			},
			toggleEditable: function( state_transaction )
			{
				if ((this.isEditable = (this.isEditable)? 0 : 1))
					this.editableTransaction = Object.assign(this.editableTransaction, state_transaction);
			},
			doneOrCancelled: function(done, cancelled)
			{
				if (done)
					return 1;
				if (cancelled)
					return -1;
				return null;
			},
			getStatuslineColor: function(nb, status, doneOrCancelled)
			{
				var status_sup = status.substr(0,1);
				//var status_sub = status.substr(2,1);
				if (doneOrCancelled == -1 || status_sup == 7)
					return "timeline-red";
				if (nb > status_sup || (nb == 7 && doneOrCancelled))
					return "timeline-grey";
				if (nb == status_sup && nb != 6)
					return "timeline-orange";
				if (doneOrCancelled == 1 || nb <= status_sup)
					return "timeline-green";
			},
			/*getStatusLineColorNonMscpi: function(nb, done )
			{
				if (done)
					return "timeline-green";
				else if (nb == 1)
					return "timeline-orange";
				return "timeline-grey";
			},*/
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
			saveTr: function()
			{
				if (store.state.transactions.selectedTransaction.enr_date === 0 || isNaN(store.state.transactions.selectedTransaction.enr_date)) {
					swal({
						title: "La date d'enregistrement semble incorrecte...",
						type: "error"
					});
					return ;
				}
				var that = this;
				this.$store.dispatch('TRANSACTIONS_UPDATE', store.state.transactions.selectedTransaction)
					.then(
						function(res)
						{
							// that.isEditable = false;
							// msgBox.show("Changements enregistrés !");
							$('#modal_transactio').modal('hide');
						},
						function(res){
							//msgBox.show("Erreur");
						}
					);
			},

		},
		mounted: function (){
			var self = this;
			$('#modal_transactio').modal('handleUpdate');
			this.$watch('editableTransaction',
				function() {
					if (this.$store.state.transactions.selectedTransaction.type_pro == "Pleine propriété")
					{
						this.$store.state.transactions.selectedTransaction.cle_repartition = null;
						this.$store.state.transactions.selectedTransaction.dt = null;
					}
				},
				{deep: true}
			);
		},
		template: "#transac_tpl"
	});

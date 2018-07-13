</script>
<script type = "text/x-template" id="modale-add-scpi-template">
<?php require_once("template/modale_add_scpi.php"); ?>
</script>

<script type="text/javascript">

	Vue.component("modaleAddScpi", {
		template: "#modale-add-scpi-template",
		data: function () {
			return {
				scpi: -1,
				parts: 0,
				type_pro: "Pleine propriété",
				cle_rep: 0.0,
				type_dem: "Temporaire",
				dem_time: 0,
				details: {
					enabled: false,
					date_enr: "",
					prix_part: 0.0,
					marcher: "-",
					trans_avec: 0,
					info_comp: "",
					emprunt: {
						montant: 0.0,
						duree: 0,
						date_debut: "",
						taux: 0.0
					}
				}
			}
		},
		methods: {
			add_scpi: function () {
				$("#add_scpi").modal("hide");
				var self = this;
				if (self.prepare_create != {}){

                    // console.log(self.prepare_create);
					swal.queue([{
						title: "Êtes-vous sûr(e) de vouloir ajouter la transaction à votre portefeuille ?",
						type: "question",


						allowOutsideClick: () => !swal.isLoading(),
						showCancelButton: true,
						cancelButtonText: "Non",
						confirmButtonText: "Oui",
						showLoaderOnConfirm: true,
						preConfirm: () => {
							return store.dispatch('TRANSACTIONS_CREATE', self.prepare_create).then(() => {
								self.reset();
								store.dispatch('TRANSACTIONS_READ_ALL', {'data': "dataaaaaa"});
								store.dispatch('DH_RELOAD_PRECALCUL', {'data': "dataaaaaa"});
								swal.insertQueueStep({
									type: "success",
									title: "Félicitations pour l'ajout de votre transaction !",
									timer: 3000,
									showConfirmButton: false
								});
							}).catch((res) => {
								var t = (typeof res.body.err !== "undefined") ? res.body.err : "Réessayez plus tard ou contactez un conseiller";
								swal.insertQueueStep({
									type: 'error',
									title: "Impossible d'ajouter la SCPI",
									text: t,
									preConfirm: () => {
										$("#add_scpi").modal("show");
									}
								})
                                console.log("rentre dans catch");

                            })

						}
					}]).then((result) => {
						if (result.dismiss === "cancel")
							$("#add_scpi").modal("show");
                            console.log("rentre dans then");

                    })
				} else {
					swal({
						title: "Les valeurs semblent incorrect...",
						text: "Complétez le formulaire integralement avant de pouvoir valider",
						type: "error"
					}).then (() => { $("#add_scpi").modal("show"); });
				}
			},
			reset: function () {
				this.scpi = -1;
				this.parts = 0;
				this.type_pro = "Pleine propriété";
				this.cle_rep = 0.0;
				this.type_dem = "Temporaire";
				this.dem_time = 0;
				this.details.enabled = false;
				this.details.date_enr = "";
				this.details.prix_part = 0.0;
				this.details.marcher = "-";
				this.details.trans_avec = 0;
				this.details.info_comp = "";
				this.details.emprunt.montant = 0.0;
				this.details.emprunt.duree = 0;
				this.details.emprunt.date_debut = "";
				this.details.emprunt.taux = 0.0;
			},
			setScpi: function(x) {
				this.scpi = x;
			}
		},
		computed: {
			prepare_create: function() {
				if (!this.nbr_parts_valid ||
				!this.type_pro_valid)
					return {};
				var ret = {
					scpi: this.scpi,
					part: this.parts,
					propriete: this.type_pro,
					marche: this.details.marcher,
					duree: this.dem_time
				};
				// if (this.details.emprunt.date_debut !== "")
				ret = Object.assign(ret, {date_debut_emprunt: this.details.emprunt.date_debut});
				ret = Object.assign(ret, {date: this.details.date_enr});
				if (this.type_pro === "Usufruit" || this.type_pro === "Nue propriété")
					ret = Object.assign(ret, {cle: "" + this.cle_rep});
				else
					ret = Object.assign(ret, {cle: "100.0"});
				ret = Object.assign(ret, {prix: this.details.prix_part});
				ret = Object.assign(ret, {type_demembrement: this.type_dem});
				ret = Object.assign(ret, {taux_emprunt: this.details.emprunt.taux});//float
				ret = Object.assign(ret, {mensualite_emprunt: this.details.emprunt.duree});//A calculer

				return ret;
			},
			get_placeholder_who: function () {
				if (this.details.trans_avec === 1)
					return "Avec la société de gestion";
				return "Information Complémentaire...";
			},
			nbr_parts_valid: function () {
				return (this.parts > 0)
			},
			type_pro_valid: function() {
				return (true);
				// return (this.type_pro >= 0 && this.type_pro <= 2)
			},
			cle_rep_valid: function() {
				return (typeof this.cle_rep === "number" && this.cle_rep > 0.0 && this.cle_rep < 100.0)
			},
			type_dem_valid: function() {
				return (this.type_dem === 0 || this.type_dem === 1)
			},
			dure_dem_valid: function() {
				return (typeof this.dem_time === "number" && this.dem_time !== 0)
			},
			date_enr_valid: function() {
				return (moment(this.details.date_enr, "DD/MM/YYYY", true).isValid())
			},
			prix_part_valid: function() {
				return (this.details.prix_part > 0.0)
			},
			type_marcher_valid: function () {
				return (this.details.marcher === "Primaire" || this.details.marcher === "Secondaire" || this.details.marcher === "Gré à Gré")
			},
			trans_avec_valid: function () {
				return (this.details.trans_avec > 0)
			},
			duree_emprunt_valid: function () {
				return (this.details.emprunt.duree > 0)
			},
			date_emprunt_valid: function() {
				return (moment(this.details.emprunt.date_debut, "DD/MM/YYYY", true).isValid())
			},
			taux_emprunt_valid: function() {
				return (this.details.emprunt.taux > 0);
			}
		},
		filters: {
			money: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
			},
			percent: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
			}
		}
	});
</script>
<script type = "text/javascript" charset = "utf-8" >

	function init_MailClientSend() {
	}


<?php
	$table = new CommunicationTemplate();
	$ret = $table->getTemplateSendToClient();
	$ret = (json_encode($ret));
?>

//		template_lst: [{name: "test", value:"##CONTACT##"}, {name: "simple", value:"#header#<br>#ajd#<br>#contact#<br>#footer#"}],

/*
 * IMPORTANT:
 * PLEASE DO NOT RENAME THIS VAR
 * Called from /moduleAdmin/TransactionsComponent/scriptHead.php:330-350
 * It's used for change the current selected mail when we change a transaction state and want to send a mail.
 * Called from real name
 */
var mail_app = new Vue({
	el: ".vue-app-mailer",
	data: {
		mail_content: "",
		subject: "",
		selected: "0",
		who: 0,
		template_lst: (<?= $ret ?>),
		var_toadd: {nom: "", valeur: "", edit: false},
		var_list: [
			{nom: "header", valeur: "Cher #client#,", edit: false},
			{nom: "message", valeur: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", edit: false},
			{
				nom: "footer",
				valeur: "<br>Bien à vous, #moi# <br><hr/>Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z Adresse e-mail : contact@meilleurescpi.com - Site internet : MeilleureSCPI.com - Tél : 0805 696 022 (appel gratuit depuis un fixe) Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : reclamation@meilleurescpi.com - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce lien) Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants : - dix jours ouvrables maximum à compter de la réception de la réclamation, pour accuser réception, sauf si la réponse elle-même est apportée au client dans ce délai ; - deux mois maximum entre la date de réception de la réclamation et la date d’envoi de la réponse au client sauf survenance de circonstances particulières dûment justifiées. Le réclamant peut notamment s’adresser à : L’ACPR , L’AMF, L’ANACOFI. MeilleureSCPI.com est inscrit à l’ORIAS sous le numéro d’immatriculation 13000814 (www.orias.fr) au titre des activités réglementées suivantes : - Conseiller en investissement financier (CIF) enregistré auprès de l’ANACOFI-CIF, association agréée par l’Autorité des Marchés Financiers (AMF) - Courtier d'assurance ou de réassurance (COA) positionné dans la catégorie b Art. L520-1 II 1° du Code des assurances - Mandataire d’intermédiaire d’assurance (MIA) - Mandataire non exclusif en opérations de banque et en services de paiement (MOBSP) La société ne peut recevoir aucun fonds, effets ou valeurs. MeilleureSCPI.com dispose, conformément à la loi et au code de bonne conduite de l’ANACOFI-CIF, d’une couverture en Responsabilité Civile Professionnelle suffisante couvrant ses diverses activités.",
				edit: false
			},
			{nom: "client", valeur: "<?=$this->dh->getShortName() ?>", edit: false},
			{nom: "moi", valeur: "<?=$this->collaborateur->getShortName() ?>", edit: false},
			{nom: "contact", valeur: "Je reste joignable par mail: #mail#<br>\ " +
			"Ainsi qu'au telephone aux numeros suivant: #phone# &nbsp;&nbsp;&nbsp;&nbsp; #fixe#", edit: false},
			{nom: "mail", valeur: "<?=$this->collaborateur->getLogin() ?>", edit: false},
			{nom: "phone", valeur: "<?=$this->collaborateur->getPersonnePhysique()->getPhone() ?>", edit: false},
			{nom: "fixe", valeur: "<?=$this->collaborateur->getPersonnePhysique()->getPhoneFixe() ?>", edit: false},
			{nom: "host", valeur: "<?= $_SERVER['HTTP_HOST'] ?>", edit: false},
			{nom: "ajd", valeur: moment().format("DD/MM/YYYY"), edit: false},
		],
		var_supplement: [
			{nom: "recipient.short_name", valeur: "#client#", edit: false},
			{nom: "recipient.date_du_jour", valeur: "#ajd#", edit: false},
			{nom: "recipient.conseiller", valeur: "#moi#", edit: false},
			{nom: "recipient.conseiller_telephone", valeur: "#phone#", edit: false},
			{nom: "recipient.conseiller_mail", valeur: "#mail#", edit: false},
		]
	},
	methods: {
		change_mail_from_outside: function(cur_id) {
			this.mail_content = this.template_lst.find(function (el) {
				return (el.name === "" + cur_id);
			}).value;
			// console.log("Lets change template", cur_id);
			// console.log(cur_id);
		},
		add_var_from_outside: function (variable, where) {
			console.group();
			let x;
			variable.edit = false;
			if (where !== "supp") x = this.var_list.find((el) => { return (el.nom === variable.nom)});
			else x = this.var_supplement.find((el) => { return (el.nom === variable.nom)});
				console.log(this.var_toadd);
			if (typeof x === "undefined"){
				if (where !== "supp") this.var_list.push(variable);
				else this.var_supplement.push(variable);
			} else {
				x.valeur = variable.valeur
			}
			console.groupEnd();

		},
		addVariable: function () {
			if (this.var_toadd.nom === "" || this.var_toadd.valeur === "")
				return;
			this.var_list.push(this.var_toadd);
			this.var_toadd = {nom: "", valeur: "", edit: false};
		},
		addVariableOther: function () {
			if (this.var_toadd.nom === "" || this.var_toadd.valeur === "")
				return;
			this.var_supplement.push(this.var_toadd);
			this.var_toadd = {nom: "", valeur: "", edit: false};
		},
		getContentMail: function () {
			let rt = this.mail_content;


			var i = 0;
			while (i < this.var_supplement.length) {
				rt = rt.replace(new RegExp("%" + this.var_supplement[i].nom + "%", 'g'), this.var_supplement[i].valeur);
//				rt = rt.replace(new RegExp("##" + this.var_supplement[i].nom.toUpperCase() + "##", 'g'), this.var_supplement[i].valeur);
				i++;
			}

			i = 0;
			while (i < this.var_list.length) {
				rt = rt.replace(new RegExp("#" + this.var_list[i].nom + "#", 'g'), this.var_list[i].valeur);
				rt = rt.replace(new RegExp("##" + this.var_list[i].nom.toUpperCase() + "##", 'g'), this.var_list[i].valeur);
				i++;
			}
			return (rt);
		},
		changeItem: function(rowId, event) {
			this.mail_content = `${event.target.value}`;
			// this.mail_content = `${event.target.value}`.replace(new RegExp('\n', 'g'), "<br>");
		},
		sendMail: function () {
			var el = document.getElementById("preview-modal-content");
//			$.ajax("/ajax.php")
			var self = this;
			<?php
				$conseiller = "-";
				if (!empty($this->dh->getConseiller())) {
					$conseiller = $this->dh->getConseiller()->getLogin();
				}
			?>
			var dwho = (parseInt(self.who) === 0) ? "<?= Dh::getCurrent()->getLogin() ?>" : "<?= $conseiller ?>";
			$.post("/ajax_request.php", {
				req: "SendMail",
				action: "Send",
				data: {
					id_client: "<?= $GLOBALS['GET']['client'] ?>",
					subject: self.subject,
					to: "<?=$this->dh->getLogin() ?>",
					entity: "<?=$this->dh->getShortName() ?>",
					from: dwho,
					body: self.getContentMail()
				},
				token: "<?=$_SESSION['csrf'][0]?>"
			}, function (data, textStatus, jqXHR) {
				swal(
					'Good Job!',
					'Un mail envoyé !',
					'success'
				);
			}, null);
//			document.execCommand("copy");
		},
		getUrlMailTo: function () {
			var url = "mailto:<?=$this->dh->getLogin() ?>";
			var txt = this.mail_content;

			console.log(encoreURI(txt));

			url += "?subject=" + this.subject + "&body=" + encodeURI(this.mail_content);


			return url;
		}
	},
	filters: {
		truncate: function (string, value) {
			return string.substring(0, value) + '...';
		}
	}
});

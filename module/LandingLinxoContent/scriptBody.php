
</script>
<script>
var vueApp = new Vue({
	el: "#formNewUser",
	data: {
		token: "<?= $_SESSION['csrf'][0]?>",
		personne: {
			civilite: "<?= ($this->state == 2 && isset($_POST['civilite'])) ? (($_POST['civilite'] == "Monsieur") ? "Monsieur": "Madame") : "" ?>",
			nom: "<?= ($this->state == 2 && isset($_POST['mail'])) ? $_POST['mail'] : "" ?>",
			prenom: "",
			email: "<?= ($this->state == 2 && isset($_POST['mail'])) ? $_POST['mail'] : "" ?>",
			phone: "+33",
			passwd: {
				normal: "",
				confirm: ""
			}
		},
		indic: "FR",
		fil: false,
		cgu: false
	},
	methods: {
		confirmPasswdPopover: function(){

		},
		sendForm: function () {
			let s = false;
			let i = $("#g-recaptcha-response").val();
			s = (
				this.passwdIsValid &&
				this.passwdIsSame &&
				this.mailIsValid &&
				this.numIsValid &&
				this.prenomIsValid &&
				this.nomIsValid &&
				this.cgu && this.fil && i !== ""
			);
			let t =  (this.cgu && this.fil) ? '' : '<br>Vous devez acceptez les <a href="Download.php?idDocument=<?=$this->linkFIL[0]->id?>" target="_blank">CGU</a><br> et la <a target="_blank" href="Download.php?idDocument=<?=$this->linkCGU[0]->id?>">Fiche d\'informations légales de MeilleureSCPI.com</a>';

			if (!s) {
				swal({
					title: "Erreur de champs",
					html: "Certaines valeurs semblent incorrectes !" + t,
					type: 'error',
				});
			} else {
				var self = this;
				swal({
					title: 'Confirmer la création de votre compte',
					type: 'info',
					showCancelButton: true,
					confirmButtonColor: '#41B314',
					cancelButtonColor: '#F9354C',
					confirmButtonText: 'Créer',
					cancelButtonText: 'Annuler',
					showLoaderOnConfirm: true,
					preConfirm: (function () {
						return (new Promise(function (resolve, reject) {
							var data = {
								token: self.token,
								req: 'CreationDeCompte',
								data: {
									civilite: self.personne.civilite,
									nom: self.personne.nom,
									prenom: self.personne.prenom,
									mail: self.personne.email,
									num: self.personne.phone,
									pass: self.personne.passwd.normal,
									pays: self.indic,
									fil: self.fil,
									cg: self.cgu,
									captcha: i,
									from: <?= $this->code ?>
								}
							};
							$.post('/ajax_request_client.php', data).done(function (data) {
								console.log(data)
							}).fail(function (d) {
								if (d.status === 200) {
									resolve();
								}
								else {
									reject(d.responseText);
								}
							});
						}))
					})
				}).then(function(dismiss) {
						swal({
							title: 'Succès',
							html: 'Votre compte a été créé avec succès',
							type: 'success'
							}).then(function () {
								window.location.href = "/";
							});
				}).catch(function (error_message) {
					swal({
						title: 'Impossible de créer le compte:',
						html: (JSON.parse(error_message)).err,
						type: 'error'
					});
				});
			}
		}
	},
	computed: {
		passwdLowerCase: function() {
			return (this.personne.passwd.normal.match(/([a-z])/g));
		},
		passwdUpperCase: function() {
			return (this.personne.passwd.normal.match(/([A-Z])/g));
		},
		passwdNumber: function() {
			return (this.personne.passwd.normal.match(/([0-9])/g));
		},
		passwdLength: function() {
			return (this.personne.passwd.normal.length > 8);
		},
		passwdIsValid: function () {
			return (this.passwdLowerCase &&
				this.passwdUpperCase &&
				this.passwdNumber &&
				this.passwdLength);
		},
		passwdIsSame: function () {
			return (this.personne.passwd.normal === this.personne.passwd.confirm);
		},
		mailIsValid: function () {
			return (this.personne.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/));
		},
		numIsValid: function () {
			return (this.personne.phone.match(/^[0-9 +-]{10,}$/));
		},
		prenomIsValid: function () {
			return (this.personne.prenom.match(/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/))
		},
		nomIsValid: function () {
			return (this.personne.nom.match(/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/));
		}
	}
});

let text = "<ul><li>Des lettres minuscules</li>";
text += "<li>Des lettres majuscules</li>";
text += "<li>Un chiffre</li>";
text += "<li>Une longueur minimale de 8 caractères</li></ul>";
$("#passwdNormal").popover({
	animation: true,
	title: "Le mot de passe doit contenir:",
	html: true,
	content: text,
	placement: "top",
	container: "#formNewUser",
	trigger: 'focus'
});

//$("#confirmPasswd").tooltip();
$("#confirmPasswd").popover({
	animation: true,
	title: "Mot de passe",
	html: true,
	content: "Confirmer le mot de passe",
	placement: "top",
	container: "#formNewUser",
	trigger: 'focus'
});

$("#num").popover({
	animation: true,
	title: "Téléphone Portable Obligatoire",
	html: true,
	content: "Renseignez votre numéro de <b><u>téléphone portable</u> obligatoire</b> pour accéder à la plateforme <br>(Système de double authentification)",
	placement: "top",
	container: "#formNewUser",
	trigger: 'focus'
});

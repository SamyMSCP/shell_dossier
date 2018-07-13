</script>
<script>
var vI = new Vue({
	el: '.vueApp',
	store: store,
	data: {
		var_toadd: {nom: "", valeur: "", edit: false},
		var_list: [
			{nom: "header", valeur: "Cher #client#,", edit: false},
			{nom: "message", valeur: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", edit: false},
			{nom: "contact", valeur: "Je reste joignable par mail: #mail#<br>\ " +
			"Ainsi qu'au telephone aux numeros suivant: #phone# &nbsp;&nbsp;&nbsp;&nbsp; #fixe#", edit: false},
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
		saveTemplate: function() {

		}
	}
});

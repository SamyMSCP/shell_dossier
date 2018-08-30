</script>

<script type="text/x-template" id="transactionList">
<?php require_once("template/transactionList.php"); ?>
</script>

<script type="text/javascript">
	/**
	 * Composant de liste
	 */
	Vue.component('transactionList',
		{
			props: ["type", "list"],
			data : function(){
				return {
					year_dividendes: 2016
				}
			},
			computed: {
				getDividendesYear: function (){
					let today = moment();
					let foryear = moment("15-02", "DD-MM");
					if (today.isBefore(foryear))
						return moment().format("Y") - 2;
					return moment().format("Y") - 1;
				},
				getHeader: function() {
					switch (this.type) {
						case "Pleine propriété":
							return [
								{value: "Nom de la SCPI", class: ""},
								{value: "Date d'aquisition", class: "hidden-xs visible-md visible-lg"},
								{value: "Marché", class: "hidden-xs visible-md visible-lg"},
								{value: "Nombre de parts", class: ""},
								{value: "Prix d'achat par part", class: "hidden-xs visible-md visible-lg"},
								{value: "Montant de la transaction", class: "hidden-xs visible-md visible-lg"},
								{value: "Valeur potentielle de revente", class: ""},
								{value: "+ ou - value", class: "hidden-xs visible-md visible-lg"},
								{value: "TDVS", class: "hidden-xs visible-md visible-lg"},
								{value: "Dividende " + this.getDividendesYear, class: "hidden-xs visible-md visible-lg"},
							];
						case "Nue propriété":
							return [
								{value: "Nom de la SCPI", class:""},
								{value: "Date d'acquisition", class:"hidden-xs visible-md visible-lg"},
								{value: "Nombre de parts", class:""},
								{value: "Clé de répartition", class:"hidden-xs visible-md visible-lg"},
								{value: "Prix d'achat par part", class:"hidden-xs visible-md visible-lg"},
								{value: "Montant de la transaction", class:"hidden-xs visible-md visible-lg"},
								{value: "Date de recouvrement de Pleine Propriété", class:"hidden-xs visible-md visible-lg"},
								{value: "Valorisation Nue-propriété estimée", class:"hidden-xs visible-md visible-lg"},
								{value: "+ ou - value", class:"hidden-xs visible-md visible-lg"},
								{value: "Valeur potentielle de revente Pleine Propriété", class:""},
							];
						case "Usufruit":
							return [
								{value: "Nom de la SCPI", class: ""},
								{value: "Date d'acquisition", class: "hidden-xs visible-md visible-lg"},
								{value: "Nombre de parts", class: ""},
								{value: "Clé de répartition", class: "hidden-xs visible-md visible-lg"},
								{value: "Prix d'achat par part", class: "hidden-xs visible-md visible-lg"},
								{value: "Montant de la transaction", class: "hidden-xs visible-md visible-lg"},
								{value: "Valorisation Usufruit", class: ""},
								{value: "Date de fin de démembrement", class: "hidden-xs visible-md visible-lg"},
								{value: "Dividendes perçus", class: "hidden-xs visible-md visible-lg"},
								// "Estimation des dividendes restants à toucher"
							];
						default:
							return ["Empty type"];
					}
				},
				transactionTotal: function() {
					var self = this;
					var total = 0.0;
					this.list.forEach((el) => {
						var div = (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date);
						switch (self.type) {
							case "Pleine propriété":
								if (el.type_pro === self.type || (div !== "-" && el.type_pro === "Nue propriété" &&  moment().isAfter(div)))
									total += el.ventePotentielle;//(parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
							case "Nue propriété":
								if (el.type_pro === self.type && !(div !== "-" && el.type_pro === "Nue propriété" &&  moment().isAfter(div)))
									total += el.valorisation;
									// total += (((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)) > 0) ? el.ventePotentielle : 0;//((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));

								break;
							case "Usufruit":
								if (el.type_pro === self.type)
									total += el.valorisation;//((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
								break;
						}
					})
					return (total);
				},
				transactionFormating: function() {
					var self = this;
					var l = this.list.filter((el) => {
						switch (self.type) {
							case "Pleine propriété":
								var div = (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date);
								if (div !== "-" && el.type_pro === "Nue propriété" && moment().isAfter(div)) {
									return true;
								}
								return (el.type_pro === 'Pleine propriété');
							case "Nue propriété":
								var div = (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date);
								if ((moment().isAfter(div)))
									return (false);
								else
									return (el.type_pro === 'Nue propriété');
							case "Usufruit":
								return (el.type_pro === 'Usufruit');
							default:
							return false;
						}
					});
					var ret = l.map((el) => {
						var div = (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date);
						if(self.type=="Pleine propriété" ){
						    if(el.type_transaction=="A"){
                                if(el.tmp_scpi.Pleine[el.id].buy.transaction_status!='0 - Transaction potentielle'){
                                    var rougePleine = "";
                                    //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougePleine="text-secondary";
                                    var rougeVisiblePleine = "";
                                    //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisiblePleine="hidden-xs visible-md visible-lg text-secondary";
                                    return [
                                        {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, is_nue_end: (div !== "-" && el.type_pro === "Nue propriété" && moment().isAfter(div)), class :rougePleine },
                                        {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.marcher, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.nbr_part, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.ventePotentielle.toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part) > 0) ? (el.ventePotentielle - (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "currency", currency: "EUR"}) : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: isNaN(el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))) ? "-" : (el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "percent", minimumFractionDigits: 2}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.dividendes.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id}
                                    ];
                                }
                            }
                            else if(el.type_transaction=="V") {
                                    var rougePleine = "";
                                    //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougePleine="text-secondary";
                                    var rougeVisiblePleine = "";
                                    //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisiblePleine="hidden-xs visible-md visible-lg text-secondary";
                                    return [
                                        {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, is_nue_end: (div !== "-" && el.type_pro === "Nue propriété" && moment().isAfter(div)), class :rougePleine },
                                        {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.marcher, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.nbr_part, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.ventePotentielle.toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part) > 0) ? (el.ventePotentielle - (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "currency", currency: "EUR"}) : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: isNaN(el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))) ? "-" : (el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "percent", minimumFractionDigits: 2}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                        {value: el.dividendes.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id}
                                    ];

                            }
                            /*
                            if(self.type=="Pleine propriété" && el.type_transaction=="A" || el.type_transaction=="V"){
                                var rougePleine = "";
                                //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougePleine="text-secondary";
                                var rougeVisiblePleine = "";
                                //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisiblePleine="hidden-xs visible-md visible-lg text-secondary";
                                return [
                                    {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, is_nue_end: (div !== "-" && el.type_pro === "Nue propriété" && moment().isAfter(div)), class :rougePleine },
                                    {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.marcher, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.nbr_part, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.ventePotentielle.toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part) > 0) ? (el.ventePotentielle - (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "currency", currency: "EUR"}) : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: isNaN(el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))) ? "-" : (el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "percent", minimumFractionDigits: 2}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.dividendes.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id}
                                ];

                            }*/

                        }

                        else if(self.type=="Nue propriété" && el.type_transaction=="A"){
                            if(el.tmp_scpi.Nue[el.id].buy.transaction_status!='0 - Transaction potentielle'){
                                var rougeNue = "";
                                //if(el.tmp_scpi.Nue[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeNue="text-danger";
                                var rougeVisibleNue = "";
                                //if(el.tmp_scpi.Nue[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisibleNue="hidden-xs visible-md visible-lg text-danger";
                                var prix = ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
                                return [
                                    {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, class:rougeNue},
                                    {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.nbr_part, class:rougeNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.cle_repartition) / 100.0).toLocaleString("fr", {style: "percent"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date).format("DD/MM/YYYY"), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.ventePotentielle.toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (prix > 0) ? (el.ventePotentielle - prix).toLocaleString("fr", {style: "currency", currency: "EUR"}) : '-', class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    // {value: ((el.ventePotentielle - prix) / prix).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:""},
                                    {value: (el.ventePotentiellePleinePro).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeNue,isMscpi: el.doByMscpi,id: el.id},
                                ];
                            }
                        }
                        else if (self.type=="Usufruit" && el.type_transaction=="A"){
                            if( el.tmp_scpi.Usu[el.id].buy.transaction_status !='0 - Transaction potentielle'){
                                var rougeUsu = "";
                                //if(el.tmp_scpi.Usu[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeUsu="text-danger";
                                var rougeVisibleUsu = "";
                                //if(el.tmp_scpi.Usu[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisibleUsu="hidden-xs visible-md visible-lg text-danger";
                                return [
                                    {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, class:rougeUsu},
                                    {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.nbr_part, class: rougeUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.cle_repartition) / 100.0).toLocaleString("fr", {style: "percent"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (((parseFloat(el.cle_repartition) / 100.0)) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.valorisation.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (el.fin_jouissance === null) ? "-" : moment(el.fin_jouissance.date).format("DD/MM/YYYY"), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.dividendes_percu.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                ];
                            }
                        }
                        else if(self.type=="Pleine propriété" && el.type_transaction=="A" ){
                            if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle'){
                                var rougePleine = "";
                                //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougePleine="text-secondary";
                                var rougeVisiblePleine = "";
                                //if(el.tmp_scpi.Pleine[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisiblePleine="hidden-xs visible-md visible-lg text-secondary";
                                return [
                                    {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, is_nue_end: (div !== "-" && el.type_pro === "Nue propriété" && moment().isAfter(div)), class :rougePleine },
                                    {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.marcher, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.nbr_part, class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.ventePotentielle.toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.prix_part) * parseFloat(el.nbr_part) > 0) ? (el.ventePotentielle - (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "currency", currency: "EUR"}) : "-", class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: isNaN(el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))) ? "-" : (el.dividendes / (parseFloat(el.prix_part) * parseFloat(el.nbr_part))).toLocaleString("fr", {style: "percent", minimumFractionDigits: 2}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.dividendes.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisiblePleine,isMscpi: el.doByMscpi,id: el.id}
                                ];
                            }
                        }

                        else if(self.type=="Nue propriété" && el.type_transaction=="A"){
                            if(el.tmp_scpi.Nue[el.id].buy.transaction_status=='0 - Transaction potentielle'){
                                var rougeNue = "";
                                //if(el.tmp_scpi.Nue[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeNue="text-danger";
                                var rougeVisibleNue = "";
                                //if(el.tmp_scpi.Nue[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisibleNue="hidden-xs visible-md visible-lg text-danger";
                                var prix = ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part));
                                return [
                                    {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, class:rougeNue},
                                    {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.nbr_part, class:rougeNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.cle_repartition) / 100.0).toLocaleString("fr", {style: "percent"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: ((parseFloat(el.cle_repartition) / 100.0) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (el.debut_dividendes === null) ? "-" : moment(el.debut_dividendes.date).format("DD/MM/YYYY"), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.ventePotentielle.toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (prix > 0) ? (el.ventePotentielle - prix).toLocaleString("fr", {style: "currency", currency: "EUR"}) : '-', class:rougeVisibleNue,isMscpi: el.doByMscpi,id: el.id},
                                    // {value: ((el.ventePotentielle - prix) / prix).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:""},
                                    {value: (el.ventePotentiellePleinePro).toLocaleString("fr", {style: "currency", currency: "EUR"}), class:rougeNue,isMscpi: el.doByMscpi,id: el.id},
                                ];
                            }
                        }
                        else if (self.type=="Usufruit" && el.type_transaction=="A"){
                            if( el.tmp_scpi.Usu[el.id].buy.transaction_status =='0 - Transaction potentielle'){
                                var rougeUsu = "";
                                //if(el.tmp_scpi.Usu[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeUsu="text-danger";
                                var rougeVisibleUsu = "";
                                //if(el.tmp_scpi.Usu[el.id].buy.transaction_status=='0 - Transaction potentielle') rougeVisibleUsu="hidden-xs visible-md visible-lg text-danger";
                                return [
                                    {scpi: el.scpi, isMscpi: el.doByMscpi, flag: el.flagMissingInfo, id: el.id, class:rougeUsu},
                                    {value: (el.enr_date !== 0) ? moment.unix(el.enr_date).locale("fr").format("L") : "-", class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.nbr_part, class: rougeUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (parseFloat(el.cle_repartition) / 100.0).toLocaleString("fr", {style: "percent"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: parseFloat(el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (((parseFloat(el.cle_repartition) / 100.0)) * parseFloat(el.prix_part) * parseFloat(el.nbr_part)).toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.valorisation.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: (el.fin_jouissance === null) ? "-" : moment(el.fin_jouissance.date).format("DD/MM/YYYY"), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                    {value: el.dividendes_percu.toLocaleString("fr", {style: "currency", currency: "EUR"}), class: rougeVisibleUsu,isMscpi: el.doByMscpi,id: el.id},
                                ];
                            }
                        }


                        else return [];
					});
					return (ret);
				}
			},
			methods: {
				openEdit: function(id) {
					this.$store.state.transactions.selectedTransaction = this.$store.state.transactions.transactionsList.find((el) => { return el.id === id});
					if (this.$store.state.transactions.selectedTransaction.doByMscpi) return ;
					$(".modal").modal('hide');
					setTimeout(() => {
						$("#modal_transactio").modal('show');
						setTimeout(() => {
							$('body').addClass("modal-open");
						}, 370);

					}, 370);
				}
			},
			filters: {
				formatMoney: function(data) {
					return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
				}
			},
			template: "#transactionList"
		}
	);

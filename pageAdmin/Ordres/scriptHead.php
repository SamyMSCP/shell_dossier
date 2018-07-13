</script>
<script type="text/x-template" id="tableauOrdres">
	<?php include_once ("tableContainer.php") ?>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'tableauOrdres',
		{
		    store: store,
			data: function() {
				return ({
					scpi_name: "1",
					update_scpi: "",
					current_scpi: {
						achat: [{
							ordres:	"-",
							parts:	"-",
							price:	"-",
							date:	"-"
						}],
						vente: [{
							ordres:	"-",
							parts:	"-",
							price:	"-",
							date:	"-"
						}]
					},
					url_achat: "page/Ordres/image.php?id=1&type=0",
					url_vente: "page/Ordres/image.php?id=1&type=1"
				});
			},
			methods: {
			},
            computed: {
		    	scpiGetUrl: function () {
					return (this.$store.getters.getUrlFromId(this.scpi_name));
				},
                scpiFormatter: function() {
                    return (this.$store.getters.getNameFromId(this.scpi_name));
                },
                imgAchat: function () {
                    return (this.$store.getters.getImgAchatFromId(this.scpi_name));

                },
                imgVente: function () {
                    return (this.$store.getters.getImgVenteFromId(this.scpi_name));

                },
				showPdfUrl: function(){
					return ("?p=ShowValeurOrdres&scpi=" + this.scpi_name);
				}
			},
            mounted: function (){
		        this.scpi_name = this.$store.state.order_society.lst[0].id;
		        //this.update_table();
            },
			template: '#tableauOrdres'
		}
	);

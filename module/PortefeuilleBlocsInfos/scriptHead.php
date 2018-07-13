</script>

<script type="text/x-template" id="tempplateBlocsInfos">
<?php require_once("template/bloc_info_template.php"); ?>
</script>

<script type="text/javascript">
	/**
	 * Composant de liste
	 */
	Vue.component('blocInfo',
		{
			props: ["data"],
			data : function(){
				return {
					current: this.data.date[this.data.date.length - 1]
				}
			},
			methods: {
				changeDate(year) {
					this.current = this.data.date.find((el) => {
						return (el.year === year);
					})
				}
			},
			filters: {
				money: function(data) {
					return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
				},
				percent: function (data) {
					return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
				}
			},
			template: "#tempplateBlocsInfos"
		}
	);
</script>
<script type = "text/x-template" id="scpi-select-template">
<?php require_once("template/select.php"); ?>
</script>

<script type="text/javascript">
	Vue.component("scpiSelect", {
		template: "#scpi-select-template",
		props: {
			data: {
				default: [],
				type: Array
			},
			value: {
				default: -1,
				type: Number
			}
		},
		data: function () {
			return {
				search: "",
				select: this.value,
				search_enabled: false,
				more: false
			}
		},
		methods: {
			change: function(id) {
				this.select = parseInt(id);
				this.search_enabled = false;
				this.search = "";
				this.update_data();
			},
			update_data: function() {
				this.$emit('input', parseInt(this.select));
			}
		},
		computed: {
			searchByName: function() {
				var self = this;
				return this.data.filter((el) => {;
					return (el.name.toLowerCase().indexOf(self.search.toLowerCase()) >= 0);
				});
			},
			search_result: function() {
				var d = this.searchByName;
				this.more = d.length > 5;
				return d.slice(0, 5);
			},
			is_valid: function() {
				return (this.select > 0);

			},

		},
		watch: {
			value: function (data) {
				this.select = data;
			}
		},
		filters: {
			money: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
			},
			percent: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
			}
		}}
	);
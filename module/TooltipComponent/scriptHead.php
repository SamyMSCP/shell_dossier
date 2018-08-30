</script>
<script type="text/x-template" id="tooltip-template">
	<?php require_once("template/tooltip.php"); ?>
</script>

<script type="text/javascript">
Vue.component('tooltip', {

	template: "#tooltip-template",
	props: {
		title: {
			type: String,
			default: ""
		},
		content: {
			type: String,
			default: "",
		},
		color: {
			type: String,
			default: "blanc"
		},
		size: {
			type: String,
			default: ""
		},
		align: {
			type: String,
			default: ""
		}
	},
	data: function() {
		return {
			is_show: false
		}
	},
	computed: {
		get_image: function(){
			switch (this.color) {
				case 'blanc':
					return 'assets/info/i-Blanc.svg';
				case 'bleu': 
					return 'assets/info/i-Bleu-MS.svg';
			}
		},
		alignRight: function() {
			if (typeof this.align != 'undefined' && this.align == 'right')
				return (true);
			return (false);
		}
	},
	methods: {
		enable: function () {
			if (this.title !== "" || this.content !== "")
				this.is_show = true;
		},
		disable: function () {
			this.is_show = false;
		}
	}
});
</script>

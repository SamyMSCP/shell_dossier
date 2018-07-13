</script>
<script>
var vueInstance = new Vue({
	el: ".vueApp",
	store: store,
	created: function() {
		window.onbeforeunload = function (e) {
			return "coucou";
		};
	}
});

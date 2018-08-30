</script>
<script type="text/javascript" charset="utf-8">
var vueInstance = new Vue({
	el: "#appBadges",
    store: store,
    computed: {
        selectedTransaction: function() {
            return (this.$store.state.dh.precalcul.precalcul);
        }
    },
});

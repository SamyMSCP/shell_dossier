</script>
<script type="text/x-template" id="setParrainComponent">
	<div>
		<div v-if="getParrain.shortName != null" style="color:#20BF55">
			Parrain : {{ getDh.parrain.shortName }}
		</div>
		<?php
		if (Dh::getCurrent()->getType() == "yoda" || Dh::getCurrent()->getType() == "assistant") {
			?>
			<div @click="toggleOpen" v-if="!isOpen" style="cursor:pointer;">
				Définir le parrain
			</div>
			<div v-if="isOpen">
				<input type="number" v-model="getParrain['id']" />
				<button class="btn-mscpi" @click="saveParrain()">Enregistrer</button>
			</div>
			<?php
		}
		?>
	</div>
</script>
<script type="text/javascript" charset="utf-8">

	Vue.component(
		'setParrain',
		{
			computed: {
				getDh: function() {
					return (this.$store.getters.getDh);
				},
				getParrain: function() {
					return (this.getDh.parrain);
				}
			},
			data: function() {
				return ({
					isOpen: false,
					toSet: ""
				});
			},
			methods: {
				toggleOpen: function() {
					this.isOpen = !this.isOpen;
				},
				saveParrain: function() {
					var that = this;
					this.$store.dispatch("DH_SET_PARRAIN", {
						id: this.getDh.id,
						id_parrain: this.getDh.parrain.id
					}).then(
						function() { that.isOpen = false; },
						function() { }
					);
				}
			},
			template: "#setParrainComponent"
		}
	);

</script>

<script type="text/x-template" id="priorityStarsTemplate">
	<div class="priorityStarsStyle">
		<template v-for="n in size">
			<i class="fa fa-star" aria-hidden="true" v-if="value >= n" @click.stop="changeValue(n)"></i>
			<i class="fa fa-star-o" aria-hidden="true" v-else  @click.stop="changeValue(n)"></i>
		</template>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	
Vue.component(
	'priorityStars',
	{
		props: ["size", "value", "entity"],
		methods: {
			changeValue: function(value) {
				if (this.value != value)
					this.$emit("input", value);
					this.$emit("change", {
						entity: this.entity,
						value: value
					});
			}
		},
		template: "#priorityStarsTemplate"
	}
);

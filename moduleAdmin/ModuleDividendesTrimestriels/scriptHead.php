</script>
<script type="text/x-template" id="dividendesTrimestriels">
	<table class="tablePortefeuille" style="margin-bottom:20px;">
		<thead>
			<tr>
				<th>SCPI</th>
				<th>1T <?=date("Y") - 1?></th>
				<th>2T <?=date("Y") - 1?></th>
				<th>3T <?=date("Y") - 1?></th>
				<th>4T <?=date("Y") - 1?></th>
				<th>1T <?=date("Y")?></th>
				<th>2T <?=date("Y")?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				
			?>
			<tr v-for="scpi in getPrecalcul">
				<td>{{ scpi.precalcul['name'] }}</td>
				<td>{{ scpi.precalcul['lastDividendesTrimestre']['T1'] | euros }}</td>
				<td>{{ scpi.precalcul['lastDividendesTrimestre']['T2'] | euros }}</td>
				<td>{{ scpi.precalcul['lastDividendesTrimestre']['T3'] | euros }}</td>
				<td>{{ scpi.precalcul['lastDividendesTrimestre']['T4'] | euros }}</td>
				<td>{{ scpi.precalcul['actualDividendesTrimestre']['T3'] | euros }}</td>
				<td>{{ scpi.precalcul['actualDividendesTrimestre']['T4'] | euros }}</td>
			</tr>
			<tr v-if="typeof getPrecalculTotal != 'undefined'" class="totalDividendeTrimestriels">
				<td>TOTAL </td>
				<td>{{ getPrecalculTotal['lastDividendesTrimestre']['T1'] | euros}}</td>
				<td>{{ getPrecalculTotal['lastDividendesTrimestre']['T2'] | euros}}</td>
				<td>{{ getPrecalculTotal['lastDividendesTrimestre']['T3'] | euros}}</td>
				<td>{{ getPrecalculTotal['lastDividendesTrimestre']['T4'] | euros}}</td>
				<td>{{ getPrecalculTotal['actualDividendesTrimestre']['T1'] | euros}}</td>
				<td>{{ getPrecalculTotal['actualDividendesTrimestre']['T2'] | euros}}</td>
			</tr>
		</tbody>
	</table>

</script>
<script type="text/javascript" charset="utf-8">
	Vue.component(
		'dividendesTrimestriels',
		{
			computed: {
				getPrecalcul: function() {
					var rt = [];
					var tmp = this.$store.getters.getPrecalcul;
					Object.keys(tmp).map(function(key) {
						if (key == "precalcul")
							return ;
						rt.push(tmp[key]);
					});
					return (rt.sort(function(a, b) {
						return (String(a.precalcul.name).localeCompare(String(b.precalcul.name)));
					}));
				},
				getPrecalculTotal: function() {
					if (typeof this.$store.getters.getPrecalcul != "undefined")
						return (this.$store.getters.getPrecalcul['precalcul']);
					else
						return ([]);
				}
			},
			template: "#dividendesTrimestriels"
		}
	);

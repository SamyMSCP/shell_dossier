<div class="row">
	<table class="table table-responsive table-striped table-bordered table-hover table-condensed">
		<thead>
		<tr>
			<th>Index</th>
			<th>SCPI</th>
			<th>Volume Achat</th>
			<th>Volume Vente</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="(el, index) in $store.state.order_society.lst">
			<td class="text-center">{{index + 1}}</td>
			<td class="col-lg-4 text-right"><a :href="el.url" target="_blank">{{el.name}}</a></td>
			<td class="text-center">
				<h5>
					{{$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy.toLocaleString("fr", {style: "currency", currency: "EUR"})}}

					<small v-bind:title='($store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy - $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).buy).toLocaleString("fr", {style: "currency", currency: "EUR"})'>
						Sem:
						<span class="text-success" v-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).buy < $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy'>
                            <i class="material-icons md-18">trending_up</i>
						</span>
						<span class="text-danger" v-else-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).buy > $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy'>
							<i class="material-icons md-18">trending_down</i>
						</span>
						<span class="text-info" v-else='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).buy == $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy'>
							<i class="material-icons md-18">trending_flat</i>
						</span>
					</small>

					<small v-bind:title='($store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy - $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).buy).toLocaleString("fr", {style: "currency", currency: "EUR"})'>
						Jours:
						<span class="text-success" v-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).buy < $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy'>
							<i class="material-icons md-18">trending_up</i>
						</span>
						<span class="text-danger" v-else-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).buy > $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy'>
							<i class="material-icons md-18">trending_down</i>
						</span>
						<span class="text-info" v-else='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).buy == $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).buy'>
							<i class="material-icons md-18">trending_flat</i>
						</span>
					</small>
				</h5>
			</td>
			<td class="text-center">
				<h5>
					{{$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell.toLocaleString("fr", {style: "currency", currency: "EUR"})}}

					<small v-bind:title='($store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell - $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).sell).toLocaleString("fr", {style: "currency", currency: "EUR"})'>
						Sem:
						<span class="text-success" v-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).sell < $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell'>
							<i class="material-icons md-18">trending_up</i>
						</span>
						<span class="text-danger" v-else-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).sell > $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell'>
							<i class="material-icons md-18">trending_down</i>
						</span>
						<span class="text-info" v-else='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(7, "days").format("DD-MM-YYYY"), el.id).sell == $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell'>
							<i class="material-icons md-18">trending_flat</i>
						</span>
					</small>

					<small v-bind:title='($store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell - $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).sell).toLocaleString("fr", {style: "currency", currency: "EUR"})'>
						Jours:
						<span class="text-success" v-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).sell < $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell'>
							<i class="material-icons md-18">trending_up</i>
						</span>
						<span class="text-danger" v-else-if='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).sell > $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell'>
							<i class="material-icons md-18">trending_down</i>
						</span>
						<span class="text-info" v-else='$store.getters.getVolumeByDayAndId($store.getters.getMaxDate().subtract(1, "days").format("DD-MM-YYYY"), el.id).sell == $store.getters.getVolumeByDayAndId($store.getters.getMaxDate().format("DD-MM-YYYY"), el.id).sell'>
							<i class="material-icons md-18">trending_flat</i>
						</span>
					</small>

				</h5>
			</td>
		</tr>
		</tbody>
		<tfoot>
		<tr class="bg-success">
			<th colspan="2">Volume Total:</th>
			<th class="text-center">
                {{$store.getters.getVolByDay($store.getters.getMaxDate().format("DD-MM-YYYY")).buy.toLocaleString("fr", {style: "currency", currency: "EUR"})}}
			</th>
			<th class="text-center">
				{{$store.getters.getVolByDay($store.getters.getMaxDate().format("DD-MM-YYYY")).sell.toLocaleString("fr", {style: "currency", currency: "EUR"})}}
			</th>
		</tr>
		</tfoot>
	</table>
</div>

<div class="container">
    <h2>Gestion de Scrapping</h2>
    <table class="table table-responsive table-bordered text-center">
        <thead>
        <tr>
            <th class="col-lg-1">Index</th>
            <th class="col-lg-2">SCPI</th>
            <th class="col-lg-4">URL</th>
            <th class="col-lg-1">Active</th>
            <th class="col-lg-2">Nombre d'erreur</th>
            <th class="col-lg-2" >Societe de gestion</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(el, index) in $store.state.order_society.lst" :class="[$store.getters.getBgError(el.error, el.disabled), el.disabled ? '' : 'bg-danger']">
            <td class="col-lg-1">{{index + 1}}</td>
            <td class="col-lg-2">{{$store.getters.getScpi(el.id).name}}</td>
            <td class="col-lg-4"><a :href="el.url" target="_blank">{{$store.getters.shortUrl(el.url)}}</a></td>
            <td class="col-lg-1">
				<div class="btn btn-success" v-if="(el.disabled)"><i class="fa fa-check" v-on:click="$store.commit('SETCHANGED', index);"></i></div>
				<div class="btn btn-danger" v-if="!(el.disabled)"><i class="fa fa-times"  v-on:click="$store.commit('SETCHANGED', index);"></i></div>
<!--                <input type="checkbox" class="switch" v-model="(el.disabled)" v-on:click="$store.commit('SETCHANGED', index);"/>-->
            </td>
            <td class="col-lg-2" :class="$store.getters.getBgError(el.error)">
                <button class="btn btn-default" @click="$store.commit('RESETERROR', index);">{{el.error}}</button>
            </td>
            <td class="col-lg-2">{{$store.getters.getSocietyFromId(el.society).name}}</td>
            <td class="col-lg-1" v-if="el.changed">
                <button class="btn btn-primary" @click="$store.dispatch('UPDATELINE', index);">
					<i class="fa fa-lg fa-floppy-o"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>

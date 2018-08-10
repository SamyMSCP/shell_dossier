<div class="opportuniteList">
	<div class="modal fade " id="op_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title text-center">Que souhaitez vous faire ?</h4>
				</div>
				<div class="traitOrange"></div>
				<div class="modal-body">
					<div class="row text-center">
						<div class="text-uppercase col-lg-6">
							<a class="btn btn-popup-consult" :href="$store.state.opportunite.current_op.url" target="_blank">
								Consulter la fiche de la SCPI
							</a>
						</div>
						<div class="text-uppercase col-lg-6" style="padding-left: 15px; padding-right: 15px">
							<a class="btn btn-popup-contact" @click="$store.dispatch('SET_OPPORTUNITE_INTEREST', $store.state.opportunite.current_op)">
								contacter un conseiller
							</a>
						</div>
                        <div class="text-uppercase col-lg-6 col-lg-offset-3" v-if="$store.state.opportunite.typeFilter == 2" style="margin-top: 10px">
                            <a class="btn btn-popup-contact" v-bind:href="$store.getters.pageUrl" role="button">
                                Simulation Usufruit
                            </a>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="haveShadow opportuniteFilter">
		<div>
			<div>
				TYPE D'OPPORTUNITÉ
			</div>
			<div class="btnTypes">
				<div class="btnNue" :class="{selected: $store.state.opportunite.typeFilter == 1}" @click="setNueFilter()">
					<div>NUE PROPRIÉTÉ</div>
				</div>
				<div class="btnUsu" :class="{selected: $store.state.opportunite.typeFilter == 2}" @click="setUsuFilter()">
					<div>USUFRUIT</div>
				</div>
			</div>
		</div>
		<div>
			<div style="padding-left:20px;">
				NOM DE LA SCPI
			</div>
			<div class="filterBottom haveBorderLeft" >
				<select v-model="$store.state.opportunite.scpiFilter" :class="{isSet: $store.state.opportunite.scpiFilter != 0}">
					<option value="0">Veuillez choisir une SCPI</option>
					<option value="-1">Toutes les SCPI</option>
					<option v-for="scpi in $store.getters.getScpiOpportunite" :value="scpi.id"> {{ scpi.name.substr(5) }}</option>
				</select>
			</div>
		</div>
		<div>
			<div style="padding-left:20px;">
				DURÉE DU DÉMEMBREMENT
			</div>
			<div class="filterBottom haveBorderLeft" >
				<select v-model="$store.state.opportunite.dureeFilter" :class="{isSet: $store.state.opportunite.dureeFilter != 0}">
					<option value="0">Veuillez choisir une durée</option>
					<option v-for="duree in 20" :value="duree" v-if="duree > 2"> {{ duree }}</option>
				</select>
			</div>
		</div>
	</div>
	<transition name="fade">
		<div v-if="$store.getters.getOpportuniyNbrPages == 0" class="msgNoOpportunie">
			Il n'y a actuellement pas d'opportunité ayant les critères sélectionnés
		</div>
	</transition>
	<transition name="slide">
		<transition-group  name="opportuniteTransition" tag="div" class="opportuniteListContainer" :class="{slideUp: $store.getters.getOpportuniyNbrPages == 0}">
			<div  class="haveShadow" :class="{isUsu: (op.type != 1)}" v-for="(op, key) in $store.getters.getOpportuniteAtCurrentPage" v-if="typeof op != 'undefined'" :key="key">
				<div class="opportuniteTitle">
					<div class="filter"> </div>
					<span>
							{{(op.type == 1) ? "NUE PROPRIÉTÉ" : "USUFRUIT" }} DE LA
						</span>
					<span class="scpiName">{{ nom_Scpi = $store.getters.getScpi(op.id_scpi).name | upper }}</span>
				</div>
				<div class="opportuniteTable">
					<table>
						<tr>
							<td style="font-family: 'Montserrat', sans-serif;color:#1781e0;">
								<div class="opportuniteContent1">DURÉE</div>
								<div class="opportuniteContent2">
									{{ op.time_demembrement | years }}
								</div>
							</td>
							<td style="font-family: 'Montserrat', sans-serif;color:#1781e0;">
								<div class="opportuniteContent1">CLÉ DE PARTAGE</div>
								<div class="opportuniteContent2" v-if="op.type == 1">
									{{ op.key_nue | pourcent }}
								</div>
								<div class="opportuniteContent2" v-else>
									{{ 100 - op.key_nue | pourcent }}
								</div>
							</td>
						</tr>
						<tr v-if="op.type == 1">
							<th>Montant de la nue propriété</th>
							<td>{{ op.nb_part * op.price_per_part / 100 * op.key_nue | euros }}</td>
						</tr>
						<tr v-else>
							<th>Montant de l'usufruit</th>
							<td>{{ op.nb_part * op.price_per_part / 100 * (100 - op.key_nue) | euros }}</td>
						</tr>
						<tr>
							<th>Nombre de parts</th>
							<td>{{ op.nb_part }}</td>
						</tr>
						<tr v-if="op.type == 1">
							<th>Prix de la part en nue propriété</th>
							<td>{{ op.price_per_part / 100 * op.key_nue | euros }}</td>
						</tr>
						<tr v-else>
							<th>Prix de la part en usufruit</th>
							<td>{{ op.price_per_part / 100 * (100 - op.key_nue) | euros }}</td>
						</tr>
						<tr>
							<th>Souscription divisible</th>
							<td>{{(op.partial_subscrib == 1) ? "OUI" : "NON" }}</td>
						</tr>
					</table>
				</div>
				<button class="opportunitePageBtn" @click="$store.commit('SET_CURRENT_OP', op)">
					CETTE OPPORTUNITÉ M'INTÉRESSE
				</button>
			</div>
		</transition-group>
	</transition>
	<?php
	/*
	</div>
	*/
	?>
	<div class="pageNavgator">
		<div>
			<span v-if="$store.getters.getOpportuniyNbrPages < 5" class="navigator-intern">
				<div @click="$store.commit('SET_OPPORTUNITY_PREVIOUSPAGE')" class="btnLeft" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
				<div v-for="page in $store.getters.getOpportuniyNbrPages" :class="{pageSelected: page == $store.state.opportunite.currentPage + 1}" @click="$store.commit('SET_OPPORTUNITY_PAGE', page - 1)">{{ page }}</div>
				<div @click="$store.commit('SET_OPPORTUNITY_NEXTPAGE')" class="btnRight" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
			</span>
			<span v-else="">
				<span v-if="$store.state.opportunite.currentPage < 3" class="navigator-intern">
					<div @click="$store.commit('SET_OPPORTUNITY_PREVIOUSPAGE')" class="btnLeft" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
					<div v-for="page in 3" :class="{pageSelected: page == $store.state.opportunite.currentPage + 1}" @click="$store.commit('SET_OPPORTUNITY_PAGE', page - 1)">{{ page }}</div>
					<div class="disabled">...</div>
					<div @click="$store.commit('SET_OPPORTUNITY_PAGE', $store.getters.getOpportuniyNbrPages)">{{ $store.getters.getOpportuniyNbrPages }}</div>
					<div @click="$store.commit('SET_OPPORTUNITY_NEXTPAGE')" class="btnRight" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
				</span>
				<span v-else-if="$store.state.opportunite.currentPage > $store.getters.getOpportuniyNbrPages - 4" class="navigator-intern">
					<div @click="$store.commit('SET_OPPORTUNITY_PREVIOUSPAGE')" class="btnLeft" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
					<div @click="$store.commit('SET_OPPORTUNITY_PAGE', 0)">1</div>
					<div class="disabled">...</div>
					<div v-for="page in 3" :class="{pageSelected: $store.getters.getOpportuniyNbrPages - 3 + page == $store.state.opportunite.currentPage + 1}" @click="$store.commit('SET_OPPORTUNITY_PAGE', $store.getters.getOpportuniyNbrPages - 3 + page - 1)">{{ $store.getters.getOpportuniyNbrPages - 3 + page}}</div>
					<div @click="$store.commit('SET_OPPORTUNITY_NEXTPAGE')" class="btnRight" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
				</span>
				<div v-else class="navigator-intern">
					<div @click="$store.commit('SET_OPPORTUNITY_PREVIOUSPAGE')" class="btnLeft" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
					<div @click="$store.commit('SET_OPPORTUNITY_PAGE', 0)">1</div>
					<div class="disabled">...</div>
					<div v-for="page in 3" :class="{pageSelected: $store.state.opportunite.currentPage + page - 1 == $store.state.opportunite.currentPage + 1}" @click="$store.commit('SET_OPPORTUNITY_PAGE', $store.state.opportunite.currentPage + page - 1)">{{ $store.state.opportunite.currentPage + page - 1 }}</div>
					<div class="disabled">...</div>
					<div @click="$store.commit('SET_OPPORTUNITY_PAGE', $store.getters.getOpportuniyNbrPages)">{{ $store.getters.getOpportuniyNbrPages }}</div>
					<div @click="$store.commit('SET_OPPORTUNITY_NEXTPAGE')" class="btnRight" v-if="$store.getters.getOpportuniyNbrPages > 1"></div>
				</span>
			</span>
		</div>
	</div>
</div>
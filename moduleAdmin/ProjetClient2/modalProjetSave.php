SCPI<script type="text/x-template" id="projectsDetails">
	<div class="modal fade modalViewProject" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalProjet">
		<div class="modal-dialog modal-lg modalViewBeneficiaireContour">
			<div class="modal-content modalViewBeneficiaireContent">
				<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
					<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" />
				</div>
				<div class="modalViewProjectTitre">
					<h2>NOM PROJET</h2>
				</div>
				<div class="traitDonneurModalViewBeneficiaire"></div>
				<div class="firstBlock">
					<div class="ProjectDate">
						<div class="ProjectDateInner">
							<span class="Date1">Créé le</span>
							<span class="Date2">10 septembre 2016</span>
						</div>
						<div class="ProjectDateInner2">
							<span class="Date1">Cloture le</span>
							<span class="Date2">-</span>
						</div>
					</div>
					<div class="ProjectConseiller">
						Shortname Conseiller
					</div>
				</div>
				<div class="modalViewProjectBlockInfos">
					<div class="modalViewProjectBlockInfosInner">
						<div class="modalViewProjectBlockInfosInner2">
							<div >
								<h3>DÉTAILS DU PROJET</h3>
							</div>
							<div class="traitDonneurModalViewBeneficiairePp"></div>
							<div class="modalViewProjectBlockInfosInner3">
								<div>
									<div class="nomBeneficiaire">
										Nom benefciaire
									</div>
									<div class="budgetBeneficiaire">
										<span class="budgetBeneficiaireBudget1">BUDGET</span>
										<span class="budgetBeneficiaireBudget2">BudgetEuros</span>
									</div>
									<div class="budgetBeneficiaire2">
										<span class="budgetBeneficiaireBudget1"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
										<span class="budgetBeneficiaireBudget2">FINANCEMENT</span>
									</div>
									<div class="budgetBeneficiaire3">
										<span class="budgetBeneficiaireBudget1"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
										<span class="budgetBeneficiaireBudget2">ACCOMPAGNEMENT</span>
									</div>
								</div>
								<div>
									<div class="projectBeneficiaireViewBtn projectBeneficiaireViewBtnBleu Btn1">
										<button>
											<span class="projectObjectifNumber">1</span>
											<span class="projectObjectifText">Objectif 1</span>
											<div class="projectObjectifArrows">|</div>
										</button>
									</div>
									<div class="projectBeneficiaireViewBtn projectBeneficiaireViewBtnBleu Btn2">
										<button>
											<span class="projectObjectifNumber">2</span>
											<span class="projectObjectifText">Objectf 2</span>
											<div class="projectObjectifArrows">|</div>
										</button>
									</div>
									<div class="projectBeneficiaireViewBtn projectBeneficiaireViewBtnBleu Btn3">
										<button>
											<span class="projectObjectifNumber">3</span>
											<span class="projectObjectifText">Objectif 3</span>
											<div class="projectObjectifArrows">|</div>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modalViewProjectBlockInfosInner">
						<div class="modalViewProjectBlockInfosInner2">
							<div>
								<h3>DOCUMENTS</h3>
							</div>
							<div class="traitDonneurModalViewBeneficiairePp"></div>
							<div class="modalViewProjectBlockDocuments">

								<div class="modalViewProjectDocument1">
									<div class="modalViewProjectDocument2">
										<div class="projectBeneficiaireViewBtn">
											<button type="submit">
												<span class="projectObjectifText" style="font-size:23px;">TYPE DOCUMENT</span>
											</button>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="modalViewProjectBlockInfos">
					<div class="modalViewProjectBlockTransactionInner">
						<div class="modalViewProjectBlockTransactionInner2">
							<div>
								<h3>TRANSACTIONS</h3>
							</div>
							<div class="traitDonneurModalViewBeneficiairePp"></div>
							<table class="tableProjectTransaction">
								<thead>
									<tr>
										<th>SCPI</th>
										<th>Type de propriété</th>
										<th>Cle de repartition</th>
										<th>Durée de démembrement</th>
										<th>Nomtre de parts</th>
										<th>prix par parts en Pleine propriété</th>
										<th>Montant d'investissement</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="trans in $store.state.transactions.selectedProjectTransactions" :class="{isModify: trans.isModify}">
										<td>
											<select v-model="trans.id_scpi" @change="setModify(trans)">
												<option v-for="scpi in $store.getters.getAllScpiSorted" :value="scpi.id">{{ scpi.name}}</option>
											</select>
										</td>
										<td>
											<select v-model="trans.type_pro" @change="setModify(trans)">
												<option>Pleine propriété</option>
												<option>Nue propriété</option>
												<option>Usufruit</option>
											</select>
										</td>
										<td>
											<input type="number" min="1" max="99" v-model="trans.cle_repartition" @keyup="setModify(trans)" v-show="trans.type_pro != 'Pleine propriété'"/>
										</td>
										<td>
											<input type="number" min="0" max="20" v-model="trans.dt" @keyup="setModify(trans)" v-show="trans.type_pro != 'Pleine propriété'"/>
										</td>
										<td>
											<input min="1" type="number" v-model="trans.nbr_part" @keyup="setModify(trans)"/>
										</td>
										<td>
											<input min="1" type="number" v-model="trans.prix_part" step="any" @keyup="setModify(trans)"/>
										</td>
										<td>
											<span v-if="trans.type_pro == 'Pleine propriété'">{{ trans.prix_part * trans.nbr_part}}</span>
											<span v-else>{{ trans.prix_part * trans.nbr_part * trans.cle_repartition / 100}}</span>
											
											<div class="outRight">
												<div class="outContent" v-if="trans.isModify" @click="$store.dispatch('TRANSACTIONS_UPDATE', trans)">
													<i class="fa fa-floppy-o" aria-hidden="true"></i>
												</div>
												<div class="outContent outContent-orange" @click="setDelete(trans)">
													<i class="fa fa-times" aria-hidden="true"></i>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="8" style="border: none;">
											<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" style="height:32px;cursor:pointer;" @click="createTransaction()"/>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>
	</div>
</script>

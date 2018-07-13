<div>
	<div v-if="$store.state.transactions.selectedTransaction != null" class="modal fade" id="modal_transactio"
		 data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-right" aria-label="Close" data-dismiss="modal">
						<img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt=""/>
					</button>
					<!--<template v-if="!$store.state.transactions.selectedTransaction.doByMscpi" >
						<div v-if="$store.state.transactions.selectedTransaction.status_trans == 1" class="pull-right status-tr-mscpi status-tr-mscpi-verified">
							<img src="<?= $this->getPath() ?>img/fleche-validee-Vert@2x.png" />TRANSACTION VÉRIFIÉE</div>
						<div v-if="$store.state.transactions.selectedTransaction.status_trans == 0" class="pull-right status-tr-mscpi status-tr-mscpi-not-verified">
							<img src="<?= $this->getPath() ?>img/annule-rouge@2x.png" />TRANSACTION NON-VÉRIFIÉE
						</div>
					</template>-->
					<!--<button type="button" class=" btn-tr-edit">
						<img alt="" src="<?= $this->getPath(); ?>img/crayon-inactif@2x.png" @click="toggleEditable($store.state.transactions.selectedTransaction)" />
					</button>-->
					<div class="text-center">
					<span class="modal-title">
						<!--<select v-if="isEditable" class="form-control select-type-transac" v-model="$store.state.transactions.selectedTransaction.type">
							<option value="A">ACHAT</option>
							<option value="V">VENTE</option>
						</select>
						<template v-else>-->
							<template v-if="$store.state.transactions.selectedTransaction.type == 'A'">ACHAT</template>
							<template v-else>VENTE</template>
						<!--</template> -->
						 </span>
						<span class="modal-subtitle">[TRANSACTION Nº {{ $store.state.transactions.selectedTransaction.id }}]
					</span>
					</div>
					<div class="modal-trait center-block clear"></div>
					<div class="modal-title-desc clear">
						<template
								v-if="getTransactionCreationDate($store.state.transactions.selectedTransaction.status_trans)">
							<span class="bold">Créé le</span><span>{{ getTransactionCreationDate($store.state.transactions.selectedTransaction.status_trans) | tsDateStr}}</span>
						</template>
					</div>
				</div>
				<div class="modal-body">
					<div class="row text-center" v-if="$store.state.transactions.selectedTransaction.doByMscpi">
						<!--<template v-if="$store.state.transactions.selectedTransaction.doByMscpi">-->
						<svg width="140" height="32"
							 v-for="(statu, key) in $store.state.transactions.lstStatusTransaction" class="timeline"
							 v-bind:class="getStatuslineColor(key, $store.state.transactions.selectedTransaction.status_trans, null)">
							<line v-if="key > 0" x1="0" y1="16" x2="55" y2="16"></line>
							<circle cx="65" cy="16" r="15"></circle>
							<line v-if="key < 7" v-bind:class="forceGrey(key)" x1="80" y1="16" x2="140" y2="16"></line>
							<text x="65" y="21" fill="white" text-anchor="middle">{{ key }}</text>
						</svg>
						<!--</template>-->
						<!--<template v-else>
							<svg  v-for="n in 2"  width="140" height="32" class="timeline" v-bind:class="getStatusLineColorNonMscpi(n,$store.state.transactions.selectedTransaction.status_trans == '6-0')">
								<line v-if="n > 1" x1="0" y1="16" x2="55" y2="16"></line>
								<circle cx="65" cy="16" r="15"></circle>
								<line v-if="n < 2" x1="80" y1="16" x2="140" y2="16"></line>
								<text x="65" y="21" fill="white" text-anchor="middle">{{ n }}</text>
							</svg>
						</template>-->
					</div>
					<div class="row">
						<div class="status-transaction text-center"
							 v-if="$store.state.transactions.selectedTransaction.doByMscpi">
							<template v-if="!editableIfBuy">
								{{ getStatusTitle($store.state.transactions.selectedTransaction.status_trans,
								$store.state.transactions.lstStatusTransaction) }}
							</template>
							<select-status></select-status>
						</div>
						<template v-else>
							<div class="status-transaction text-center ">
								<template v-if="!$store.state.transactions.selectedTransaction.status_trans_done">
									EN ATTENTE DE VÉRIFICATION DU CNP
								</template>
								<template v-else>
									TRANSACTION OK
								</template>
							</div>
						</template>
					</div>
					<div class="row">
						<div class="col-md-12 info_table">
							<h5 class="text-center">CARACTÉRISTIQUES DE L'INVESTISSEMENT</h5>
							<div class="trait"></div>
							<div class="col-md-4 plz">
								<div class="info_table_line">
									<div class="col-md-4 info_table_title">Bénéficiaire(s)</div>
									<div class="col-md-8 info_table_data">
										<select v-if="editableIfBuy" class="form-control"
												v-model="$store.state.transactions.selectedTransaction.id_beneficiaire">
											<option value="">-</option>
											<template
													v-if="$store.getters.getBeneficiaireForDh($store.getters.getSelectedDh.id) != 'undefined'">
												<option v-for="benef in $store.getters.getBeneficiaireForDh($store.getters.getSelectedDh.id)"
														:value="benef.id_benf">{{ benef.shortName }}
												</option>
											</template>
										</select>
										<template v-else>
											<template
													v-if="$store.state.transactions.selectedTransaction.beneficiaire != null">
												{{
												returnHyphenIfEmpty($store.state.transactions.selectedTransaction.beneficiaire.shortName)
												}}
											</template>
										</template>
									</div>
								</div>
								<div class="info_table_line">
									<div class="col-md-4 info_table_title">Nom de la SCPI</div>
									<div class="col-md-8 info_table_data">
										<select v-if="editableIfBuy" class="form-control"
												v-model="$store.state.transactions.selectedTransaction.id_scpi">
											<option value="" disabled>-</option>
											<option v-for="scpi in $store.state.scpi.lst" :value="scpi.id">{{ scpi.name
												| unprefix_scpi }}
											</option>
										</select>
										<template v-else>
											{{
											$store.getters.getScpi($store.state.transactions.selectedTransaction.id_scpi).name
											| unprefix_scpi }}
										</template>
									</div>
								</div>
								<div class="info_table_line">
									<div class="col-md-4 info_table_title">Conseiller</div>
									<div class="col-md-8 info_table_data">
										<select v-if="isEditable" class="form-control"
												v-model="$store.state.transactions.selectedTransaction.id_cons">
											<option value="">-</option>
											<option v-for="cons in lstConseiller" :value="cons.id">{{ cons.shortName
												}}
											</option>
										</select>
										<template v-else>{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.conseiller)
											}}
										</template>
									</div>
								</div>
								<div class="info_table_line bn">
									<div class="col-md-4 info_table_title">Effectué par</div>
									<div class="col-md-8 info_table_data">
										<img v-if='$store.state.transactions.selectedTransaction.doByMscpi'
											 src="<?= $this->getPath() ?>img/MS-Logo-RVB.svg" height="45" alt=""/>
										<input type="text" class="form-control" v-else-if="isEditable"
											   v-model.trim="$store.state.transactions.selectedTransaction.info_trans">
										<template v-else>{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.info_trans)
											}}
										</template>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="info_table_line">
									<div class="col-md-6 info_table_title">Marché</div>
									<div class="col-md-6 info_table_data">
										<select v-if="editableIfBuy" class="form-control"
												v-model="$store.state.transactions.selectedTransaction.marcher">
											<option disabled value="">Choisissez</option>
											<option v-for="marche in $store.state.transactions.lstMarcher"
													:value="marche">{{marche}}
											</option>
										</select>
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.marcher)
											}}
										</template>
									</div>
								</div>
								<div class="info_table_line">
									<div class="col-md-6 info_table_title">Type de propriété</div>
									<div class="col-md-6 info_table_data">
										<select v-if="editableIfBuy" class="form-control"
												v-model="$store.state.transactions.selectedTransaction.type_pro">
											<option disabled value="">Choisissez</option>
											<option v-for="typePro in $store.state.transactions.lstTypePro"
													:value="typePro">{{typePro}}
											</option>
										</select>
										<template v-else>{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.type_pro)
											}}
										</template>
									</div>
								</div>
								<div class="info_table_line">
									<div class="col-md-6 info_table_title">Clé de répartition</div>
									<div class="col-md-6 info_table_data">
										<input type="text" class="form-control"
											   v-if="editableIfBuy && editableIfNotPleinePro"
											   v-model="$store.state.transactions.selectedTransaction.cle_repartition">
										<template
												v-else-if="!isPleinePro($store.state.transactions.selectedTransaction.type_pro)">
											{{ $store.state.transactions.selectedTransaction.cle_repartition |
											distribution_key }}
										</template>
										<template v-else>-</template>
									</div>
								</div>
								<div class="info_table_line bn">
									<div class="col-md-6 info_table_title info_table_title_ml">Durée de<br>démembrement
									</div>
									<div class="col-md-6 info_table_data">
										<input type="text" class="form-control" v-if="editableIfNotPleinePro"
											   v-model="$store.state.transactions.selectedTransaction.dt">
										<template
												v-else-if="!isPleinePro($store.state.transactions.selectedTransaction.type_pro)">
											<template v-if="$store.state.transactions.selectedTransaction.dt == 0">
												Viager
											</template>
											<template v-else>{{ $store.state.transactions.selectedTransaction.dt }}
											</template>
										</template>
										<template v-else>-</template>
									</div>
								</div>
							</div>
							<div class="col-md-4 prz">
								<div class="info_table_line">
									<div class="col-md-6 info_table_title">Nombre de parts</div>
									<div class="col-md-6 info_table_data">
										<input type="text" class="form-control" v-if="isEditable"
											   v-model="$store.state.transactions.selectedTransaction.nbr_part">
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.nbr_part)
											}}
										</template>
									</div>
								</div>
								<div class="info_table_line">
									<div class="col-md-6 info_table_title info_table_title_ml">Prix/part en<br>pleine
										propriété
									</div>
									<div class="col-md-6 info_table_data">
										<input type="text" class="form-control" v-if="isEditable"
											   v-model="$store.state.transactions.selectedTransaction.prix_part">
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.prix_part)
											| euros }}
										</template>
									</div>
								</div>
								<div class="info_table_line">
									<div class="col-md-6 info_table_title info_table_title_ml">Montant<br>d'investissement
									</div>
									<div class="col-md-6 info_table_data">
										<template v-if="isEditable">
											{{montantInvestissement($store.state.transactions.selectedTransaction.prix_part,
											$store.state.transactions.selectedTransaction.nbr_part,$store.state.transactions.selectedTransaction.cle_repartition)
											| euros}}
										</template>
										<template v-else>
											{{montantInvestissement($store.state.transactions.selectedTransaction.prix_part,$store.state.transactions.selectedTransaction.nbr_part,$store.state.transactions.selectedTransaction.cle_repartition)
											| euros}}
										</template>
									</div>
								</div>
								<div class="info_table_line bn">
									<div class="col-md-6 info_table_title">Date d'enregistrement</div>
									<div class="col-md-6 info_table_data">
										<my-datepicker v-if="isEditable"
													   v-model="$store.state.transactions.selectedTransaction.enr_date"></my-datepicker>
										<template v-if="!isEditable">{{
											$store.state.transactions.selectedTransaction.enr_date | date }}
										</template>
									</div>
								</div>
							</div>
						</div>
					</div>
					<template v-if="$store.state.transactions.selectedTransaction.type == 'A'">
						<div class="row">
							<div class="col-md-12 info_table">
								<h5 class="text-center">CONDITIONS DE FINANCEMENT</h5>
								<div class="trait"></div>
								<div class="col-md-12 credit_title_line plz prz">
									<div class="col-md-2 text-center">Montant emprunté</div>
									<div class="col-md-2 text-center">Type d'emprunt</div>
									<div class="col-md-2 text-center">Durée de l'emprunt</div>
									<div class="col-md-2 text-center">Date de début</div>
									<div class="col-md-2 text-center">Taux de l'emprunt</div>
									<div class="col-md-2 text-center">Mensualité</div>
								</div>
								<div class="col-md-12 credit_data_line plz prz">
									<div class="col-md-2 text-center">
										<input type="text" class="form-control" v-if="isEditable"
											   v-model="$store.state.transactions.selectedTransaction.montant_emprunt">
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.montant_emprunt)
											}}
										</template>
									</div>
									<div class="col-md-2 text-center">
										<select class="form-control" v-if="isEditable"
												v-model="$store.state.transactions.selectedTransaction.type_emprunt">
											<option value="">Choisissez</option>
											<option value="Amortissable">Amortissable</option>
											<option value="In Fine">In Fine</option>
										</select>
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.type_emprunt)
											}}
										</template>
									</div>
									<div class="col-md-2 text-center">
										<template v-if="isEditable"><input type="text"
																		   class="form-control form-control-notalone"
																		   style="width:30%"
																		   v-model="$store.state.transactions.selectedTransaction.duree_emprunt">
											<span>mois</span></template>
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.duree_emprunt)
											}} <span>mois</span></template>
									</div>
									<div class="col-md-2 text-center">
										<my-datepicker id="date_debut_emprunt" v-show="isEditable"
													   v-model="$store.state.transactions.selectedTransaction.date_debut_emprunt"></my-datepicker>
										<template v-if="!isEditable">{{
											$store.state.transactions.selectedTransaction.date_debut_emprunt | date }}
										</template>
									</div>
									<div class="col-md-2 text-center">
										<input v-if="isEditable" type="text" class="form-control"
											   v-model.trim="$store.state.transactions.selectedTransaction.taux_emprunt">
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.taux_emprunt)
											}} %
										</template>
									</div>
									<div class="col-md-2 text-center">
										<input v-if="isEditable" type="text" class="form-control"
											   v-model.trim="$store.state.transactions.selectedTransaction.mensualite_emprunt">
										<template v-if="!isEditable">{{
											returnHyphenIfEmpty($store.state.transactions.selectedTransaction.mensualite_emprunt)
											| euros }}
										</template>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 info_table">
								<h5 class="text-center">DOCUMENTS JUSTIFICATIFS</h5>
								<div class="trait"></div>
								<div class="text-center docu_desc">Veuillez cliquer sur les onglets ci-dessous pour
									charger ou consulter vos documents.
								</div>
								<document-btn v-for="typeDocument in $store.state.transactions.lstTypeDocument"
											  id_entity="8"
											  :link_entity="$store.state.transactions.selectedTransaction.id"
											  :type_document="typeDocument.id" :key="typeDocument.id" isDiv="true"
											  cssclass="col-md-4">
									<h6 class="docu_type_title">{{ typeDocument.name }}</h6>
									<div class="text-center" :class="getDocClass(hasDoc(typeDocument.id))"
										 style="width: 100%;">
										<template v-if="hasDoc(typeDocument.id) == 'validated'">DOCUMENT VALIDÉ
										</template>
										<template v-else-if="hasDoc(typeDocument.id) == 'pending'">DOCUMENT
											NÉCESSITANT<br/>UNE VÉRIFICATION
										</template>
										<template v-else>TÉLÉCHARGER UN DOCUMENT</template>
									</div>
								</document-btn>
							</div>
						</div>
					</template>
<!--					VALIDATE BUTTON -->
					<div class="row text-center" v-if="isEditable">
						<div class="col-xs-2 col-xs-offset-3">
							<button class="btn-block btn-tr-del text-uppercase" @click="delTr()">SUPPRIMER</button>
						</div>
						<div class="col-xs-2">
							<button class="btn-block btn-tr-save text-uppercase" @click="setTr()">ENREGISTRER</button>
						</div>
						<courriers-component>
                            </courriers-component>

					</div>
					<div class="row mz">
						<div class="col-md-4 prz plz">
							<div class="col-md-12 internal_info">
								<h5 class="text-center">INFORMATIONS INTERNES</h5>
								<div class="trait"></div>
								<div class="col-md-12 internal_info_content">
									<div class="row info_table_line mz">
										<div class="col-md-8 info_table_title info_table_title_ml">
											Date d'entrée<br/>en jouissance calculée
										</div>
										<div class="col-md-4 info_table_data">
											<!--<my-datepicker v-if="isEditable" id="date_entre_joui_calc" v-model="$store.state.transactions.selectedTransaction.date_entre_joui_calc"></my-datepicker>-->
											<template
													v-if="ifEmpty($store.state.transactions.selectedTransaction.date_entre_joui_calc)">
												-
											</template>
											<template v-else>{{
												$store.state.transactions.selectedTransaction.date_entre_joui_calc |
												date }}
											</template>
										</div>
									</div>
									<div class="row info_table_line mz">
										<div class="col-md-8 info_table_title info_table_title_ml">
											Date d'entrée<br/>en jouissance excel
										</div>
										<div class="col-md-4 info_table_data">
											<!--<my-datepicker v-if="isEditable" id="date_entre_joui" v-model="$store.state.transactions.selectedTransaction.date_entre_joui"></my-datepicker>-->
											<template
													v-if="ifEmpty($store.state.transactions.selectedTransaction.date_entre_joui)">
												-
											</template>
											<template v-else>{{
												$store.state.transactions.selectedTransaction.date_entre_joui | date }}
											</template>
										</div>
									</div>
									<div class="row info_table_line mz">
										<div class="col-md-8 info_table_title info_table_title_ml">
											Date de sortie<br/>en jouissance calculée
										</div>
										<div class="col-md-4 info_table_data">
											<!--<my-datepicker v-if="isEditable" id="date_fin_joui_calc" v-model="$store.state.transactions.selectedTransaction.date_fin_joui_calc"></my-datepicker>-->
											<template
													v-if="ifEmpty($store.state.transactions.selectedTransaction.date_fin_joui_calc)">
												-
											</template>
											<template v-else>{{
												$store.state.transactions.selectedTransaction.date_fin_joui_calc | date
												}}
											</template>
										</div>
									</div>
									<div class="row info_table_line mz">
										<div class="col-md-8 info_table_title info_table_title_ml">
											Date de sortie<br/>en jouissance excel
										</div>
										<div class="col-md-4 info_table_data">
											<!--<my-datepicker v-if="isEditable" id="date_fin_joui" v-model="$store.state.transactions.selectedTransaction.date_fin_joui"></my-datepicker>-->
											<template
													v-if="ifEmpty($store.state.transactions.selectedTransaction.date_fin_joui)">
												-
											</template>
											<template v-else>{{
												$store.state.transactions.selectedTransaction.date_fin_joui | date }}
											</template>
										</div>
									</div>
									<div class="row info_table_line mz">
										<div class="col-md-8 info_table_title">
											Date de signature du BS
										</div>
										<div class="col-md-4 info_table_data">
											<my-datepicker v-if="isEditable" id="date_bs"
														   v-model="$store.state.transactions.selectedTransaction.date_bs"></my-datepicker>
											<template
													v-else-if="ifEmpty($store.state.transactions.selectedTransaction.date_bs)">
												-
											</template>
											<template v-else>{{ $store.state.transactions.selectedTransaction.date_bs |
												date }}
											</template>
										</div>
									</div>
									<div class="row info_table_line mz">
										<div class="col-md-8 info_table_title">
											Transaction MSCPI
										</div>
										<div class="col-md-4 info_table_data">
											<select v-if="isEditable" class="form-control"
													v-model.number="$store.state.transactions.selectedTransaction.doByMscpi">
												<option value="">-</option>
												<option value="1">Oui</option>
												<option value="0">Non</option>
											</select>
											<template
													v-else-if="$store.state.transactions.selectedTransaction.doByMscpi">
												Oui
											</template>
											<template v-else>Non</template>
										</div>
									</div>
									<div class="row info_table_line bn mz">
										<div class="col-md-8 info_table_title">
											Id excel
										</div>
										<div class="col-md-4 info_table_data">
											<input v-if="isEditable" class="form-control" type="text"
												   v-model="$store.state.transactions.selectedTransaction.id_excel"/>
											<template v-else>{{
												returnHyphenIfEmpty($store.state.transactions.selectedTransaction.id_excel)
												}}
											</template>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8 prz plz">
							<div class="internal_info">
								<h5 class="text-center">COMMENTAIRES INTERNES</h5>
								<div class="trait"></div>
								<div class="internal_info_content">
									<ck-editor id="commentaire" height="176px"
											   v-model="$store.state.transactions.selectedTransaction.commentaire"></ck-editor>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
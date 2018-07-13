<div>
	<div v-if="$store.state.transactions.selectedTransaction" class="modal fade modal_transactio" id="modal_transactio" tabindex="-1" role="dialog" aria-labelledby="modal_transactio" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="Undo()">
						<img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" />
					</button>
					<template v-if="!$store.state.transactions.selectedTransaction.doByMscpi" >
						<div v-if="$store.state.transactions.selectedTransaction.status_trans_done" class="status-tr-mscpi status-tr-mscpi-verified">
							<img src="<?= $this->getPath() ?>img/fleche-validee-Vert@2x.png" />TRANSACTION VÉRIFIÉE</div>
						<div v-else class="status-tr-mscpi status-tr-mscpi-not-verified">
							<img src="<?= $this->getPath() ?>img/annule-rouge@2x.png" />TRANSACTION NON-VÉRIFIÉE
						</div>
					</template>
					<div class="text-center">
						<span class="modal-title">
<template v-if="$store.state.transactions.selectedTransaction.type_transaction == 'A'">ACHAT</template>
<template v-else>VENTE</template>
						</span>
						<!--<span class="pull-left modal-subtitle">[TRANSACTION Nº{{$store.state.transactions.selectedTransaction.id}}]</span>-->
					</div>
					<div class="modal-trait center-block clear"></div>
					<div class="modal-title-desc clear">
<template v-if="getTransactionCreationDate($store.state.transactions.selectedTransaction.status_trans) || $store.state.transactions.selectedTransaction.nom_projet != ''">
							<span class="bold">Créé </span>
	<template v-if="getTransactionCreationDate($store.state.transactions.selectedTransaction.status_trans)">
							<span class="bold">le</span> <span>{{ getTransactionCreationDate($store.state.transactions.selectedTransaction.status_trans) | tsDateStr}}</span>
	</template>
	<template v-if="$store.state.transactions.selectedTransaction.nom_projet != ''">
							au sein du Projet <a>{{ $store.state.transactions.selectedTransaction.nom_projet }}</a> 
	</template>
</template>
					</div>
				</div>
				<div class="modal-body">
<template v-if="$store.state.transactions.selectedTransaction.type_transaction == 'A'">
	<template v-if="$store.state.transactions.selectedTransaction.doByMscpi">
					<div class="row text-center">
						<svg width="140" height="32" v-for="(statu, key) in $store.state.transactions.statusList" class="timeline" v-bind:class="getStatuslineColor(key, $store.state.transactions.selectedTransaction.status_trans, doneOrCancelled($store.state.transactions.selectedTransaction.status_trans_done, $store.state.transactions.selectedTransaction.status_trans_cancelled))">
							<line v-if="key > 0" x1="0" y1="16" x2="55" y2="16"></line>
							<circle cx="65" cy="16" r="15"></circle>
							<line v-if="key < ($store.state.transactions.statusList.length - 1)" x1="80" y1="16" x2="140" y2="16"></line>
							<text x="65" y="21" fill="white" text-anchor="middle">{{ key }}</text>
						</svg>
					</div>
					<div class="row">
						<div class="status-transaction text-center">
							{{ $store.getters.getStatusTitle($store.state.transactions.selectedTransaction.status_trans) }}
						</div>
					</div>
	</template>
	<template v-else-if="!$store.state.transactions.selectedTransaction.status_trans_done">
					<div class="row">
						<div class="status-transaction text-center" style="margin-top: 30px">
							TRANSACTION ENREGISTRÉE : EN ATTENTE DU CNP POUR VÉRIFICATION
						</div>
					</div>
	</template>
	<template v-else><div class="row"></div></template>

</template>
<template v-else><div class="row"></div></template>
					<div class="row">
						<div class="col-md-12 info_table">
							<h5 class="text-center">CARACTÉRISTIQUES DE L'INVESTISSEMENT</h5>
							<div class="trait center-block"></div>
							<div class="col-sm-12 col-md-4 plz">
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-5 info_table_title">Bénéficiaire(s)<tooltip title="Bénéficiaires" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-7 info_table_data">
									<select v-if="editableIfBuy" class="form-control" v-model="$store.state.transactions.selectedTransaction.id_beneficiaire">
										<option disabled value="">Choisissez</option>
										<option v-for="benef in $store.getters.getBeneficiaires" :value="benef.id_benf">{{ benef.shortName }}</option>
									</select>
									<template v-if="!isEditable">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.beneficiaire.shortName) }}</template></div>
								</div>
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-5 info_table_title">SCPI <tooltip title="Nom de la SCPI" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-7 info_table_data">
									{{ $store.state.transactions.selectedTransaction.scpi | unprefix_scpi }}</div>
								</div>
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-5 info_table_title">Conseiller <tooltip title="Conseiller" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-7 info_table_data">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.conseiller) }}</div>
								</div>
								<div class="col-xs-12 info_table_line bn">
									<div class="col-sm-12 col-md-5 info_table_title">Effectué par <tooltip title="Effectué par" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-7 info_table_data">
										<input type="text" class="form-control" v-if="editableIfBuy" v-model.trim="$store.state.transactions.selectedTransaction.info_trans">
										<template v-else>
											<img v-if='$store.state.transactions.selectedTransaction.doByMscpi' src="<?= $this->getPath() ?>img/MS-Logo-RVB.svg" height="45" alt="" />
											<template v-else>{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.info_trans) }}</template>
										</template>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-4 plz prz">
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-6 info_table_title">Marché <tooltip title="Marché" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
									<select v-if="editableIfBuy" class="form-control" v-model="$store.state.transactions.selectedTransaction.marcher">
										<option disabled value="">Choisissez</option>
										<option v-for="marche in $store.state.transactions.marcheList" :value="marche" :disabled="$store.state.transactions.selectedTransaction.type_pro != 'Pleine propriété' && marche != 'Primaire'">{{marche}}</option>
									</select>
									<template v-else>{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.marcher) }}</template></div>
								</div>
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-6 info_table_title">Type de propriété <tooltip title="Type de propriété" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
									<!--<select v-if="editableIfBuy" class="form-control" v-model="$store.state.transactions.selectedTransaction.type_pro">
										<option disabled value="">Choisissez</option>
										<option v-for="typePro in $store.state.transactions.proprieteList" :value="typePro">{{typePro}}</option>
									</select>
									<template v-else>-->{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.type_pro) }}<!--</template>--></div>
								</div>
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-6 info_table_title">Clé de répartition <tooltip title="Clé de répartition" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
										<input type="text" class="form-control" v-if="editableIfBuy && editableIfNotPleinePro" v-model="$store.state.transactions.selectedTransaction.cle_repartition" pattern="^\d{1,}((\.|,)(\d{1,5}))?$" v-bind:class="isNumValid($store.state.transactions.selectedTransaction.cle_repartition, isPleinePro($store.state.transactions.selectedTransaction.type_pro))">
										<template v-else-if="!isPleinePro($store.state.transactions.selectedTransaction.type_pro)">{{ $store.state.transactions.selectedTransaction.cle_repartition | distribution_key }}</template>
										<template v-else>-</template>
									</div>
								</div>
								<div class="col-xs-12 info_table_line bn">
									<div class="col-sm-12 col-md-6 info_table_title info_table_title_ml">Durée de<br>démembrement <tooltip title="Durée de démembrement" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
									<input type="text" class="form-control" v-if="editableIfBuy && editableIfNotPleinePro" v-model="$store.state.transactions.selectedTransaction.dt">
										<template v-else-if="!isPleinePro($store.state.transactions.selectedTransaction.type_pro)">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.dt) }}</template>
										<template v-else>-</template>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-4 prz">
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-6 info_table_title">Nombre de parts <tooltip title="Nombre de parts" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
									<input type="text" class="form-control" v-if="isEditable" v-model="$store.state.transactions.selectedTransaction.nbr_part" v-bind:class="isNumValid($store.state.transactions.selectedTransaction.nbr_part, 1)">
									<template v-if="!isEditable">{{ $store.state.transactions.selectedTransaction.nbr_part | shares }}</template></div>
								</div>
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-6 info_table_title info_table_title_ml">Prix/part  <tooltip title="Prix par part en pleine propriété" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
									<input type="text" class="form-control" v-if="isEditable" v-model="$store.state.transactions.selectedTransaction.prix_part" v-bind:class="isNumValid($store.state.transactions.selectedTransaction.prix_part, 1)"><template v-if="!isEditable">{{ $store.state.transactions.selectedTransaction.prix_part | shares_price_eur }}</template></div>
								</div>
								<div class="col-xs-12 info_table_line">
									<div class="col-sm-12 col-md-6 info_table_title info_table_title_ml">Montant<br>d'investissement <tooltip title="Montant d'investissement" color="bleu"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
										<template v-if="isEditable">
											<template v-if="$store.state.transactions.selectedTransaction.prix_part > 0 && $store.state.transactions.selectedTransaction.nbr_part > 0">
											{{ montantInvestissement($store.state.transactions.selectedTransaction.prix_part, $store.state.transactions.selectedTransaction.nbr_part, $store.state.transactions.selectedTransaction.cle_repartition ) | euros }}
											</template>
											<template v-else>-</template>
										</template>
										<template v-else-if="$store.state.transactions.selectedTransaction.prix_part > 0 && $store.state.transactions.selectedTransaction.nbr_part > 0">{{ montantInvestissement($store.state.transactions.selectedTransaction.prix_part, $store.state.transactions.selectedTransaction.nbr_part, $store.state.transactions.selectedTransaction.cle_repartition) | euros }}
										</template>
										<template v-else>-</template>
									</div>
								</div>
								<div class="col-xs-12 info_table_line bn">
									<div class="col-sm-12 col-md-6 info_table_title">Date d'enregistrement <tooltip title="Date d'enregistrement" color="bleu" style="position: relative !important; top: -40px !important; left: 19px;"></tooltip></div>
									<div class="col-sm-12 col-md-6 info_table_data">
									<my-datepicker v-if="isEditable" class="has-feedback" :class="($store.state.transactions.selectedTransaction.enr_date === 0 || isNaN($store.state.transactions.selectedTransaction.enr_date)) ? 'data_invalid' : ''" v-model="$store.state.transactions.selectedTransaction.enr_date"></my-datepicker>
									<template v-if="!isEditable">{{ $store.state.transactions.selectedTransaction.enr_date | date }}</template></div>
								</div>
							</div>
						</div>
					</div>
				<template v-if="$store.state.transactions.selectedTransaction.type_transaction == 'A'">
					<div class="row" v-show="hasCreditInfo">
						<div class="col-md-12 info_table">
							<h5 class="text-center">VOS CONDITIONS DE FINANCEMENT</h5>
							<div class="trait center-block"></div>
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
									<input type="text" class="form-control" v-if="isEditable" v-model="$store.state.transactions.selectedTransaction.montant_emprunt"><template v-if="!isEditable">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.montant_emprunt) }}</template></div>
								<div class="col-md-2 text-center">
									<select class="form-control" v-if="isEditable" v-model="$store.state.transactions.selectedTransaction.type_emprunt">
										<option value="">Choisissez</option>
										<option value="Amortissable">Amortissable</option>
										<option value="In Fine">In Fine</option>
									</select>
									<template v-if="!isEditable">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.type_emprunt) }}</template></div>
								<div class="col-md-2 text-center">
									<template v-if="isEditable"><input type="text" class="form-control form-control-notalone" style="width:30%" v-model="$store.state.transactions.selectedTransaction.duree_emprunt"> mois</template>
									<template v-if="!isEditable">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.duree_emprunt) }} mois</template>
								</div>
								<div class="col-md-2 text-center">
									<my-datepicker v-show="isEditable" v-model="$store.state.transactions.selectedTransaction.date_debut_emprunt"></my-datepicker>
									<template v-if="!isEditable">{{ $store.state.transactions.selectedTransaction.date_debut_emprunt | date }}</template>
								</div>
								<div class="col-md-2 text-center">
									<input v-if="isEditable" type="text" class="form-control" v-model.trim="$store.state.transactions.selectedTransaction.taux_emprunt">
									<template v-if="!isEditable">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.taux_emprunt) }} %</template>
								</div>
								<div class="col-md-2 text-center">
									<input v-if="isEditable" type="text" class="form-control" v-model.trim="$store.state.transactions.selectedTransaction.mensualite_emprunt">
									<template v-if="!isEditable">{{ returnHyphenIfEmpty($store.state.transactions.selectedTransaction.mensualite_emprunt) | euros }}</template>
								</div>
							</div>
						</div>
					</div>
					<div class="row" v-if="$store.state.transactions.selectedTransaction || $store.state.transactions.selectedTransaction.id">
						<div class="col-md-12 info_table">
							<h5 class="text-center">DOCUMENTS JUSTIFICATIFS</h5>
							<div class="trait center-block"></div>
							<div class="text-center docu_desc">Veuillez cliquer sur les onglets ci-dessous pour charger ou consulter vos documents.</div>
							<div class="col-md-5ths">
								<h6 class="docu_type_title" v-if="$store.state.transactions.selectedTransaction.type_transaction == 'A'">Ordre d'achat</h6>
								<h6 class="docu_type_title" v-else>Ordre de vente</h6>
								<div class="text-center" v-bind:class="getDocClass(hasDoc($store.state.transactions.selectedTransaction, 12))" @click="getDoc($store.state.transactions.selectedTransaction, 12)">
									<template v-if="hasDoc($store.state.transactions.selectedTransaction, 12) == 1">DOCUMENT VALIDÉ</template>
									<template v-else-if="hasDoc($store.state.transactions.selectedTransaction, 12) == 0">DOCUMENT EN COURS<br />DE VÉRIFICATION</template>
									<template v-else="">TÉLÉCHARGER UN DOCUMENT</template>
								</div>
							</div>
							<div class="col-md-5ths">
								<h6 class="docu_type_title">Attestation de parts</h6>
								<div class="text-center" v-bind:class="getDocClass(hasDoc($store.state.transactions.selectedTransaction, 13))" @click="getDoc($store.state.transactions.selectedTransaction, 13)">
									<template v-if="hasDoc($store.state.transactions.selectedTransaction, 13) == 1">DOCUMENT VALIDÉ</template>
									<template v-else-if="hasDoc($store.state.transactions.selectedTransaction, 13) == 0">DOCUMENT EN COURS<br />DE VÉRIFICATION</template>
									<template v-else="">TÉLÉCHARGER UN DOCUMENT</template>
								</div>
							</div>
							<div class="col-md-5ths">
								<h6 class="docu_type_title">Chèque ou<br />Ordre de virement</h6>
								<div class="text-center" v-bind:class="getDocClass(hasDoc($store.state.transactions.selectedTransaction, 14))" @click="getDoc($store.state.transactions.selectedTransaction, 14)">
									<template v-if="hasDoc($store.state.transactions.selectedTransaction, 14) == 1">DOCUMENT VALIDÉ</template>
									<template v-else-if="hasDoc($store.state.transactions.selectedTransaction, 14) == 0">DOCUMENT EN COURS<br />DE VÉRIFICATION</template>
									<template v-else="">TÉLÉCHARGER UN DOCUMENT</template>
								</div>
							</div>
							<div class="col-md-5ths">
								<h6 class="docu_type_title">Convention de<br />démembrement</h6>
								<div class="text-center" v-bind:class="getDocClass(hasDoc($store.state.transactions.selectedTransaction, 15))" @click="getDoc($store.state.transactions.selectedTransaction, 15)">
									<template v-if="hasDoc($store.state.transactions.selectedTransaction, 15) == 1">DOCUMENT VALIDÉ</template>
									<template v-else-if="hasDoc($store.state.transactions.selectedTransaction, 15) == 0">DOCUMENT EN COURS<br />DE VÉRIFICATION</template>
									<template v-else="">TÉLÉCHARGER UN DOCUMENT</template>
								</div>
							</div>
							<div class="col-md-5ths">
								<h6 class="docu_type_title">Offre de prêt</h6>
								<div class="text-center" v-bind:class="getDocClass(hasDoc($store.state.transactions.selectedTransaction, 16))" @click="getDoc($store.state.transactions.selectedTransaction, 16)">
									<template v-if="hasDoc($store.state.transactions.selectedTransaction, 16) == 1">DOCUMENT VALIDÉ</template>
									<template v-else-if="hasDoc($store.state.transactions.selectedTransaction, 16) == 0">DOCUMENT EN COURS<br />DE VÉRIFICATION</template>
									<template v-else="">TÉLÉCHARGER UN DOCUMENT</template>
								</div>
							</div>
						</div>
						<form method="post" id="form_file_upload" ref="formFile" novalidate action="">
							<input type="hidden" id="id_transaction" name="data[id_transaction]" value="" />
							<input type="hidden" id="id_type_document" name="data[id_type_document]" v-model="formFileIdTypeDocument" />
							<input type="file" accept="application/pdf" ref="formFileInput" id="form_file" name="data[fichier]" value="" @change="sendDoc($event)"/>
						</form>
					</div>
				</template>
					<div class="row text-center" v-if="isEditable">
						<button v-if="!$store.state.transactions.selectedTransaction.doByMscpi && nbDocs($store.state.transactions.selectedTransaction) == 0" class="btn-tr-del" @click="delTr()">SUPPRIMER</button>
						<button class="btn-tr-save" @click="saveTr()">ENREGISTRER ET FERMER</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
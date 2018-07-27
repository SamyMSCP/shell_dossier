<div class="modal fade modal_transactio" id="tableau-transaction-edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal_transactio">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="text-uppercase titre">
					<h1 class="titreComposant" v-if="isSell" >VENTE</h1>
					<h1 class="titreComposant" v-else>ACHAT</h1>
					<div @click='close()'>
						<div class="close"><img src="/assets/close/Close-Jaune.svg"/></div>
					</div>
				</div>
				<div>
					<hr class="hr_bar">
				</div>
				<div class='blockStatus'>
				</div>
				<div class='blockCaracteristiques'>
					<div class='titre'>
						CARACTÉRISTIQUES DE L'INVESTISSEMENT
					</div>
					<div class='trait-orange'> </div>
					<div class='contenu'>
						<div class='blockInfos'>
							<div class='smallBlockInfo'>
								<div>
                                    <tooltip content="C’est la dénomination précise de la SCPI, comme indiqué dans les statuts de la SCPI.">
                                        SCPI
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.id_scpi'  v-if='debug'/>
									<edit-transaction-id_scpi :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-id_scpi>
								</div>
							</div>
							<?php
							/*
							<div class='smallBlockInfo'>
								<div>
									Conseiller
								</div>
								<div>
									<input  v-model='selectedTransaction.id_cons' v-if='debug'/><br />
									<edit-transaction-id_cons	:disabled='true' :data='selectedTransaction'> </edit-transaction-id_cons>
								</div>
							</div>
							*/
							?>
							<div class='smallBlockInfo'>
								<div>
                                    <tooltip content="">
                                        Effectué par
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.societe' v-if='debug'/>
									<edit-transaction-societe :data='selectedTransaction'  :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-societe>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="">
									Précision
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.info_trans' v-if='debug'/>
									<edit-transaction-info_trans :data='selectedTransaction'  :disabled="selectedTransaction.doByMscpi != 0 || isSell || selectedTransaction.societe == '-' || selectedTransaction.societe == null"> </edit-transaction-info_trans>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="">
                                        Bénéficiaire
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.id_beneficiaire' v-if='debug'/>
									<edit-transaction-id_beneficiaire  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-id_beneficiaire>
								</div>
							</div>
						</div>
						<div class='blockInfos'>
							<div class='smallBlockInfo'>
								<div><tooltip content="Il s’agit de savoir si votre souscription a été réalisée sur le marché primaire ou secondaire.">
                                        Marché</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.marche' v-if='debug'/>
									<edit-transaction-marche  :data='selectedTransaction'  :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-marche>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="">
                                        Type de propriété</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.type_pro' v-if='debug'/>
									<edit-transaction-typepro  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-typepro>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="Dans le cadre d’une souscription en démembrement, le prix de souscription des parts de SCPI est réparti entre le nu-propriétaire et l’usufruitier. Cette répartition se fait selon des clés de valeurs. Ces clés de valeurs varient en fonction de la durée du démembrement et du rendement prévisionnel de la SCPI sur cette même période.">
                                        Clé de répartition</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.cle_repartition'  v-if='debug'/>
									<edit-transaction-cle_repartition  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-cle_repartition>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content=" Dans le cadre d’une souscriptions en démembrement temporaire, il existe une durée rattachée à ce démembrement. ">
                                        Durée de démembrement (en années)</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.demembrement'  v-if='debug'/>
									<edit-transaction-demembrement  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-demembrement>
								</div>
							</div>
						</div>
						<div class='blockInfos'>
							<div class='smallBlockInfo'>
								<div><tooltip content="C’est le nombre de parts de SCPI que vous avez souscrit dans le cadre de cette souscription.">
                                        Nombre de parts</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.nbr_part'  v-if='debug'/>
									<edit-transaction-nbr_part  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-nbr_part>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div v-if="selectedTransaction.type_transaction == 'V'"><tooltip content="C’est le prix de vente unitaire par parts, payé au moment de la vente.">
                                        Prix de vente par part frais compris</tooltip>
								</div>
								<div v-else><tooltip content="C’est le prix d’achat unitaire par parts, payé au moment de la souscription.">
                                        Prix d'achat par part frais compris en pleine propriété</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.prix_part'  v-if='debug'/>
									<edit-transaction-prix_part  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-prix_part>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="Ce montant se calcul de la manière suivante : Nombre de parts X Prix par parts au moment de la souscription X Clé de répartition.">
                                        Montant d'investissement</tooltip>
								</div>
								<div style='justify-content:center;' v-if="selectedTransaction.type_pro =='Nue propriété' || selectedTransaction.type_pro =='Usufruit'">
									{{ selectedTransaction.prix_part * selectedTransaction.nbr_part * (selectedTransaction.cle_repartition/100) | euros }}
								</div>
								<div style='justify-content:center;' v-else-if="selectedTransaction.type_pro =='Pleine propriété'">
									{{ selectedTransaction.prix_part * selectedTransaction.nbr_part | euros }}
								</div>
								<div style='justify-content:center;' v-else>

								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="">
                                        Date d'enregistrement</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.enr_date'  v-if='debug'/>
									<edit-transaction-enr_date  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0 || isSell"> </edit-transaction-enr_date>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="plus_de_detaille" v-if='!isSell'>
					<div class="plus_de_detaille_boutton" style="display: flex;" v-if="plusdetaille == false" @click="showDetaille()" >
						<img style="transition: 0.75s"  src="/assets/plus/white.svg"/>
						<div style="margin-top: 3%; margin-right: 8px; color: white"> Plus de détails</div>
					</div>
					<div class="plus_de_detaille_boutton" style="display: flex;" v-else-if="plusdetaille" @click="showDetaille()" >
						<img class="anime_icon_plus" src="/assets/plus/white.svg"/>
						<div style="margin-top: 3%; margin-right: 8px; color: white"> Moins de détails</div>
					</div>

				</div>
				<div class='blockConditions' :class="{active: plusdetaille}" v-if='!isSell'>
					<div class='titre'>
						CONDITIONS DE FINANCEMENT
					</div>
					<div class='trait-orange'> </div>
					<div class='contenu'>
						<div class='blockInfos'>
							<div class='smallBlockInfo'>
								<div>
                                    <tooltip content="">
                                        Montant emprunté
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.montant_emprunt' v-if='debug'/>
									<edit-transaction-montant_emprunt  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0"></edit-transaction-montant_emprunt>

								</div>
							</div>
							<div class='smallBlockInfo'>
								<div>
                                    <tooltip content="">
                                        Type d'emprunt
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.type_emprunt'  v-if='debug'/>
									<edit-transaction-type_emprunt  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0"></edit-transaction-type_emprunt>

								</div>
							</div>
						</div>
						<div class='blockInfos'>
							<div class='smallBlockInfo'>
								<div>
                                    <tooltip content="">
                                        Durée de l'emprunt (en mois)
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.duree_emprunt'  v-if='debug'/><br />
									<edit-transaction-duree_emprunt  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0"></edit-transaction-duree_emprunt>

								</div>
							</div>
							<div class='smallBlockInfo'>
								<div>
                                    <tooltip content="">
                                        Date de début
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.date_debut_emprunt'  v-if='debug'/><br />
									<edit-transaction-date_debut_emprunt  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0"></edit-transaction-date_debut_emprunt>
								</div>
							</div>
						</div>
						<div class='blockInfos'>
							<div class='smallBlockInfo'>
								<div><tooltip content="">
                                        Taux de l'emprunt
                                    </tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.taux_emprunt'  v-if='debug'/>
									<edit-transaction-taux_emprunt  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0"></edit-transaction-taux_emprunt>
								</div>
							</div>
							<div class='smallBlockInfo'>
								<div><tooltip content="">
                                        Mensualité</tooltip>
								</div>
								<div>
									<input  v-model='selectedTransaction.mensualite_emprunt'  v-if='debug'/>
									<edit-transaction-mensualite_emprunt  :data='selectedTransaction' :disabled="selectedTransaction.doByMscpi != 0"></edit-transaction-mensualite_emprunt>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='blockDocuments'  v-if='selectedTransaction.id != 0' style="display: none">
					<div class='titre'>
						DOCUMENTS JUSTIFICATIFS
					</div>
					<div class='trait-orange'> </div>
					<div class='contenu'>
						{{ selectedTransaction }}
						<br />
						<br />
						<br />
						"{{ getError }}"

					</div>
				</div>

				<div class='btn-container' v-if='!selectedTransaction.doByMscpi'>

					<div v-if='selectedTransaction.id != 0' class="delete text-uppercase" @click="showModifier()">
						Supprimer la transaction
					</div>
					<div class='save green' @click="save()" v-if='!isSell'>
						ENREGISTRER ET FERMER
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

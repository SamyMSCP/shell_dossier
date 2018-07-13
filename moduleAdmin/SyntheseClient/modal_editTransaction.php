<div <?php echo 'class="modal mdl fade modal_editionTransaction"'; ?> tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  style="z-index:2000">
	<div class="modal-dialog modal-lg" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-body">
				<?php
				/*
				<h2>Etat de la transaction</h2>
				<div class="traitDonneurModalViewBeneficiairePp"></div>
				<div class="mdlProgressBlock">
					<?=$this->ProgressBlock?>
				</div>
				<div class="realyChangeStatus">
					<p>Etes vous sur de vouloir changer le status de la transaction ?</p>
					<div>
						<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
							<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
							<input type="hidden" name="id_transaction" class="id_transactionUpdateStatusTrans" value="" />
							<input type="hidden" name="nStatus" id="nStatus" value="" />
							<input type="submit" name="actionChangeStatusTrans" class="btnOui" id="" value="Oui" />
						</form>
						<button value="" onclick="changeTransactionStatusNo();" class="btnNon" >Non</button>
					</div>
				</div>
				*/
				?>
				<h2>Detail de la transaction</h2>
				<div class="traitDonneurModalViewBeneficiairePp"></div>
				<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
				<table border="1" class="tableDetailTransaction">
					<thead>
						<tr>
							<th>Nom de la SCPI</th>
							<th>Nombre de parts</th>
							<th>Marche</th>
							<th>Type de propriete</th>
							<th <?php /*class="forNoPleine" */ ?>>Cle de repartition</th>
							<th <?php /*class="forNoPleine" */ ?>>Duree</th>
							<th>Prix Achat/Vente</th>
							<th>Montant total</th>
							<th>Beneficiaire</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td id="editNameScpi">Nom de la SCPI</td>
							<td  style="padding:0px"><input type="text" name="editNbrPart" id="editNbrPart" value="" /></td>
							<td  style="padding:0px">
								<select name="editMarche" id="editMarche"/>
									<option value="Primaire">Primaire</option>
									<option value="Secondaire">Secondaire</option>
								</select>
							</td>
							<td  style="padding:0px">
								<select name="editType" id="editType" />
									<option value="Pleine propriété">Pleine propriété</option>
									<option value="Nue propriété">Nue propriété</option>
									<option value="Usufruit">Usufruit</option>
								</select>
							</td>
							<td style="padding:0px" <?php /*class="forNoPleine" */ ?>><input type="number" min="0" max="100" step="any" name="editCle" id="editCle" value="" /></td>
							<td  style="padding:0px" <?php /*class="forNoPleine" */ ?>><input type="number" min="0" name="editDuree" id="editDuree" value="" /></td>
							<td  style="padding:0px"><input type="number" step="any" min="1" name="editPrixPart" id="editPrixPart" value="" /></td>
							<td id="editMontantTotal"></td>
							<td>
									<select name="editTransactinBeneficiaire" id="editTransactinBeneficiaire">
										<option value="0">-</option>
										<?php
										foreach ($this->dh->getBeneficiaires() as $keyBen => $elmBen)
										{
											?>
											<option value="<?=$elmBen->id_benf?>"><?=$elmBen->getShortName()?></option>
											<?php
										}
										?>
									</select>
							</td>
							<td>
							<input type="hidden" name="id_transaction" id="editIdTransaction" value="" />
							<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
							<input type="submit" name="action" id="" value="Enregistrer la transaction" />
							</td>
						</tr>
						
					</tbody>
				</table>
				<div class="blockInfoTrabsaction">
					<div class="blockInfoTrabsactionLeft">
						Date d’entrée en jouissance : <span id="jouissanceIn"></span> <br />
						Date de fin de jouissance : <span id="demembrementOut"></span>
					</div>
					<div class="blockInfoTrabsactionRight">
						Date de signature du BS : <span id="signatureBs"></span><br />
							<?php
							if (!isMobile())
							{
								?>
								<input style="1px solid #ccc" id="enr_date" name="enr_date" type="text" placeholder="" class="form-control input-md dateenr" <?php /*echo 'value="' . date("Y-m-d") . '"'; */?> >
								<?php
							}
							else
							{
								?>
								Date enregistrement : 
								<input style="1px solid #ccc" id="enr_date" name="enr_date" type="date" max="<?=date("Y-m-d")?>" placeholder="" class="form-control input-md dateenr" <?php /*echo 'value="' . date("Y-m-d") . '"'; */?> >
								<?php
							}
							//Date enregistrement : <span id="enr_date"></span>
							?>
					</div>
				</div>
				</form>
				<h2>Documents Justificatifs</h2>
				<div class="traitDonneurModalViewBeneficiairePp"></div>
				<div class="blockTransactionDocuments">
					<?php
					foreach ($this->RequiredDocumentTransaction as $key => $elm)
					{
						?>
						<div class="btnTransactionDocument transactionTypeDoc_<?=$elm->id?>">
							<?=$elm->getName()?>
						</div>
						<?php
					}
					?>
				</div>
				<h2>Commentaire</h2>
				<div class="traitDonneurModalViewBeneficiairePp"></div>
				<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8">
					<textarea onkeyup="$('#actionUpdateTransactionCommentaire').show();" name="commentaire" id="textCommentaire" rows="8" cols="40"></textarea>
					<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
					<input type="hidden" name="id_transaction" class="id_transactionUpdateStatusTrans" value="" />
					<input class="btnOui" style="display:none;" type="submit" name="actionUpdateTransactionCommentaire" id="actionUpdateTransactionCommentaire" value="Enregistrer" />
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<h2>Tableasu des type de documents</h2>
<div class="showDocumentTypeTable">
	<table border="1">
		<thead>
			<tr>
				<th colspan="7">Propriete</th>
				<th colspan="<?=count($this->allEntity)?>">Lien avec les entites</th>
				<th>-</th>
			</tr>
			<tr>
				<th>Nom du type de document</th>
				<th>Duee de validite du document</th>
				<th>Besoin de signature</th>
				<th>Besoin de lecture par le client</th>
				<th>Besoin de validation par le donneur d'ordre</th>
				<th>Besoin de validation par le backoffice</th>
				<th>Besoin de d'etre vue sur le front office</th>
				<?php
					foreach($this->allEntity as $key => $elm)
					{
						?>
							<th><?=$elm->name?></th>
						<?php
					}
				?>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<form action="?p=<?=$GLOBALS['GET']['p']?>&action=<?=$GLOBALS['GET']['action']?>" method="post" accept-charset="utf-8">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
					<td>
						<input type="text" name="name" id="" value="" />
					</td>
					<td>
						<input type="number" name="duree_validite" id="" value="" />
					</td>
					<td>
						<input type="checkbox" name="need_signature" id="" value="" />
					</td>
					<td>
						<input type="checkbox" name="need_read" id="" value="" />
					</td>
					<td>
						<input type="checkbox" name="need_validate_dh" id="" value="" />
					</td>
					<td>
						<input type="checkbox" name="need_validate_backoffice" id="" value="" />
					</td>
					<td>
						<input type="checkbox" name="need_access_frontoffice" id="" value="" />
					</td>
					<?php
						foreach($this->allEntity as $key => $elm1)
						{
							?>
							<td>
								<input type="checkbox" name="linkEntity<?=$elm1->id?>" id=""  />
							</td>
							<?php
						}
					?>
					<td>
						<input type="submit" name="action" id="" value="addTypeDocument" />
					</td>
				</tr>
			</form>
			<?php
			foreach ($this->allTypeDocuments as $key => $elm)
			{
				?>
				<form action="?p=<?=$GLOBALS['GET']['p']?>&action=<?=$GLOBALS['GET']['action']?>" method="post" accept-charset="utf-8">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
						<td>
							<input type="text" name="name" id="" value="<?=$elm->getName()?>" />
						</td>
						<td>
							<input type="number" name="duree_validite" id="" value="<?=$elm->getDureValidite()?>" />
						</td>
						<td>
							<input type="checkbox" name="need_signature" id="" <?php echo  ($elm->getNeedSignature()) ? "checked" : ""; ?> />
						</td>
						<td>
							<input type="checkbox" name="need_read" id="" <?php echo  ($elm->getNeedRead()) ? "checked" : ""; ?> />
						</td>
						<td>
							<input type="checkbox" name="need_validate_dh" id="" <?php echo  ($elm->getNeedValidateDh()) ? "checked" : ""; ?> />
						</td>
						<td>
							<input type="checkbox" name="need_validate_backoffice" id="" <?php echo  ($elm->getNeedValidateBackoffice()) ? "checked" : ""; ?> />
						</td>
						<td>
							<input type="checkbox" name="need_access_frontoffice" id="" <?php echo  ($elm->getNeedAccessFrontoffice()) ? "checked" : ""; ?> />
						</td>
						<?php
							foreach($this->allEntity as $key => $elm1)
							{
								?>
								<td>
									<input type="checkbox" name="linkEntity<?=$elm1->id?>" id="" <?php echo  ($elm->isLinkedToEntityId($elm1->id)) ? "checked" : ""; ?> />
								</td>
								<?php
							}
						?>
						<td>
							<input type="hidden" name="id_type_document" id="" value="<?=$elm->id?>" />
							<input type="submit" name="action" id="" value="updateTypeDocument" />
						</td>
					</tr>
				</form>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<?php
if (isset($GLOBALS['GET']['action']) && $GLOBALS['GET']['action'] === "addTypeDocument")
{
	//(name, duree_validite, need_signature, need_read, need_validate_dh, need_validate_backoffice)
	?>
	<h2>Formulaire pour ajouter un nouveau type de document</h2>
	<div class="addNewDocumentTypeTable">
		<form action="?p=<?=$GLOBALS['GET']['p']?>&action=<?=$GLOBALS['GET']['action']?>" method="post" accept-charset="utf-8">
			<table>
				<tr>
					<th>Nom du type de document</th>
					<td>
						<input type="text" name="name" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>Duee de validite du document</th>
					<td>
						<input type="number" name="duree_validite" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>Besoin de signature</th>
					<td>
						<input type="checkbox" name="need_signature" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>besoin de lecture par le client</th>
					<td>
						<input type="checkbox" name="need_read" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>besoin de validation par le donneur d'ordre</th>
					<td>
						<input type="checkbox" name="need_validate_dh" id="" value="" />
					</td>
				</tr>
				<tr>
					<th>Besoin de validation par le backoffice</th>
					<td>
						<input type="checkbox" name="need_validate_backoffice" id="" value="" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="action" id="" value="addTypeDocument" />
					</td>
				</tr>
				
			</table>
		</form>
	</div>
	<?php
}

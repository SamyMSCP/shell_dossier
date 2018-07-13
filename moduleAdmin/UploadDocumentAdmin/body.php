<h2>Tableau des type de documents</h2>
<p style="text-align:center;">Lors d'une nouvelle version d'un document il convient de decocher l'ancien document et cocher le nouveau document</p>
<div class="showDocumentTypeTable">
	<table border="1">
		<thead>
			<tr>
				<th>Date Création</th>
				<th>Type document</th>
				<th>Online</th>
				<th>Fichier</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
					<td>
					</td>
				<td>
						<select name="idTypeDocument">
						<?php
							foreach ($this->allTypeDocuments as $obj)
							{?>
								<option value="<?=$obj->id?>"><?=$obj->name?></option>
							<?php }
						?>
						</select>
					</td>
					<td>
						<input type="checkbox" name="online" id="" value="" />
					</td>
					<td>
						<input type="file" name="fichier" id="" />
					</td>
					<td>
						<input type="hidden" name="idEntity" value="<?=Mscpi::getEntityId()?>">
						<input type="submit" name="action" id="" value="addDocument" />
					</td>
				</tr>
			</form>
			<?php
			foreach ($this->Document as $key => $elm)
			{
				?>
				<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
					<td>
						<?=$elm->getDateCreation()->format("Y-m-d")?>
					</td>
					<td>
						<span><?=$elm->getTypeDocument()->getName()?></span>
					</td>
					<td>
						<input type="checkbox" name="online" id="" value="" <?php if ($elm->online == 1) echo " checked";?>/>
					</td>
					<td>
						<a href="?p=DownloadDocument&idDocument=<?=$elm->id?>"><?=$elm->getFilename()?></a>
					</td>
					<td>
							<input type="hidden" name="idDoc" value="<?=$elm->id?>">
							<input type="submit" name="action" id="" value="updateDocument" />
					</td>
				</tr>
				</form>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

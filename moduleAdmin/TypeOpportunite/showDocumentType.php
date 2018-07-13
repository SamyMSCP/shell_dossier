<h2>Tableau des Opportunités</h2>
<div class="showDocumentTypeTable">
	<table border="1">
		<thead>
			<tr>
				<th>PTR</th>
				<th colspan="10">CONTENT</th>
				<th colspan="2">Paramètres</th>
			</tr>
			<tr>
				<th>Numero</th>
				<th>Picto title</th>
				<th>Title</th>
				<th>subTitle</th>
				<th>Valeur gauche</th>
				<th>Valeur droite</th>
				<th>Label gauche</th>
				<th>Label droite</th>
				<th>Contenu</th>
				<th>Url</th>
				<th>image</th>
				<th>En ligne</th>
				<th>Boutton</th>
			</tr>
		</thead>
		<tbody>
			<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
					<td>
						<input disabled="1" type="text" name="id" id="" value="..." />
					</td>
					<td>
					<?php
						$allimg = scandir($this->getPath() . "/../../module/OpportuniteModule/img/picto");
					?>
						<select name="titlepicto" onchange="document.getElementById('prevpicto').src = '<?=$this->getPath()?>' + '../../module/SuggestionModule/img/picto/' + this.options[this.selectedIndex].value;">
							<option value="">Rien</option>
							<?php foreach($allimg as $v)
								if ($v != "." && $v != "..")
									echo "<option value=\"$v\">$v</option>";
							?>
						</select>
						<img style="height: 100px" id="prevpicto"/>
					</td>
					<td>
						<input required="" type="text" name="thetitle" id="" value="" />
					</td>
					<td>
						<input required="" type="text" name="title" id="" value="" />
					</td>
					<td>
						<input required="" type="text" name="left_val" id="" />
					</td>
					<td>
						<input required="" type="text" name="right_val" id="" />
					</td>
					<td>
						<input required="" type="text" name="left_msg" id=""/>
					</td>
					<td>
						<input required="" type="text" name="right_msg" id=""/>
					</td>
					<td>
						<textarea type="text" name="content" id="" cols="45" rows="2"></textarea>
					</td>
					<td>
						<input required="" type="text" name="url" id=""/>
					</td>
					<td>
						<input required="" type="file" name="fichier" id=""/>
					</td>
					<td>
						<input type="checkbox" name="isonline" id=""/>
					</td>
					<td>
						<input type="submit" name="action" id="" value="addTypeOpportunite" />
					</td>
				</tr>
			</form>
			<?php
			foreach ($this->Opportunite as $key => $elm)
			{
				?>
				<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
						<td>
							<input type="text" name="id" id="" value="<?=$elm->getId()?>" />
						</td>
						<td>
						<?php $allimg = scandir($this->getPath() . "/../../module/OpportuniteModule/img/picto"); ?>
							<select name="titlepicto" onchange="document.getElementById('prevpicto<?=$key?>').src = '<?=$this->getPath()?>' + '../../module/SuggestionModule/img/picto/' + this.options[this.selectedIndex].value;">
								<option value="">Rien</option>
								<?php foreach($allimg as $v)
									if ($v != "." && $v != "..")
										if ($elm->getTitlePicto() === $v)
											echo "<option selected=\"1\" value=\"$v\">$v</option>";
										else
											echo "<option value=\"$v\">$v</option>";
								?>
							</select>
							<img style="height: 100px" id="prevpicto<?=$key?>"/>
						</td>
						<td>
							<input type="text" name="thetitle" id="" value="<?=$elm->getTheTitle()?>" />
						</td>
						<td>
							<input type="text" name="title" id="" value="<?=$elm->getTitle()?>" />
						</td>
						<td>
							<input type="text" name="left_val" id="" value="<?php echo $elm->getLeft_val();?>" />
						</td>
						<td>
							<input type="text" name="right_val" id="" value="<?php echo $elm->getRight_val();?>" />
						</td>
						<td>
							<input type="text" name="left_msg" id="" value="<?php echo $elm->getLeft_msg();?>" />
						</td>
						<td>
							<input type="text" name="right_msg" id="" value="<?php echo $elm->getRight_msg();?>" />
						</td>
						<td>
							<textarea type="text" name="content" id="" cols="45" rows="2"><?php echo $elm->getContent();?></textarea>
						</td>
						<td>
							<input type="text" name="url" id="" value="<?php echo $elm->getUrl();?>" />
						</td>
						<td>
							<?=$elm->getImage("100px", "100px")?>
							<input type="file" name="fichier" id=""/>
						</td>
						<td>
							<input type="checkbox" name="isonline" id="" <?php echo ($elm->getIsonline() ? "checked" : "");?> />
						</td>
						<td>
							<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
							<input type="submit" name="action" id="" value="updateOpportunite" />
						</td>
					</tr>
				</form>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<div class="containerPerso">
	<div class="moduleBlock">
		<?=$this->OpportuniteModule?>
		<?=$this->SuggestionModule?>
	</div>
</div>

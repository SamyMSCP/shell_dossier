<h2>Tableau des Suggestions</h2>
<div class="showDocumentTypeTable">
	<table border="1">
		<thead>
			<tr>
				<th>PTR</th>
				<th colspan="9">CONTENT</th>
				<th colspan="2">Paramètres</th>
			</tr>
			<tr>
				<th>Numero</th>
				<th>Title</th>
				<th>TitlePicto</th>
				<th>subTitle</th>
				<th>Valeur gauche</th>
				<th>Ouvert</th>
				<th>Type SCPI</th>
				<th>Contenu</th>
				<th>Image</th>
				<th>Url</th>
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
						<input required="1" type="text" name="thetitle" value="" />
					</td>
					<td>
					<?php
						$allimg = scandir($this->getPath() . "/../../module/SuggestionModule/img/picto");
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
						<input required="" type="text" name="title" id="" value="" />
					</td>
					<td>
						<input required="" type="text" name="left_val" id="" />
					</td>
					<td>
						<input type="checkbox" name="right_val" id="" />
					</td>
					<td>
					<?php
						$allimg = scandir($this->getPath() . "/../../module/SuggestionModule/img/scpi");
					?>
						<select name="left_msg" onchange="document.getElementById('picto').src = '<?=$this->getPath()?>' + '../../module/SuggestionModule/img/scpi/' + this.options[this.selectedIndex].value;">
							<option value="">Rien</option>
							<?php foreach($allimg as $v)
								if ($v != "." && $v != "..")
									echo "<option value=\"$v\">$v</option>";
							?>
						</select>
						<img style="height: 100px" id="picto"/>
					</td>
					<!--<td>
						<input required="" type="text" name="right_msg" id=""/>
					</td>-->
					<td>
						<input required="" type="text" name="content" id="" />
					</td>
					<td>
						<input required="" type="file" name="fichier" id="" />
					</td>
					<td>
						<input required="" type="text" name="url" id=""/>
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
			foreach ($this->Suggestion as $key => $elm)
			{
				?>
				<form action="?p=<?=$GLOBALS['GET']['p']?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<tr>
						<td>
							<input type="text" name="id" id="" value="<?=$elm->getId()?>" />
						</td>
						<td>
							<input required="1" type="text" name="thetitle" value="<?=$elm->getTheTitle()?>" />
						</td>
						<td>
						<?php $allimg = scandir($this->getPath() . "/../../module/SuggestionModule/img/picto"); ?>
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
							<input type="text" name="title" id="" value="<?=$elm->getTitle()?>" />
						</td>
						<td>
							<input type="text" name="left_val" id="" value="<?php echo $elm->getLeft_val();?>" />
						</td>
						<td>
							<input type="checkbox" name="right_val" id="" <?php echo  ($elm->getRight_val() ? "checked" : "");?> />
						</td>
						<td>
						<?php
							$allimg = scandir($this->getPath() . "/../../module/SuggestionModule/img/scpi");
						?>
							<select name="left_msg" onchange="document.getElementById('picto<?=$key?>').src = '<?=$this->getPath()?>' + '../../module/SuggestionModule/img/scpi/' + this.options[this.selectedIndex].value;">
								<option value="">Rien</option>
								<?php foreach($allimg as $v)
								if ($v != "." && $v != "..")
									if ($elm->getLeft_msg() == $v)
										echo "<option selected=\"1\" value=\"$v\">$v</option>";
									else
										echo "<option value=\"$v\">$v</option>";
								?>
							</select>
							<img style="height: 100px" id="picto<?=$key?>"/>
						</td>
						<!--<td>
							<input type="text" name="right_msg" id="" value="<?php echo $elm->getRight_msg();?>" />
						</td>-->
						<td>
							<input type="text" name="content" id="" value="<?php echo $elm->getContent();?>" />
						</td>
						<td>
							<?=$elm->getImage("100px", "100px")?>
							<input type="file" name="fichier" id="" />
						</td>
						<td>
							<input type="text" name="url" id="" value="<?php echo $elm->getUrl();?>" />
						</td>
						<td>
							<input type="checkbox" name="isonline" <?php echo ($elm->getIsonline() ? "checked" : "");?> />
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

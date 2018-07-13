<table border="1" class="tableOldData">
	<tr>
	<?php
		foreach($this->data['entete'] as $key => $elm) {
			if ($elm === "DOING")
				continue;
			?>
			<th><?php echo($elm); ?></th>
			<?php
		}
		?>
		<th>Action</th>
		<?php
	?>
	</tr>
	<form action="?<?php if (isset($GLOBALS['GET']['p'])) echo "p=" . $GLOBALS['GET']['p'];?>&haveData=1" method="post" accept-charset="utf-8">
		<datalist id="CIVILITE">
			<option value="M.">
			<option value="Mme">
		</datalist>
		<datalist id="TYPE_DE_COMPTE">
			<?php
			foreach (Dh::getConseillers() as $elm) {
				?>
				<option value="<?=$elm->getLogin()?>">
				<?php
			}
			foreach (Dh::$typeDeCompte as $elm) {
				?>
				<option value="<?=strtoupper($elm)?>">
				<?php
			}
			?>
		</datalist>
		<datalist id="INDICATIF_PAYS">
			<?php
			include("datalistIndicatif.php")
			?>
		</datalist>
		<datalist id="INDICATIF_PAYS2">
			<?php
			include("datalistIndicatif.php")
			?>
		</datalist>
	<?php
		foreach($this->data as $key => $elm) {
		?>
			<tr style="<?php echo (isset($elm["errorFormat"]["alreadyExist"])) ? "background-color:orange;" : "";?>">
			<?php
			if ($key === "entete")
				continue ;
			foreach($this->data['entete'] as $key2 => $elm2) {
				if ($elm2 === "DOING")
					continue;
			?>
			<td>
			<?php
			if (isset($elm["errorFormat"]["alreadyExist"]) && $elm["errorFormat"]["alreadyExist"] == true)
			{
				echo $elm["oldData"][$elm2];
			}
			?>
			<input list="<?=str_replace(" ", "_", $elm2)?>" style="<?php echo (isset($elm["errorFormat"][$elm2])) ? "background-color:red;" : "background-color:transparent;";?>" type="text" name="<?=$key?>_<?=$elm2?>" value="<?=$elm["data"][$elm2] ?>"/>
			</td>
			<?php
			}
			?>
			<td>
			<select name="<?=$key?>_DOING" id="">
				<?php 
					if ($elm['errorFormat']["canAdd"]) {
						echo "<option value='add'";
						if (isset($elm['preSelection']) && $elm['preSelection'] == "add")
							echo " selected ";
						echo ">Ajouter</option>";
					}
					if ($elm['errorFormat']["canUpdate"]) {
						echo "<option value='update'";
						if (isset($elm['preSelection']) && $elm['preSelection'] == "update")
							echo " selected ";
						echo ">Mettre a jours</option>";
					}
					echo "<option value='nothing'";
					if (isset($elm['preSelection']) && $elm['preSelection'] == "nothing")
						echo " selected ";
					echo ">Ne rien faire</option>";
					?>
			</select>
			</td>
			</tr>
		<?php
		}
	?>
		<tr>
			<td colspan="<?php echo count($this->data['entete']) + 1;?>">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<input type="submit" name="what" id="btn_valider" value="Valider" />
				<input type="submit" name="what" id="btn_actualiser" value="Actualiser"/>
			</td>
		</tr>
	</form>
</table>
<a href="?p=<?=$GLOBALS['GET']['p']?>">Retour</a>

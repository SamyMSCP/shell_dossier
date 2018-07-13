<table border="1" class="tableOldData">
	<tr>
	<?php
		foreach(ParseCsvTransaction::getTransactionCheck() as $key => $elm) {
		//	if ($elm === "DOING")
				//continue;
			?>
			<th><?php echo($elm); ?></th>
			<?php
		}
		?>
		<th>Action</th>
	</tr>
	<form action="?<?php if (isset($GLOBALS['GET']['p'])) echo "p=" . $GLOBALS['GET']['p'];?>&haveData=1" method="post" accept-charset="utf-8">
		<datalist id="CIVILITE">
			<option value="">
			<option value="M.">
			<option value="Mme">
		</datalist>
	<?php
		$calcul = NULL;
		$fd = fopen("../cache/importsCsv/SCPI/export.csv", 'w+');
		fputcsv($fd, ParseCsvTransaction::getTransactionCheck());
		foreach($this->data as $key => $elm) {


/////////////////////  Provisoir pour afficher les erreures

			if (
			//	isset($elm['errorFormat']) &&
			//	$elm['errorFormat']["canAdd"]
				!isset($elm['errorFormat']) ||
				!$elm['errorFormat']["canAdd"]
			)
;//				continue ;
//////////////////////////////////////////////////



		?>
			<tr style="<?php echo (isset($elm["errorFormat"]["alreadyExist"])) ? "background-color:orange;" : "";?>">
			<?php
			if ($key === "entete")
				continue ;
			$csv = array();
			foreach(ParseCsvTransaction::getTransactionCheck() as $key2 => $elm2) {
				?>
				<td 
					style="padding:0px;<?php echo (in_array($elm2, $elm['errorFormat']['InvalidParam'])) ? "color:red;" : "";?>"
				>
				<input list="<?=str_replace(" ", "_", $elm2)?>"
					style="<?php
						echo (in_array($elm2, $elm['errorFormat']['InvalidParam'])) ? "background-color:red;" : "background-color:transparent;";?>"
						type="text" name="<?=$key+1?>_<?=$elm2?>" value="<?php
							if ($elm2 !== "Durée si DT")
								echo empty($elm["data"][$elm2]) ? "NONE" : $elm["data"][$elm2];
							else
								echo empty($elm["data"][$elm2]) ? "0" : $elm["data"][$elm2];
						?>"/>

				<?php
						/*
							if ($elm2 !== "Durée si DT")
								echo empty($elm["data"][$elm2]) ? "NONE" : $elm["data"][$elm2];
							else
								echo empty($elm["data"][$elm2]) ? "0" : $elm["data"][$elm2];
								*/
						?>
				</td>
				<?php
				if (in_array($elm2, ParseCsvTransaction::getTransactionCalcul())){
					@$calcul[$elm2] += $elm["data"][$elm2];
				}
				$csv[] = empty($elm["data"][$elm2]) ? "NONE" : $elm["data"][$elm2];
			}
			fputcsv($fd, $csv);
			?>
				<td>



				<select name="<?=$key+1?>_DOING" id="">
					<?php 
						if ($elm['errorFormat']["canAdd"]) {
							echo "<option value='add'";
							if (isset($elm['preSelection']) && $elm['preSelection'] == "add")
								echo " selected ";
							echo ">Ajouter</option>";
						}
						echo "<option value='nothing'";
						if (isset($elm['preSelection']) && $elm['preSelection'] == "nothing")
							echo " selected ";
						echo ">Ne rien faire</option>";
						?>
				</select>
				<?php 
				/*
				*/
				?>


				</td>
			</tr>
		<?php
		}
	?>
		<tr>
			<td colspan="<?php echo count($this->data['entete']) + 1;?>">
				<input type="hidden" name="token" id="token" value="<?=$_SESSION['csrf'][0]?>"/>
				<input type="submit" name="what" id="btn_valider" value="Valider" />
				<input type="submit" name="what" id="btn_actualiser" value="Actualiser"/>
			</td>
		</tr>
	</form>
</table>

<table border="1" class="tableOldData">
	<tr>
		<th>INDEX : </th>
	<?php
		foreach(ParseCsvTransaction::getTransactionCalcul() as $key => $elm) {
			?>
			<th><?php echo($elm); ?></th>
			<?php
		}
		?>
	</tr>
	<tr>
		<th>total : </th>
	<?php
		foreach(ParseCsvTransaction::getTransactionCalcul() as $key => $elm) {
			?>
			<td><?php echo($calcul[$elm]); ?></td>
			<?php
		}
		?>
	</tr>
</table>

<a href="?p=<?=$GLOBALS['GET']['p']?>">Retour</a>

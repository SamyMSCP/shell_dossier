<div id="name_scpi">
<?php
			$temoin = 0;
			$color = array(
				0 => "color: rgb(57, 128, 181);",
				1 => "color: rgb(103, 157, 198);",
				2 => "color: rgb(149, 187, 215);",
				3 => "color: rgb(176, 204, 225);"
			);
			foreach ($this->table as $key => $elm) {
				if ($key === "precalcul")
					continue;
				echo '<h3 style="' . $color[$temoin] . '">';
				echo htmlspecialchars(substr($key , 5)) . " : " . htmlspecialchars(number_format(100 * ($elm['precalcul']["ventePotentielle"] / $this->table['precalcul']['ventePotentielle']), 1, ',', ' ')) . "%</h3>";
				$temoin++;
				if ($temoin === 4)
					break;
			}
			?>
</div>
<?php
/* $len = count($this->scpi);
<div id="name_scpi">
	<h3 style="color: rgb(11, 98, 164);"><?php
	if ($len > 0) echo htmlspecialchars(substr(ft_decrypt_crypt_information($this->scpi[0]->Name), 5)) . " : " . htmlspecialchars(number_format(($this->scpi[0]->getActualValue() * 100 / $this->sum), 1, ',', ' ')) . "%";?></h3>

	<h3 style="color: rgb(57, 128, 181);"><?php
	if ($len > 1) echo htmlspecialchars(substr(ft_decrypt_crypt_information($this->scpi[1]->Name), 5)) . " : " . htmlspecialchars(number_format(($this->scpi[1]->getActualValue() * 100 / $this->sum), 1, ',', ' ')) . "%";?></h3>

	<h3 style="color: rgb(103, 157, 198);"><?php
	if ($len > 2) echo htmlspecialchars(substr(ft_decrypt_crypt_information($this->scpi[2]->Name), 5)) . " : " . htmlspecialchars(number_format(($this->scpi[2]->getActualValue() * 100 / $this->sum), 1, ',', ' ')) . "%";?></h3>

	<h3 style="color: rgb(149, 187, 215);"><?php
	if ($len > 3) echo htmlspecialchars(substr(ft_decrypt_crypt_information($this->scpi[3]->Name), 5)) . " : " . htmlspecialchars(number_format(($this->scpi[3]->getActualValue() * 100 / $this->sum), 1, ',', ' ')) . "%";?></h3>
	<h3 style="color: rgb(11, 98, 164);">
	</h3>
</div>
*/
?>

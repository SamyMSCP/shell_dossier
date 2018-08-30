<div class="moduleVerticalAlign">
	<div class="module moduleMonPortefeuille">
		<div class="moduleTitle">
		<?php
		/*
			<img src="<?=$this->getPath() . "img/Portefeuille_Blanc.png"?>" alt="" />
		*/
		?>
			<span>AGE MOYEN DE MES SCPI</span>
			<img src="<?= $this->getPath()?>img/i-Blanc.svg" class="_tooltip_r" onmouseover="display_tooltip('L\'age moyen de mes SCPI', 'L\'age moyen des SCPI de mon portefeuille en fonction du montant de revente potentielle.', event)" onmouseout="disable_msg(event)">
		</div>
		<div class="moduleContent" style="padding: 10px;">
			<div>
				<span>L'age moyen</span>
				<?=number_format($this->table['precalcul']['ageMoyenScpi'], 2, ",", " ")?> ans
				<?php
				/*
				Si ce donneur d'ordre a des transaction dans une scpi dont la date n'est pas renseignée : la valeur de l'age moyen est érroné.
				*/
				?>
			</div>
			<?php
			/*
			<div style='font-size:14px;'>
				<span>Temporaire</span>
				<ul>
					<?php
					foreach ($this->table as $key => $scpi)
					{
						if ($key == "precalcul")
							continue;
						echo "<li>";
						echo "<ul  style='color:black;font-size:12px;font-weight:normal;text-align:left;'>";
						echo "<li>Nom Scpi : " . $scpi['precalcul']['scpi']->getName() . "</li>";
						echo "<li>Date création API : " . 
							($scpi['precalcul']['scpi']->getDateCreationScpi() instanceof DateTime ? $scpi['precalcul']['scpi']->getDateCreationScpi()->format('d/m/Y') : "date non renseignée") . 
						"</li>";
						echo "<li>Age caculé : " . $scpi['precalcul']['scpi']->getAge() . "</li>";
						echo "<li>ventePotentielle : " . $scpi['precalcul']['ventePotentielle'] . "</li>";
						echo "<li>ventePotentielle * age : " . $scpi['precalcul']['pourAgeMoyenScpi'] . "</li>";
						echo "</ul>";
						echo "</li>";
					}
					?>
				</ul>
					(ventePotentielle * age) total : <?=$this->table['precalcul']['pourAgeMoyenScpi']?>
			</div>
			*/
			?>
		</div>
	</div>
</div>

<div class="projetGlob">
	<?php
		foreach ($this->allProject as $key => $elm)
		{
			?>
			<div class="projetElement1"> 
				<div onclick="showViewProjet('<?=$elm->id?>');" class="projetElement2">
					<h3><?=mb_strtoupper($elm->getName())?></h3>
					<div>
						<img src="<?=$this->getPath()?>img/<?php
						if ($elm->getEtatProjet() >= 8)
							echo "Dossiers-blanc_closed.png";
						else
							echo "Dossiers-blanc_open.png";
						?>" alt="" />
					</div>
					<h2><?php
						if ($elm->getEtatProjet() >= 8)
							echo "FINALISE";
						else
							echo "EN COURS";
						?></h2>
				</div>
			</div>
			<?php
		}
	?>
	<div class="projetElement1"> 
		<div class="projetElement2_dashed">
			<h2>NOUVEAU<br />PROJET</h2>
			<div>
				<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
			</div>
		</div>
	</div>
</div>
<?php
include("modalViewProject.php");
//include("modalViewNewProject.php");
?>

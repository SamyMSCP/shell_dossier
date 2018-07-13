	<div class="moduleContent" style="flex-direction: column;justify-content: space-around;">
		<table border="1" class="tableLstProject">
			<thead>
				<tr>
					<th>Date de création</th>
					<th>Bénéficiaire</th>
					<th>Nom du projet</th>
					<th>Etat</th>
					<th>Actions</th>
				</tr>
			</thead>
				<tbody>
					<?php
					foreach ($this->projets as $key => $elm)
					{
						?>
						<tr 
							<?php
							if ($elm->getEtatProjet() < 3)
							{
								?>
								onclick="window.location.href='?p=InfoProjet&projet=<?=encrypt_url($elm->id)?>'"
								class="canClick"
								<?php
							}
							?>
						>
							<td>
								<?=$elm->getDateCreation()->format("d/m/Y")?>
							</td>
							<td>
								<?=$elm->getBeneficiairesEntity()->getShortName()?>
							</td>
							<td>
								<?=$elm->getName()?>
							</td>
							<td class="etatProjet">
								<?php
									if ($elm->getEtatProjet() == -1)
									{
										?>
										<img src="<?=$this->getPath()?>img/EnCoursCreation-Orange.svg" alt="" />
										<span style="color:#ff9f1c">
											Projet en cours de création
										</span>
										<?php
									}
									else if ($elm->getEtatProjet() == 0)
									{
										?>
										<img src="<?=$this->getPath()?>img/Proposition_BleuClair.png" alt="" />
										<span style="color:#1781e0">
											Projet créé
										</span>
										<?php
									}
									else if ($elm->getEtatProjet() == 1)
									{
										?>
										<img src="<?=$this->getPath()?>img/ProjetReflexionPlan de travail 1.svg" alt="" />
										<span style="color:#1781e0">
											Projet en cours de réflexion
										</span>
										<?php
									}
									else if ($elm->getEtatProjet() == 2)
									{
										?>
										<img src="<?=$this->getPath()?>img/EnCoursRealisation-Bleu.svg" alt="" />
										<span style="color:#1781e0">
											Projet en cours de réalisation
										</span>
										<?php
									}
									else if ($elm->getEtatProjet() == 3)
									{
										?>
										<img src="<?=$this->getPath()?>img/Termine-Vert.svg" alt="" />
										<span style="color:#20BF55">
											Projet finalisé
										</span>
										<?php
									}
									
								?>
							</td>
							<td class="infoProjet">
								<?php
								if ($elm->getEtatProjet() < 3)
								{
									?>
									<img src="<?=$this->getPath()?>img/LoupeBleuClair.svg" alt="" />
									<span style="color:#1781e0;font-weight: 900;">
										Consulter le projet
									</span>
									<?php
								}
								?>
							</td>
						</tr>
						<?php
						
					}
					?>
				</tbody>
		</table>
	</div>

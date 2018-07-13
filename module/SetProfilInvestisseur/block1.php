<div class="modal fade modalAucunRisque" tabindex="-1" role="dialog" aria-labelledby="modalAucunRisque" id="modalAucunRisque">
	<div class="modal-dialog modal-sm preventionCapital" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img style="height:30px;" src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
			<h3>
                Aucune prise de risque
            </h3>
			<p>
                Le niveau de risque "Aucune prise de risque" n'est pas compatible avec un investissement en parts de SCPI.
            </p>
			<div class="lstButton">
				<div data-dismiss="modal" class="btnCapital" style="text-align: center;">Je modifie mes préférences !</div>
			</div>
		</div>
	</div>
</div>
<div class="title title_selected" id="el_1" >
	<p style="font-family: 'Montserrat', sans-serif;">QUEL NIVEAU DE RISQUE ACCEPTEZ-VOUS ?</p>
</div>
<div class="content_body form-horizontal mod_1" style="overflow: hidden;">
	<div>
		<div class="radio">
			<label for="risque-1">
				<input class="inputFirstBlock" type="radio" name="risque" id="risque-1" value="1" ><span></span>
				<i class="fa fa-ban" aria-hidden="true"></i>
				Aucune prise de risque
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Aucune prise de risque', 'Je n\'accepte pas de perte en capital', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
			</label>
		</div>
		<div class="radio">
			<label for="risque-2">
				<input class="inputFirstBlock" type="radio" name="risque" id="risque-2" value="2"><span></span>
				<img src="<?=$this->getPath()?>/img/picto_pdr.svg" alt="" />
				Une prise de risque limitée
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Une prise de risque limitée', 'J\'accepte une baisse au plus de 10% de la valeur de mon capital', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
			</label>
		</div>
		<div class="radio">
			<label for="risque-3">
				<input class="inputFirstBlock" type="radio" name="risque" id="risque-3" value="3"><span></span>
				<i class="fa fa-balance-scale" aria-hidden="true"></i>
				Une prise de risque modérée
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Une prise de risque modérée', 'J\'accepte une baisse au plus de 20% de la valeur de mon capital', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;"> </label>
		</div>
		<div class="radio">
			<label for="risque-4">
				<input class="inputFirstBlock" type="radio" name="risque" id="risque-4" value="4"><span></span>
				<i class="fa fa-signal" aria-hidden="true"></i>
				Une prise de risque importante
				<img class="_tooltip_r" src="<?=$this->getPath()?>img/i_BleuClair.png" onmouseover="display_tooltip('Une prise de risque importante', 'J\'accepte une baisse au plus de 30% de la valeur de mon capital', event)" onmouseout="disable_msg(event)" class="_tooltip" style="height: 22px !important;margin-left: 10px;">
			</label>
		</div>
	</div>
	<div class="btn-next btn-next-inactive">
		<div class="inactive">
			QUESTION SUIVANTE
			<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
		</div>
	</div>
	<div class="btn-next btn-next-step-1" style="display:none;">
		<div class="active" >
			QUESTION SUIVANTE
			<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
		</div>
	</div>
</div>

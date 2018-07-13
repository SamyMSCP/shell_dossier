(function($) {
		$.fn.AlphaLine = function(params) {
			
		// initialisation des variables
		var hauteurG = 0;
		var hauteurD = 0;
		var NbEvent = $(".evenement").length;
		var NbDate = $(".date").length;
		var NbElement = NbEvent + NbDate;
		
		// Parametres par défaut ou compilation par les nouveaux
		var defauts = {'Timing':500, 'Animation':true};
		var parametres = $.extend(defauts, params);
	
		
		// Marquage de chaque evemenent et date
		$('.evenement').each(function(){
				numero = 1 + $(this).index();
				$(this).attr('id', 'evenement'+numero);
				if(parametres.Animation == true){
					$(this).css('opacity',0);
					$(this).addClass('enAnimation');
				}
				//if ()
				if (!$(this).hasClass("gauche") &&
					!$(this).hasClass("droite")
				)
				$(this).append('<span class="fleche"></span>');
		});	
		$('.date').each(function(){
				numero = 1 + $(this).index();
				$(this).attr('id', 'date'+numero);
		});
	
		
		// Pour chaque bloc, on calcule la position et hauteur
		for (i = 0; i < NbElement; i++){
			
			// on calcul la hauteur de chaque colonne
			hautDate = $('#date'+i).outerHeight(true);
			hautBLocG = $('#evenement'+i+'.gauche').outerHeight(true);
			hauteurG = hauteurG + hautBLocG;
			hautBLocD = $('#evenement'+i+'.droite').outerHeight(true);
			hauteurD = hauteurD + hautBLocD;
			
			// Si on rencontre une date, alors on recalcule les hauteurs de chaque colonne et on les met à égalité
			if(hautDate > 0){
				if (hauteurG > hauteurD){
					hauteurG = hauteurG + hautDate;
					hauteurD = hauteurG;
				} else {
					hauteurD = hauteurD + hautDate;
					hauteurG = hauteurD;
				}
			}
			
			blocSuivant = $('#evenement'+(i+1));

			//if (blocSuivant.hasClass('gauche'))
			blocSuivant.removeClass("gauche");
			//if (blocSuivant.hasClass('droite'))
			blocSuivant.removeClass("droite");
			// on attribue la class en fonction
			if (hauteurG > hauteurD){
				$('#date'+(i+1)).css('top', hauteurG);
				blocSuivant.addClass('droite').css('top', hauteurD);
				if(parametres.Animation == true){
					blocSuivant.animate({opacity:1}, parametres.Timing);
				}
				blocSuivant.parent('.alphaLine').css('height', hauteurG);
			} else {
				$('#date'+(i+1)).css('top', hauteurD);
				blocSuivant.addClass('gauche').css('top', hauteurG);
				if(parametres.Animation == true){
					blocSuivant.animate({opacity:1}, parametres.Timing);
				}
				blocSuivant.parent('.alphaLine').css('height', hauteurD);
			}
			
			// Maintenant on calcule les hauteurs totales de chaque colonne
			hauteurTG = hauteurG + $('#evenement'+(i+1)+'.gauche').outerHeight(true);
			hauteurTD = hauteurD + $('#evenement'+(i+1)+'.droite').outerHeight(true);
			
			if (hauteurTG> hauteurTD){
				blocSuivant.parent('.alphaLine').css('height', hauteurTG);
			} else {
				blocSuivant.parent('.alphaLine').css('height', hauteurTD);
			}
		}
			
	}
})(jQuery);

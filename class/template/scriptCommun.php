<script type="text/javascript" charset="utf-8">

	function isNumber(a) {
		return (
			!isNaN(a) &&
			String(a).length > 0
		);
	}
	function myXor(a, b) {
		return ((a && !b) || !a && b);
	}
	function isMobile()
	{
		if( navigator.userAgent.match(/Android/i)
			|| navigator.userAgent.match(/webOS/i)
			|| navigator.userAgent.match(/iPhone/i)
			|| navigator.userAgent.match(/iPad/i)
			|| navigator.userAgent.match(/iPod/i)
			|| navigator.userAgent.match(/BlackBerry/i)
			|| navigator.userAgent.match(/Windows Phone/i)
		)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	$.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
		closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
		prevText: '<Préc', prevStatus: 'Voir le mois précédent',
		nextText: 'Suiv>', nextStatus: 'Voir le mois suivant',
		currentText: 'Courant', currentStatus: 'Voir le mois courant',
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
		'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
		monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
		'Jul','Aoû','Sep','Oct','Nov','Déc'],
		monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
		weekHeader: 'Sm', weekStatus: '',
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
		dateFormat: 'dd/mm/yy', firstDay: 0, 
		initStatus: 'Choisir la date', isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
</script>



<?php
	if (isset($_POST['SaveAbsorption']) && $_POST['SaveAbsorption'] == "Enregistrer")
	{
		if (($_POST['before'] < 1) || ($_POST['after'] < 1))
		{
			Notif::set("msgAbsorbUpdate", "La mise a jours de l'absorption a echouee la valeur <br />minimum des nombres de parts ne peuvent pas etre en dessous de 1");
		}
		else
		{
			$rt = absorption::updateData($_POST['idAbsorption'], $_POST['before'], $_POST['after'], isset($_POST['isActivate']));
			if ($rt)
			{
				Notif::set("msgAbsorbUpdate", "La mise a jours de l'absorption a bien ete effectuee");
				header('Location: ?p=' . $GLOBALS['GET']['p']);
				exit();
			}
			else
			{
				Notif::set("msgAbsorbUpdate", "La mise a jours de l'absorption a echouee");
			}
		}
	}
	$this->absorptionList = absorption::getAll();

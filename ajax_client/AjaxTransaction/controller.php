<?php
/**
 * MSCPI
 * -----
 * @file
 */

require_once("class/core/AjaxClient.php");


class AjaxTransaction extends AjaxClient
{
	/**
	 * @param $data
	 * $data = [
	 *		scpi => id
	 *		part => string
	 * 		propriete => string
	 * 		date => date (Y-m-d)
	 * 		]
	 */
	public function create($data) {
		global $dh;

		if (!isset($dh))
			$dh = Dh::getCurrent();

		$date = time() - 86400;
		//CHECK MORE THAN MAX
		if (count(Logger::getByTypeExecutantSince('Ajout d\'une transaction front client', $dh->id_dh, $date)) >= MAX_TRANSACTION_PER_DAY)
		{
			Notif::set('Transactions', 'Vous avez atteint le maximum d\'ajout de transaction sous ces dernières 24H.');
			error([]);
		}

		//NOTE: Working on SCPI
		if (empty($data['scpi']) || (!$scpi = Scpi::getFromId($data)) || !$scpi->isShow())
			error("SCPI Incorrecte");

		//NOTE: Working on part
		$nbr_part = trim($data['part']);
		if (empty($nbr_part) || !preg_match("/^\d{1,}((\.|,)(\d{1,5}))?$/", $nbr_part))
			error('Parts incorrectes.');
		$nbr_part = floatval(str_replace(',','.',$nbr_part));

		//NOTE: Working on propriete
		if (empty($data['propriete']) || !in_array($data['propriete'], Transaction::getTypeProLst()))
			error('Propriété incorrecte.');

		$date = 0;
		if (!empty($data['date']))
		{
			if (!($date2 = DateTime::createFromFormat("Y-m-d", $data["date"])))
				$date2 = DateTime::createFromFormat("d/m/Y", $data["date"]);
			if ($date2 instanceof DateTime)
				$date = ft_crypt_information($date2->format("d/m/Y"));
			else
				error("Date d'enregistrement incorrect.");
		}
	}
}

<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 14/05/2018
 * Time: 16:01
 */


//require_once(__DIR__ . "/../function/config.php");
//require_once(__DIR__ . "/class/core/Database.php");

require_once(__DIR__ . "/app.php");

Cli::cli_only();

require_once(__DIR__ . "/class/core/Apiv2.php");
require_once(__DIR__ . "/class/Apiv2Db.php"); // pour les doublons






function updateList($el, $mdb, $l_name) {

    echo "\e[90m/* ****************************************************************************************************************** */\e[0m" . PHP_EOL;
    foreach ($el as $client) {
        echo "\n\t\t\t\e[32;4e id\e[0m : " . $client->id;
        echo "\n\t\t\t\e[32;4e mail\e[0m: " . $client->mail . PHP_EOL;
        //echo "\e[90m* \e[32;4midentitee\e[0m : " . $client->merge_fields->PRENOM . " " . $client->merge_fields->NOM . PHP_EOL;

        $prenom = "";
        $nom = "";
        $phone = "";
        $type = "";
        $typeComplement="";
        $origin="";
        $merged = (array)($client);
        if (array_key_exists("prenom", $merged))
        {
            $prenom = $merged['prenom'];
            $nom = $merged['nom'];
            $phone = $merged['telephone'];
            $type = $merged['type'];
            $typeComplement = $merged['typeComplement'];
            $origin = $merged['origin'];


            echo "\t\t\t\e[32;4e prenom\e[0m : " .$prenom;
            echo "\n\t\t\t\e[32;4e nom\e[0m : " .$nom;
            echo "\n\t\t\t\e[32;4e phone\e[0m : " .$phone;
            echo "\n\t\t\t\e[32;4e type\e[0m : " .$type;
            echo "\n\t\t\t\e[32;4e typeComplement\e[0m : " .$typeComplement;
            echo "\n\t\t\t\e[32;4e Origine\e[0m : " .$origin;
            echo "\n";



        }


        $phone = "+33" . substr($phone, 1);

        if ($mdb->AddUser(["id_api" => $client->id], $client->type, $client->typeComplement, $client->origin, $client->date->date) == true);
        {
            //A ete ajouter a la liste -> doit checker, creer un compte et ajouter une CRM en fonction
            if (count(Dh::getByLogin($client->mail)) == 0)
            {
                $user['mail'] = $client->mail;
                $user['nom'] = $nom;
                $user['prenom'] = $prenom;
                $user['num'] = $phone;
                $user['message'] = $client->message;
                $user['type']= $client->type;
                $user['origin']= $client->origin;
                $user['typeComplement']= $client->typeComplement;



                if (!is_null($client->civilite)) {
                    $user['pays'] = $client->date->timezone;
                }
                else {
                    $user['pays'] = "France";
                }


                if (!is_null($client->civilite)) {
                    $user['civilite'] = $client->civilite;
                }
                else {
                    $user['civilite'] = "Monsieur";
                }

                echo "\e[90m* \e[32;4mid\e[0m : " . $user['mail'];


                addNewUser($user, $l_name, $mdb,$client->type, $client->typeComplement, $client->origin);

                if (
                    !is_null($user['mail'] = $client->mail) &&
                    !is_null($user['nom'] = $nom) &&
                    !is_null($user['prenom'] = $prenom) &&
                    !is_null($user['num'] = $phone) &&
                    !is_null($user['message'] = $client->message) &&
                    !is_null($user['type']= $client->type) &&
                    !is_null($user['origin']= $client->origin)) {
                    $dh = Dh::getByLogin($user['mail'])[0];
                    /* ************************************************ < CREATION CRM > ************************************************ */
                    $date_execution = new DateTime("NOW");
                    $ok = $date_execution->modify("+1 second");
                    $texte = "\nLe client à laissé un message sur meilleurescpi : " . $user['message'] . "<br>" . "Lien : " . $user['origin'] . "<br>" . "Page : " . $user['type']."<br>"."Complement : ".$user['typeComplement'];
                    $id_crm = Crm2::insertNew(
                        $dh->id_dh,
                        10,
                        0,
                        $ok->getTimestamp(),
                        -2700,
                        $texte,
                        [],
                        0
                    );

                    Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);

                }


            }
            else {

                $dh = Dh::getByLogin($client->mail)[0];
                /* ************************************************ < CREATION CRM > ************************************************ */
                $date_execution = new DateTime("NOW");
                $texte = "\nLe client à laissé un message sur meilleur meilleurescpi : ". $client->message;
                $id_crm = Crm2::insertNew(
                    $dh->id_dh,
                    0,
                    0,
                    $date_execution->getTimestamp(),
                    -2700,
                    $texte,
                    [],
                    0
                );
//				Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);
                Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);
                /* *********************************************** </ CREATION CRM /> *********************************************** */
            }
        }
        echo "\e[90m/* ****************************************************************************************************************** */\e[0m" . PHP_EOL;
    }
}


function addNewUser($user, $l_name, $mdb,$type,$complement,$orgin) {

    // Verifier si l'adresse mail est renseignée
    if (!isset($user['mail']) || empty($user['mail']))
    {
        echo('\033[31mUne erreure est survenue lors de la creation de compte\033[0m' . PHP_EOL);
        return (0);
    }
    $mail = strtolower(htmlspecialchars(trim($user['mail'])));

    // Verifier si l'adresse mail a un format valide.
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
        $user['mail'] = " ";
        echo("\033[90m* \033[31mL'adresse mail renseignée n'a pas un format valide \033[0m" . PHP_EOL);
        return (0);
    }

    $domainCheck = MailSender::checkBann($user['mail']);
    if ($domainCheck != false)
    {
        $user['mail'] = " ";
        echo("\033[90m* \033[31mLe domaine $domainCheck n'est pas autorisé pour la création de compte\033[0m" . PHP_EOL);
        return (0);
    }

    // Verifier si l'adresse mail renseignée n'est pas deja utilisee.
    if (!empty(Dh::getByLogin($mail)))
    {
        $user['mail'] = " ";
        echo('Cette adresse email est déjà utilisée par un autre utilisateur');
        return (0);
    }

    // Verification du nom
    if (
        !isset($user['nom']) ||
        strlen($user['nom']) < 2 ||
        strlen($user['nom']) > 42 ||
        check_name($user['nom'])
    )
    {
        echo("\033[90m* \033[31mLe nom renseigné n'est pas valide\033[0m" . PHP_EOL);
        return (0);
    }
    $nom = htmlspecialchars(trim($user['nom']));
    $nom = strtoupper($nom);

    // Verification du prenom
    if (
        !isset($user['prenom']) ||
        strlen($user['prenom']) < 2 ||
        strlen($user['prenom']) > 42 ||
        check_name($user['prenom'])
    )
    {
        echo("\033[90m* \033[31mLe prénom renseigné n'est pas valide\033[0m" . PHP_EOL);
        return (0);
    }

    $prenom = htmlspecialchars(trim($user['prenom']));
    $prenom = ucfirst(strtolower($prenom));

    //Verifier numero detelephone portable
    //TODO: Here verif number
    if (($user['num']) == "+33")
        $user['num'] = "+33000000000";
    else if (
        !isset($user['num']) ||
        !isset($user['pays']) ||
        !check_tel_mobile_okay($user['num'], $user['pays'])
    )
    {
        echo("\033[90m* \033[31mLe numéro de téléphone renseigné n'est pas valide\033[0m" . PHP_EOL);
        return (0);
    }
    $num = htmlspecialchars(trim($user['num']));
    $pays = htmlspecialchars(trim($user['pays']));


    //NOTE: Generation de mot de passe
    $user['pass'] = "Ms" . generateRandomString(7) . "75";
    //Check du mot de passe
    if (
        !isset($user['pass']) ||
        !check_mdp_ok($user['pass'])
    )
    {
        echo("\033[90m* \033[31mLe format du mot de passe n'est pas accepté\033[0m" . PHP_EOL);
        return (0);
    }
    $pass = $user['pass'];

    // Verificatin de la civilité
    if (
        !isset($user['civilite']) ||
        (
            $user['civilite'] != "Madame" &&
            $user['civilite'] != "Monsieur"
        )
    )
    {
        echo("\033[90m* \033[31mLa civilité n'est pas correcte\033[0m" . PHP_EOL);
        return (0);
    }
    $civilite = $user['civilite'];

    // Verifier le captcha.
    if ($num != "+33000000000" && !SmsSender::check($num))
    {
        $user['mail'] = " ";
        echo("\033[90m* \033[31mLe numéro de téléphone renseigné n'est pas valide\033[0m" . PHP_EOL);
        return (0);
    }

    if (!MailSender::verify($user['mail']))
    {
        $user['mail'] = " ";
        echo("\033[90m* \033[31mL'adresse mail renseignée n'est pas valide\033[0m" . PHP_EOL);
        return (0);
    }


    // Ajouter Dh
    $dh = Dh::insertNew(
        $mail,
        $pass
    );
    if (!$dh)
    {
        echo("\033[90m* \033[31mImpossible d'inserer le donneur d'ordre\033[0m" . PHP_EOL);
        return (0);
    }
    $dh = Dh::getById($dh);
    // Insert Pp
    $Pp = Pp::insertMini($dh->id_dh, $civilite, $prenom, $nom);
    if (!$Pp)
    {
        echo("\033[90m* \033[31mImpossible d'inserer la personne physique\033[0m" . PHP_EOL);
        return (0);
    }

    $Pp = Pp::getFromId($Pp)[0];


    $dh->updateOneColumn("lien_phy", $Pp->id_phs);
    $dh->updateOneColumn("mdp_tmp", 1);
    //$Pp->updateOneColumn("mail", ft_crypt_information($mail));
    $Pp->setMail($mail);
    $Pp->updateOneColumn("telephone", ft_crypt_information($num));
    $Pp->updateOneColumn("indicatif_telephonique", $pays);

//	$dh->setConseillerRandom();
//	$dh->setConseillerRandom();
    $dh->updateOneColumn("conseiller", 10);

    $dh->setConnectedNoIp();


    $Pp = Pp::getFromId($Pp->id_phs)[0];
    $params = [
        "id" => $Pp->id_phs,
        "Infos " => $Pp->getShortName(),
        "Phone" => $Pp->getPhone()
    ];
    Logger::setNew("Ajout d'une personne physique", $dh->id_dh, $dh->id_dh, $params);
    //TODO: ADD PARRAIN ID
//	if (isset($_SESSION['utm'])) // Si on a récupéré un utm
//	{
//		$parrain = Dh::getFromKeyValue("token_affiliation", $_SESSION['utm']);
//		if (!empty($parrain))
//			$dh->updateOneColumn("id_parrain", $parrain[0]->id_dh);
//	}
    $dh = Dh::getById($dh->id_dh);
    $dh->updateOneColumn("create_from", 10);

    /* ************************************************ < CREATION CRM > ************************************************ */
    $date_execution = new DateTime("NOW");
    $texte = "\nLe compte du client à été crée automatiquement suite au message sur  meilleurescpi";

    $id_crm = Crm2::insertNew(
        $dh->id_dh,
        4,
        0,
        $date_execution->getTimestamp(),
        -2700,
        $texte,
        [],
        0
    );
    Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 1);

    /* *********************************************** </ CREATION CRM /> *********************************************** */


//				Crm2::getFromId($id_crm)[0]->updateOneColumn("priority", 5);


    //$dh = Dh::getById($dh->id_dh);
    $params = [
        "id" => $dh->id_dh,
        "login" => $dh->getLogin(),
        "biais" => "Api",
        "id_crm" => $id_crm,
        'link' => '?p=EditionClient&client=' . $dh->id_dh . '&onglet=SUIVI&id_crm=' . $id_crm,
        "IP" => "127.0.0.1"
    ];

    echo '?p=EditionClient&client=' . $dh->id_dh . '&onglet=SUIVI&id_crm=' . $id_crm;
    $params['origine'] = "Api";
    Logger::setNew("Creation de compte", $dh->id_dh, $dh->id_dh, $params);



    return (1);
}

// var_dump(Apiv2::getRequestJsonContactPeriod(3));
// exit();

//echo ($mca->getNormalUsers());
// je recupere les contacts chaque journée, car le script est executé une fois par jour.

/* ****************************************************************************************************************** */
try {
    updateList(json_decode(Apiv2::getRequestJsonContactPeriod(2)), new Apiv2Db(), "Guide de la SCPI");
}
catch (Exception $e) {
    echo "\033[31;4;m* NORMAL ERROR: " . $e . "\033[0m;";
}
/* ****************************************************************************************************************** */


/*
 * Tache :
 *
 * - Ne pas oublier de rajouter cette classe dans le fichier qui lance toute les jours le script
 */
?>
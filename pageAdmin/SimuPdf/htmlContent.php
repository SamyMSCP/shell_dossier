<style>
    .tableDividendes td{
        text-align:right;
    }
    .tabcenter{
        margin-left:auto;
        margin-right:auto;
    }
</style>

<page_header>
    <img width="194" src="<?= dirname(__FILE__) . "/../../class/pdfRessources/img/MS-Logo-RVB.png" ?>">
</page_header>
<p style="text-align: center;margin-top:0;padding-top:0;">
    <span class="protips" style="margin-left:120mm;font-size:14px;">Le <?= date_fr(date("d F Y")) ?>,</span>
</p>
<h1>Simulation d'investissement USUFRUIT (1er partie)</h1>
<table class="s9">
    <thead>
    <tr>
        <!--

                    <th scope="col" style="width: 15%">Nom de la SCPI<br><br></th>
                    <th scope="col" style="width: 10%">Nombre de parts</th>
                    <th scope="col" style="width: 10%">Montant en Usufruit (€)</th>
                    <th scope="col">Durée du démembrement (nombre d'année entre 3 et 20 ans)</th>
                    <th scope="col">Prix par part (en pleine propriété) (€)</th>
                    <th scope="col">Clé de répartition nue propriété (%)</th>
                    <th scope="col">Clé de répartition usufruit (%)</th>
        <th scope="col">Montant global d'investissement (€)</th>
        <th scope="col" style="width: 10%">Montant en nue-propriété (€)</th>
        <th scope="col">IS </th>
         -->

        <th><h5>Nom de la SCPI</h5></th>
        <th scope="col"><h5>Nombre de parts</h5></th>
        <th scope="col"><h5>Montant en Usufruit (€)</h5></th>
        <th scope="col" style="width: 8%"><h5>Durée du démembrement</h5></th>
        <th scope="col"><h5>Prix par part (en pleine propriété) (€)</h5></th>
        <th scope="col"><h5>Clé de répartition nue propriété (%)</h5></th>
        <th scope="col"><h5>Clé de répartition usufruit (%)</h5></th><!-- lui -->
        <th scope="col" style="width: 15%"><h5>Montant global d'investissement (€)</h5></th> <!-- lui -->
        <th scope="col" style="width: 17%"><h5>Montant en nue-propriété (€)</h5></th> <!-- lui -->

    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center" style="overflow-wrap: break-word"><p class="bloc"><?= $nom_Scpi ?></p></td>
        <td align="center"><?= number_format(round($nombre_Parts,2), 2, ',', ' ') ?></td>
        <td align="center"><?= number_format(round($montant_Usufruit,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 5%"><?= $duree_Demembrement ?></td>
        <td align="center"><?= number_format(round($prix_Part,2), 2, ',', ' ') ?></td>
        <td align="center"><?= number_format(round($cle_Repartition_Nue_Propriete,2), 2, ',', ' ') ?></td>
        <td align="center"><?= number_format(round($cle_Repartition_usufruit,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 15%"><?= number_format(round($montant_Global_Investissement,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 17%"><?= number_format(round($montant_Nue_Propriete,2), 2, ',', ' ') ?></td> <!-- faire un ++ -->

    </tr>
    </tbody>
    </table>
<br>
    <table>
    <thead>
    <tr>
        <th scope="col" style="width: 14.28%"><h5>Année</h5></th>
        <th scope="col" style="width: 14.28%"><h5>TDVM Prévisionnel</h5></th>
        <th scope="col" style="width: 14.28%"><h5>Dividende Annuel</h5></th>
        <!-- <th scope="col" style="width: 12%"><h5>Soit un acompte trimestriel</h5></th> -->
        <!-- <th scope="col" style="width: 12%"><h5>Soit un dividende annuel par part de</h5></th> -->
        <th scope="col" style="width: 14.28%"><h5>Flux avant fiscalité</h5></th>
        <th scope="col" style="width: 14.28%"><h5>Amortissement usufruit</h5></th>
        <th scope="col" style="width: 14.28%"><h5>IS à payer</h5></th>
        <th scope="col" style="width: 14.28%"><h5>Flux après fiscalité</h5></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center" style="width: 4%">0</td>
        <td align="center" style="width: 12%"></td>
        <td align="center" style="width: 12%"></td>
        <!--   <td align="center" style="width: 12%"></td> -->
      <!--     <td align="center" style="width: 12%"></td> -->
        <td align="center" style="width: 12%"><?= number_format(round($montant_Usufruit_negatif,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 12%"></td>
        <td align="center" style="width: 12%"></td>
        <td align="center" style="width: 12%"></td>
    </tr>
    <?php
    for ($i = 1; $i <= $duree_Demembrement; $i++)
    {
    ?>
    <tr>
        <td align="center" style="width: 4%"><?= $i ?></td>
        <td align="center" style="width: 12%"><?=  number_format(round($tdvm_Previsionnel,2), 2, ',', ' ') ?> %</td>
        <td align="center" style="width: 12%"><?=  number_format(round($dividende_Annuel,2), 2, ',', ' ') ?></td>
        <!--  <td align="center" style="width: 12%"><?=  number_format(round($acompte_Trimestriel,2), 2, ',', ' ') ?></td> -->
        <!--  <td align="center" style="width: 12%"><?=  number_format(round($dividende_Annuel_Part,2), 2, ',', ' ') ?></td> -->
        <td align="center" style="width: 12%"><?=  number_format(round($flux_Avant_Fiscalite,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 12%"><?=  number_format(round($amortissement_Usufruit,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 12%"><?=  number_format(round($is_A_Payer,2), 2, ',', ' ') ?></td>
        <td align="center" style="width: 12%"><?=  number_format(round($flux_Apres_Fiscalite,2), 2, ',', ' ') ?></td>
    </tr>
        <?php
    }
    ?>


    </tbody>
</table>
<page_footer>
    <img src="<?= dirname(__FILE__) ?>/../../class/pdfRessources/img/Bandeau-Moncompte.jpg" alt="" width="750" />
    <p style="font-size:9px">Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris - Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z - Site internet : <a href="http://www.meilleurescpi.com">MeilleureSCPI.com</a> Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a> - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce <a href="https://fr.slideshare.net/secret/IxSPbzQVQ2T5os">lien</a>) Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants :
        - dix jours ouvrables maximum à compter de la réception de la réclamation, pour accuser réception, sauf si la réponse elle-même est apportée au client dans ce délai ;
        - deux mois maximum entre la date de réception de la réclamation et la date d’envoi de la réponse au client sauf survenance de circonstances particulières dûment justifiées. Le réclamant peut notamment s’adresser à : L’ACPR, L’AMF, L’ANACOFI.

        MeilleureSCPI.com est inscrit à l’ORIAS sous le numéro d’immatriculation 13000814 (<a href="http://www.orias.fr">www.orias.fr</a>) au titre des activités réglementées suivantes :
        - Conseiller en investissement financier (CIF) enregistré auprès de l’ANACOFI-CIF, association agréée par l’Autorité des Marchés Financiers (AMF)
        - Courtier d'assurance ou de réassurance (COA) positionné dans la catégorie b Art. L520-1 II 1° du Code des assurances ;
        - Mandataire d’intermédiaire d’assurance (MIA)
        - Mandataire non exclusif en opérations de banque et en services de paiement (MOBSP)
        La société ne peut recevoir aucun fonds, effets ou valeurs.
        MeilleureSCPI.com dispose, conformément à la loi et au code de bonne conduite de l’ANACOFI-CIF, d’une couverture en Responsabilité Civile Professionnelle suffisante couvrant ses diverses activités.
        Ce document n'a aucune valeur contractuelle et ne saurait en aucun cas engager la responsabilité de MeilleureSCPI.com.
    </p>
</page_footer>
</page>
<page>

    <page_header>
        <img width="194" src="<?= dirname(__FILE__) . "/../../class/pdfRessources/img/MS-Logo-RVB.png" ?>">
    </page_header>
    <br>
    <br>
    <br>
    <br>
    <br><br><br><br>
    <p style="text-align: center;margin-top:0;padding-top:0;">
        <span class="protips" style="margin-left:120mm;font-size:14px;">Le <?= date_fr(date("d F Y")) ?>,</span><br>
    </p>
    <h1>Simulation d'investissement USUFRUIT (2ème partie)</h1>
<table class="s4">
    <thead>
    <tr>
        <th></th>
        <th><h5>Hypothèse basse</h5></th>
        <th><h5>Hypothèse moyenne</h5></th>
        <th><h5>Hypothèse haute</h5></th> <!-- lui -->
    </tr>
    </thead>
    <tbody>

    <tr>
        <th scope="row"><h5 class="aligner-droite" style="font-size: 10px">TDVM Prévisionnel sur la période</h5></th> <!-- faire un ++ -->
        <td align="center"><?= number_format(round($hypothese_Basse,2), 2, ',', ' ') ?> %</td>
        <td align="center"><?= number_format(round($hypothese_Medium,2), 2, ',', ' ') ?> %</td>
        <td align="center"><?= number_format(round($hypothese_Haute,2), 2, ',', ' ') ?> %</td>

    </tr>
    <!--  <tr>
        <th scope="row"><h5 class="aligner-droite" style="font-size: 10px">Soit un dividende annuel par part de </h5></th>
        <td align="center"><?= number_format(round($dividende_Annuel_Part_Basse,2), 2, ',', ' ') ?></td>
        <td align="center"><?= number_format(round($dividende_Annuel_Part,2), 2, ',', ' ') ?></td>
        <td align="center"><?= number_format(round($dividende_Annuel_Part_Haute,2), 2, ',', ' ') ?></td>
    </tr> -->

    <tr>
        <th scope="row"><h5 class="aligner-droite" style="font-size: 10px">TRI avant Fiscalité </h5></th> <!-- faire un ++ -->
        <td align="center"><?= number_format(round($irr_Avant_Basse,2), 2, ',', ' ') ?> %</td>
        <td align="center"><?= number_format(round($irr_Avant_Medium,2), 2, ',', ' ') ?> %</td>
        <td align="center"><?= number_format(round($irr_Avant_Haute,2), 2, ',', ' ') ?> %</td>
    </tr>
    <tr>
        <th scope="row"><h5 class="aligner-droite" style="font-size: 10px">TRI après Fiscalité IS</h5></th> <!-- faire un ++ -->
        <td align="center"><?= number_format(round($irr_Apres_Basse,2), 2, ',', ' ') ?> %</td>
        <td align="center"><?= number_format(round($irr_Apres_Medium,2), 2, ',', ' ') ?> %</td>
        <td align="center"><?= number_format(round($irr_Apres_Haute,2), 2, ',', ' ') ?> %</td>
    </tr>
    <tr>
        <th scope="row"><h5 class="aligner-droite" style="font-size: 10px">Gain net potentiel (€)</h5></th> <!-- faire un ++ -->
        <td align="center"><?= number_format(round($gain_Net_Basse,2), 2, ',', ' ') ?></td>
        <td align="center"><?= number_format(round($gain_Net_Medium,2), 2, ',', ' ')  ?></td>
        <td align="center"><?= number_format(round($gain_net_Haute,2), 2, ',', ' ')  ?></td>
    </tr>
    </tbody>

</table>

<p>
    Ce document ne remplace pas ceux transmis par la ou les société(s) de gestion. Il a pour but une lecture plus simple de ses dividendes. Les informations sont données à titre indicatives et ne sont pas contractuelles.<br />
    <br />
    À noter que les dividendes perçus peuvent être légèrement différents de ceux indiqués dans ce tableau. Par ailleurs, certaines sociétés de gestion indiquent un dividende brut de fiscalité (L'impôt étranger prélevé à la source est neutralisée lors de l’imposition en France).
</p>
<p>NR : Non renseigné</p>
    <page_footer>
        <img src="<?= dirname(__FILE__) ?>/../../class/pdfRessources/img/Bandeau-Moncompte.jpg" alt="" width="750" />
        <p style="font-size:9px">Nom : MeilleureSCPI.com - Siège social : 4, rue de la Michodière - 75002 Paris - Forme juridique : S.A.S. au capital de 10 000 € - Siret 532 567 583 0010 RCS de Paris - NAF/APE : 7022Z - Site internet : <a href="http://www.meilleurescpi.com">MeilleureSCPI.com</a> Conformément aux dispositions de l'article 325-12-1 du règlement de l’AMF, MeilleureSCPI.com a établi une procédure efficace et transparente en vue du traitement raisonnable et rapide des réclamations que lui adressent ses clients existants ou potentiels. Vous pouvez adresser vos réclamations par voie postale : à l’adresse suivante : MeilleureSCPI.com - Service Clients / Gestion des réclamations - 4, rue de la Michodière - 75002 Paris - par email : <a href="mailto:reclamation@meilleurescpi.com">reclamation@meilleurescpi.com</a> - par téléphone : 01 82 28 90 28 et en remplissant le formulaire de réclamation (en cliquant sur ce <a href="https://fr.slideshare.net/secret/IxSPbzQVQ2T5os">lien</a>) Votre Conseiller s’engage à traiter votre réclamation dans les délais suivants :
            - dix jours ouvrables maximum à compter de la réception de la réclamation, pour accuser réception, sauf si la réponse elle-même est apportée au client dans ce délai ;
            - deux mois maximum entre la date de réception de la réclamation et la date d’envoi de la réponse au client sauf survenance de circonstances particulières dûment justifiées. Le réclamant peut notamment s’adresser à : L’ACPR, L’AMF, L’ANACOFI.

            MeilleureSCPI.com est inscrit à l’ORIAS sous le numéro d’immatriculation 13000814 (<a href="http://www.orias.fr">www.orias.fr</a>) au titre des activités réglementées suivantes :
            - Conseiller en investissement financier (CIF) enregistré auprès de l’ANACOFI-CIF, association agréée par l’Autorité des Marchés Financiers (AMF)
            - Courtier d'assurance ou de réassurance (COA) positionné dans la catégorie b Art. L520-1 II 1° du Code des assurances ;
            - Mandataire d’intermédiaire d’assurance (MIA)
            - Mandataire non exclusif en opérations de banque et en services de paiement (MOBSP)
            La société ne peut recevoir aucun fonds, effets ou valeurs.
            MeilleureSCPI.com dispose, conformément à la loi et au code de bonne conduite de l’ANACOFI-CIF, d’une couverture en Responsabilité Civile Professionnelle suffisante couvrant ses diverses activités.
            Ce document n'a aucune valeur contractuelle et ne saurait en aucun cas engager la responsabilité de MeilleureSCPI.com.
        </p>
        <div style="text-align: right; font-style: italic; font-size: 11px"> Page [[page_cu]]/[[page_nb]]</div>
    </page_footer>

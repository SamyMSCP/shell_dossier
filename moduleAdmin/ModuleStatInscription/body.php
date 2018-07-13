<h1>Module Stat Inscription</h1>
<h2>Récupération dans l'API</h2>
<?php
$tabTotal=Array();
for($i=10; $i>0; $i--){
    $tabTotal[$i]=0;
}
?>
<table border="1" class="tableStats">
    <tr>
        <th>Nom du Produit</th>
        <th><?= Dh::jour_actuelle()[9] ?></th>
        <th><?= Dh::jour_actuelle()[8] ?></th>
        <th><?= Dh::jour_actuelle()[7] ?></th>
        <th><?= Dh::jour_actuelle()[6] ?></th>
        <th><?= Dh::jour_actuelle()[5] ?></th>
        <th><?= Dh::jour_actuelle()[4] ?></th>
        <th><?= Dh::jour_actuelle()[3] ?></th>
        <th><?= Dh::jour_actuelle()[2] ?></th>
        <th><?= Dh::jour_actuelle()[1] ?></th>
        <th> lien </th>

    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Fiche produit</th>
    </tr>
    <?php
    /*
    <tr>
        <th>Clients MSCPI</th>
        <td><?=$this->datas->getClientsNbr()?></td>
        <td><?=number_format($this->datas->getClientsValorisation(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsValorisationMoyenne(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsValorisationMscpi(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
        </tr>
    <tr>
        <th>Prospects MSCPI</th>
        <td><?=$this->datas->getProspectsNbr()?></td>
        <td><?=number_format($this->datas->getProspectsValorisation(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getProspectsValorisationMoyenne(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getProspectsValorisationMscpi(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getProspectsValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
    </tr>
    <tr>
        <th>Total MSCPI</th>
        <td><?=$this->datas->getClientsTotalNbr()?></td>
        <td><?=number_format($this->datas->getClientsTotalValorisation(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsTotalValorisationMoyenne(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsTotalValorisationMscpi(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsTotalValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
    </tr>
    */
    ?>

    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->nbrFicheProduitParScpi as $key => $value) {

    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>

        <th>-</th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Fiche contact</th>
    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrPageContact as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];

            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>

    <tr>
        <th colspan="11" style="background-color: #01528a">Pages guides</th>
    </tr>
    <?php
    /*
    <tr>
        <th>Clients MSCPI</th>
        <td><?=$this->datas->getClientsNbr()?></td>
        <td><?=number_format($this->datas->getClientsValorisation(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsValorisationMoyenne(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsValorisationMscpi(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
        </tr>
    <tr>
        <th>Prospects MSCPI</th>
        <td><?=$this->datas->getProspectsNbr()?></td>
        <td><?=number_format($this->datas->getProspectsValorisation(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getProspectsValorisationMoyenne(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getProspectsValorisationMscpi(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getProspectsValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
    </tr>
    <tr>
        <th>Total MSCPI</th>
        <td><?=$this->datas->getClientsTotalNbr()?></td>
        <td><?=number_format($this->datas->getClientsTotalValorisation(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsTotalValorisationMoyenne(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsTotalValorisationMscpi(), 2, ",", " ")?> €</td>
        <td><?=number_format($this->datas->getClientsTotalValorisationMscpiMoyenne(), 2, ",", " ")?> €</td>
    </tr>
    */
    ?>

    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrPageGuides as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Landing Marketing</th>
    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrLandingMarketing as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Landing Produit</th>
    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrLandingProduit as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Landing Réseaux</th>

    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrLandingCreation as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];

            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Landing Société de gestion</th>

    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrPageSocieteGeston as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Landing Etude personnalisée</th>

    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrEtudePersonnalise as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Landing Guides</th>

    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    foreach ($this->datas->NbrLandingGuide as $key => $value) {
    ?>
    <tr>
        <td><?= $key ?></td>
        <?php

        for($i=10; $i>0; $i--) {
            ?>
            <td><?= $value[$i] ?></td>
            <?php
            if($i==1) continue;
            $tab[$i]+=$value[$i];
            $tabTotal[$i]+=$value[$i];
        }
        }
        ?>
    </tr>

    <tr>
        <th>Sous-total</th>
        <th><?= $tab[10] ?></th>
        <th><?= $tab[9] ?></th>
        <th><?= $tab[8] ?></th>
        <th><?= $tab[7] ?></th>
        <th><?= $tab[6] ?></th>
        <th><?= $tab[5] ?></th>
        <th><?= $tab[4] ?></th>
        <th><?= $tab[3] ?></th>
        <th><?= $tab[2] ?></th>
        <th><?= $tab[1] ?></th>
    </tr>
    <tr>
        <th colspan="11" style="background-color: #01528a">Total</th>

    </tr>
    <?php
    $tab=Array();
    for($i=10; $i>0; $i--){
        $tab[$i]=0;
    }
    ?>
    <td> Total</td>
    <?php

    for($i=10; $i>1; $i--) {
        ?>
        <td><?= $tabTotal[$i] ?></td>
        <?php

    }
    ?>
        <td>lien</td>
    </tr>

</table>

<h2>Origine des comptes cr&eacute;&eacute;s</h2>
<?php
	$stats = Dh::getWhereFromStatsDay();
?>
<h2>Activité du jour</h2>
<table border="1" class="tableStats">
    <tr>
        <th>Action</th>
        <th><?= Dh::jour_actuelle()[10] ?></th>
        <th><?= Dh::jour_actuelle()[9] ?></th>
        <th><?= Dh::jour_actuelle()[8] ?></th>
        <th><?= Dh::jour_actuelle()[7] ?></th>
        <th><?= Dh::jour_actuelle()[6] ?></th>
        <th><?= Dh::jour_actuelle()[5] ?></th>
        <th><?= Dh::jour_actuelle()[4] ?></th>
        <th><?= Dh::jour_actuelle()[3] ?></th>
        <th><?= Dh::jour_actuelle()[2] ?></th>
        <th><?= Dh::jour_actuelle()[1] ?></th>
        <th><?= Dh::jour_actuelle()[0] ?></th>
    </tr>
    <tr>
        <th>Creation Front</th>
        <?php
        for ($i = count($this->datas->accountCreationsFront) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsFront[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Creation Facebook</th>
        <?php
        for ($i = count($this->datas->accountCreationsFacebook) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsFacebook[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Creation Twitter</th>
        <?php
        for ($i = count($this->datas->accountCreationsTwitter) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsTwitter[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Creation Linkedin</th>
        <?php
        for ($i = count($this->datas->accountCreationsLinkedin) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsLinkedin[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Creation MailChimp</th>
        <?php
        for ($i = count($this->datas->accountCreationsMailChimp) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsMailChimp[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Creation Linxo</th>
        <?php
        for ($i = count($this->datas->accountCreationsLinxo) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsLinxo[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th>Creation Api</th>
        <?php
        for ($i = count($this->datas->accountCreationsApi) - 1; $i >= 0; $i--)
        {
            ?>
            <td><?=$this->datas->accountCreationsApi[$i]?></td>

            <?php
        }
        ?>
    </tr>
    <tr>
        <th><?=TypeLogger::getFromId(1)[0]->getName()?></th>
        <?php
        for ($i = count($this->datas->accountCreations) - 1; $i >= 0; $i--)
        {
            ?>
            <th><?=$this->datas->accountCreations[$i]?></th>

            <?php
        }
        ?>
    </tr>

</table>
<footer style="height: 50px">

</footer>

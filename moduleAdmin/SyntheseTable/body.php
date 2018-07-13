<?php
$id = $this->id;
$tab = $this->tab;
?>
<table class="table syntheseTable">
    <thead style="background-color: #01528A;">
        <tr>
            <th>Etat transaction</th>
            <th>Acquisition</th>
            <th>MP/MS</th>
            <th>A/V</th>
            <th>SCPI</th>
            <th>Type propriété</th>
            <th>Montant transaction</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $len = count($tab);
            $i = 0;
            $m = 0;
            while ($len > $i){
        echo '<tr onclick="$(\'.modal_' . $tab[$i]['id'] . '\').modal(\'show\')" style="cursor:pointer;" onmouseover="this.bgColor=\'#5bc0de\';" onmouseout="this.bgColor=\'white\';">';
            if (empty($val = $tab[$i]['status_trans']))
                $val = "Inconnue";
            echo '<td>' . htmlspecialchars((ft_decrypt_crypt_information($val) == "-" ? "(Prospect)" : 'Client MeilleureSCPI.com')) . '</td>';
            if (empty($val = $tab[$i]['enr_date']))
                $val = "Inconnue";
            echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
            if (empty($val = $tab[$i]['marcher']))
                $val = "Inconnue";
            echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
            echo '<td>-</td>';// -->  A/V
            if (empty($val = $tab[$i]['Name']))
                $val = "Inconnue";
            echo '<td>' . htmlspecialchars(substr(ft_decrypt_crypt_information($val), 5)) . '</td>';
            if (empty($val = $tab[$i]['type_pro']))
                $val = "Inconnue";
            echo '<td>' . htmlspecialchars(ft_decrypt_crypt_information($val)) . '</td>';
            if (empty($tab[$i]['nbr_part']) || empty($tab[$i]['prix_part']))
                $val = "Inconnue";
            else
                $m += $tab[$i]['nbr_part'] * $tab[$i]['prix_part'];
            echo '<td>' . htmlspecialchars(number_format($tab[$i]['nbr_part'] * $tab[$i]['prix_part'], 2, ',', ' ')) . ' €</td>';
            ?>
            </tr>
            <?php
                $i++;
        }
        echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td style=\"text-align:left;\">Total : </td>";
                                echo "<td>" . number_format($m, 2, ",", " ") . " €</td>";
                            echo "</tr>";
           ?>

    </tbody>
</table>
<?php if (empty($len)) echo '<div class="alert alert-info" role="alert"><strong>VIDE : </strong>Aucune part de SCPI dans le portefeuille.</div>';
foreach ($tab as $i => $elm) {
	include("modal.php");
	include("modal_euro.php");
	include("modal_juge.php");
	include("modal_credit_bank.php");
	include("modal_dem.php");
	include("modal_bank.php");
}

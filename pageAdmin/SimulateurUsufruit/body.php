<?=$this->Nav?>
<br><br><br><br><br><br>
<div class="container">
    <div class="arial">
        <div id="app" class="row">

            <!-- comment pour les messages de succes sauf que la on en a beaucoup donc on crée un composant-->
            <table class="table table-bordered">
                <thead>
                <tr>

                    <th scope="col" style="width: 15%">Nom de la SCPI<br><br></th>
                    <th scope="col" style="width: 10%">Nombre de parts</th>
                    <th scope="col" style="width: 10%">Montant en Usufruit (€)</th>
                    <th scope="col">Durée du démembrement (nombre d'année entre 3 et 20 ans)</th>
                    <th scope="col">Prix par part (en pleine propriété) (€)</th>
                    <th scope="col">Clé de répartition nue propriété (%)</th>
                    <th scope="col">Clé de répartition usufruit (%)</th><!-- lui -->
                    <th scope="col">Montant global d'investissement (€)</th> <!-- lui -->
                    <th scope="col" style="width: 10%">Montant en nue-propriété (€)</th> <!-- lui -->
                    <th scope="col">IS </th>
                </tr>
                </thead>
                <tbody>
                    <td>
                        <select class="form-control aligner-droite" @change="recup_id(nom_Scpi.split(',', 2))" placeholder="modifiez-moi" v-model="nom_Scpi"v-for="item in triedata" >
                            <option value="0">Veuillez choisir une SCPI</option>
                            <option v-for="element in item">{{element[0]}},{{element[1]}}</option>
                        </select>
                    </td>
                    <td><input class="form-control aligner-droite" v-model.number="nombre_Parts" step="0.05" type="number" placeholder="Default input"></td>
                    <td>{{montant_Usufruit = cle_Repartition_usufruit * montant_Global_Investissement /100 | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td><!-- lui -->
                    <td><input class="form-control aligner-droite" v-model.number="duree_Demembrement" type="number" step="1" max="20" min="3" placeholder="Default input" ></td>
                    <td><input class="form-control aligner-droite" v-model.number="prix_Part" type="number" step="0.5" placeholder="Default input"></td>
                    <td>{{cle_Repartition_Nue_Propriete =100 - cle_Repartition_usufruit | remplacement}} %</td>
                    <td><input class="form-control aligner-droite" v-model.number="cle_Repartition_usufruit" type="number" step="0.05" placeholder="Default input">
                    </td>
                    <td>{{montant_Global_Investissement = prix_Part * nombre_Parts | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td><!-- lui -->
                    <td>{{montant_Nue_Propriete = montant_Global_Investissement * cle_Repartition_Nue_Propriete / 100 | deux_chiffres_apres_virgules| remplacement | formatMillier}}</td>
                    <td><input class="aligner-droite" v-model="is" type="number" step="0.1833" min="0.1500" max="0.3333" ></td>

                </tr>


                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Année</th>
                    <th scope="col">TDVM Prévisionnel</th>
                    <th scope="col none">Dividende Annuel</th>
                    <th scope="col" style="display: none">Soit un acompte trimestriel</th>
                    <th scope="col" style="display: none">Soit un dividende annuel par part de</th>
                    <th scope="col">Flux avant fiscalité</th>
                    <th scope="col">Amortissement usufruit</th>
                    <th scope="col">IS à payer</th>
                    <th scope="col">Flux après fiscalité</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="(duree_Demembrement >= 3) && (duree_Demembrement <= 20) && (prix_Part >= 0) && (cle_Repartition_usufruit >= 1) && (cle_Repartition_usufruit <= 49) && (nombre_Parts >= 0) && (tdvm_Previsionnel >= 0)">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td></td> <!-- faire un ++ -->
                        <td>{{montant_Usufruit_negatif = - montant_Usufruit | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="n in duree_Demembrement">

                        <th scope="row">{{n}}</th> <!-- faire un ++ -->
                        <td>{{tdvm_Previsionnel = hypothese_Medium | pourcentage | remplacement | formatMillier}}</td>
                        <td>{{dividende_Annuel = (tdvm_Previsionnel * montant_Global_Investissement / 100) | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td style="display: none">{{acompte_Trimestriel = dividende_Annuel/4/nombre_Parts | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td style="display: none">{{dividende_Annuel_Part = acompte_Trimestriel * 4 | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td>{{flux_Avant_Fiscalite = dividende_Annuel | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td>{{amortissement_Usufruit = montant_Usufruit_negatif / duree_Demembrement | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td>{{is_A_Payer = -(flux_Avant_Fiscalite + amortissement_Usufruit ) * is | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                        <td>{{flux_Apres_Fiscalite = flux_Avant_Fiscalite + is_A_Payer | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                    </tr>


                </template>
                <template v-else-if="(duree_Demembrement < 3) || (duree_Demembrement > 20)">

                    <tr>
                        <td colspan="9">
                            <h1 class="bleu-SCPI">Les données saisies ne sont pas bonnes. Rappel :</h1>
                            <ul>
                                <li><p class="h4">Durée de démembrement comprise entre 3 et 20 ans.</p></li>
                            </ul>

                        </td>
                    </tr>
                </template>
                <template v-else-if="(prix_Part < 0)">

                    <tr>
                        <td colspan="9">
                            <h1 class="bleu-SCPI">Les données saisies ne sont pas bonnes. Rappel :</h1>
                            <ul>
                                <li><p class="h4">Prix par part positif ou nul.</p></li>
                                <li><p class="h4">Clé de répartition entre 1% et 49%.</p></li>
                                <li><p class="h4">Nombre de parts positif.</p></li>
                            </ul>

                        </td>
                    </tr>
                </template>
                <template v-else-if="(cle_Repartition_usufruit < 1) || (cle_Repartition_usufruit > 49)">

                    <tr>
                        <td colspan="9">
                            <h1 class="bleu-SCPI">Les données saisies ne sont pas bonnes. Rappel :</h1>
                            <ul>
                                <li><p class="h4">Clé de répartition entre 1% et 49%.</p></li>
                            </ul>

                        </td>
                    </tr>
                </template>
                <template v-else-if="(nombre_Parts < 0)">

                    <tr>
                        <td colspan="9">
                            <h1 class="bleu-SCPI">Les données saisies ne sont pas bonnes. Rappel :</h1>
                            <ul>
                                <li><p class="h4">Nombre de parts positif.</p></li>
                            </ul>

                        </td>
                    </tr>
                </template>
                <template v-else-if="(tdvm_Previsionnel < 0)">

                    <tr>
                        <td colspan="9">
                            <h1 class="bleu-SCPI">Les données saisies ne sont pas bonnes. Rappel :</h1>
                            <ul>
                                <li><p class="h4">L'Hypothèse medium du TDVM Prévisionnel doit être positive.</p></li>
                            </ul>
                        </td>
                    </tr>
                </template>

                <tbody>

            </table>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Hypothèse basse</th>
                    <th scope="col">Hypothèse moyenne</th>
                    <th scope="col">Hypothèse haute</th> <!-- lui -->
                </tr>
                </thead>
                <tbody>

                <tr>
                    <th class="aligner-droite" scope="row">TDVM Prévisionnel sur la période (en %)</th> <!-- faire un ++ -->
                    <td><input class="form-control aligner-droite" v-model="hypothese_Basse" type="number" step="0.05" min="0" max="hypothese_Medium" placeholder="Default input"></td>
                    <td><input class="form-control aligner-droite" v-model="hypothese_Medium" type="number" step="0.05" min="hypothese_Basse" max="hypothese_Haute" placeholder="Default input"></td>
                    <td><input class="form-control aligner-droite" v-model="hypothese_Haute" type="number" step="0.05" min="hypothese_Medium" placeholder="Default input"></td>

                </tr>
                <tr style="display: none">
                    <th class="aligner-droite" scope="row" >Soit un acompte trimestriel par part de </th> <!-- faire un ++ -->
                    <td>{{acompte_Trimestriel_Basse=(acompte_Trimestriel/hypothese_Medium)*hypothese_Basse | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                    <td>{{acompte_Trimestriel | deux_chiffres_apres_virgules | remplacement}}</td>
                    <td>{{acompte_Trimestriel_Haute=(acompte_Trimestriel/hypothese_Medium)*hypothese_Haute | deux_chiffres_apres_virgules | remplacement | formatMillier }}</td>

                </tr>
                <tr style="display: none">
                    <th class="aligner-droite" scope="row">Soit un dividende annuel par part de </th> <!-- faire un ++ -->
                    <td>{{dividende_Annuel_Part_Basse=(dividende_Annuel_Part/hypothese_Medium)*hypothese_Basse | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                    <td>{{dividende_Annuel_Part | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                    <td>{{dividende_Annuel_Part_Haute=(dividende_Annuel_Part/hypothese_Medium)*hypothese_Haute | deux_chiffres_apres_virgules | remplacement | formatMillier }}</td>

                </tr>

                <tr>
                    <th class="aligner-droite" scope="row">TRI avant Fiscalité </th> <!-- faire un ++ -->
                    <td>{{irr_Avant_Basse = irr(montant_Usufruit_negatif,(flux_Avant_Fiscalite/hypothese_Medium)*hypothese_Basse,duree_Demembrement) | remplacement | formatMillier}} %</td>
                    <td>{{irr_Avant_Medium = irr(montant_Usufruit_negatif,flux_Avant_Fiscalite,duree_Demembrement) | remplacement | formatMillier}} %</td>
                    <td>{{irr_Avant_Haute = irr(montant_Usufruit_negatif,(flux_Avant_Fiscalite/hypothese_Medium)*hypothese_Haute,duree_Demembrement) | remplacement | formatMillier}} %</td>

                </tr>
                <tr>
                    <th class="aligner-droite" scope="row">TRI après Fiscalité IS</th> <!-- faire un ++ -->
                    <td>{{ irr_Apres_Basse = irr(montant_Usufruit_negatif,flux_Apres_Fiscalite_Bas(),duree_Demembrement) | remplacement | formatMillier}}%</td>
                    <td>{{ irr_Apres_Medium = irr(montant_Usufruit_negatif,flux_Apres_Fiscalite,duree_Demembrement) | remplacement | formatMillier}} %</td>
                    <td>{{ irr_Apres_Haute = irr(montant_Usufruit_negatif,flux_Apres_Fiscalite_Haut(),duree_Demembrement) | remplacement | formatMillier}} %</td>

                </tr>
                <tr>
                    <th class="aligner-droite" scope="row">Gain net potentiel (€)</th> <!-- faire un ++ -->
                    <td>{{gain_Net_Basse = montant_Usufruit_negatif + (flux_Apres_Fiscalite_Bas() * duree_Demembrement) | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                    <td>{{gain_Net_Medium = montant_Usufruit_negatif + (flux_Apres_Fiscalite * duree_Demembrement) | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>
                    <td>{{gain_net_Haute = montant_Usufruit_negatif + (flux_Apres_Fiscalite_Haut() * duree_Demembrement) | deux_chiffres_apres_virgules | remplacement | formatMillier}}</td>

                </tr>
                </tbody>

            </table>
            <div class="col-md-2 col-md-offset-10">
                <a class="btn btn-primary" v-bind:href="pageUrl" role="button">Générer PDF</a>
            </div>
        </div>
    </div>
</div>

</body>
<br>
<br>

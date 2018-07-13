</script>

/**
 * Page contenant le Vue.js du simulateur Usufruit
 */


<script>
/*!
* Creation de la vue pour le simulateur Usufruit
*/

let vm = new Vue({
    el: '#app',
    /*!
     *Declaration des variables
     */
    data: {
        ok :<?= json_encode($this->name_scpi) ?>,
        all :<?= json_encode($this->all) ?>,
        nbr_de_part: <?= json_encode($this->part) ?>,
        is: 0.3333,
        a:"",
        b:"",
        nom_Scpi: '',
        duree_Demembrement: 7,
        prix_Part: 800,
        montant_Global_Investissement: 0,
        montant_Nue_Propriete: 0,
        cle_Repartition_Nue_Propriete: 88,
        cle_Repartition_usufruit: 24,
        montant_Usufruit: 0,
        montant_Usufruit_negatif: '',
        nombre_Parts: 161,
        souscription_Divisible: 'non',
        annee: 0,
        tdvm_Previsionnel: 0,
        dividende_Annuel: 0,
        acompte_Trimestriel: 0,
        acompte_Trimestriel_Basse: 0,
        acompte_Trimestriel_Haute: 0,
        dividende_Annuel_Part: 0.33,
        dividende_Annuel_Part_Haute: 0.33,
        dividende_Annuel_Part_Basse: 0.33,
        flux_Avant_Fiscalite: 0,
        amortissement_Usufruit: 0,
        is_A_Payer: 0,
        flux_Apres_Fiscalite: 0,
        hypothese_Medium: 4.50,
        hypothese_Basse: 4.00,
        hypothese_Haute: 4.75,
        irr_Avant_Basse: 0,
        irr_Avant_Medium: 0,
        irr_Avant_Haute: 0,
        irr_Apres_Basse: 0,
        irr_Apres_Medium: 0,
        irr_Apres_Haute: 0,
        gain_Net_Basse: 0,
        gain_Net_Medium: 0,
        gain_net_Haute: 0
    },

    /*
    * liste des methodes
    */


    methods :{
        /*
        * méthode permettant de retourner l'irr calculé
        * \param negatif premiere valeur à entrer doit être négative
        * \param valeur contient un tableau avec les valeurs nécessaires au calcul
        * \param n représente le nombre d'année pour le calcul de l'irr
        * \return irree
        */
        irr : function (negatif,valeur,n) {
            var finance = new Finance();
            var contientvaleur = [negatif];
            for (var i = 0; i < n; i++) {
                contientvaleur.push(valeur)
            }

            var irree = finance.IRR.apply(this,contientvaleur);
            return irree;
        },

        recup_id: function (id) {
            var pl = this.prix_Part = id[1];


            return pl

        },


        /*!
        * methode de calcul de l'attribut is_A_Payer pour l'hypothese haute
        */
        is_A_Payer_Haut: function(){
            var rt= -((this.flux_Avant_Fiscalite/this.hypothese_Medium)*this.hypothese_Haute + this.amortissement_Usufruit ) * this.is;
            return rt;
        },

        /*!
        * methode de calcul de l'attribut is_A_Payer pour l'hypothese basse
        */
        is_A_Payer_Bas: function(){
            var rt= -((this.flux_Avant_Fiscalite/this.hypothese_Medium)*this.hypothese_Basse + this.amortissement_Usufruit ) * this.is;
            return rt;
        },

        /*!
        * methode de calcul de l'attribut flux_Apres_Fiscalite pour l'hypothese haute
        */
        flux_Apres_Fiscalite_Haut: function () {
            return ((this.flux_Avant_Fiscalite/this.hypothese_Medium)*this.hypothese_Haute + this.is_A_Payer_Haut());
        },

        /*!
        * methode de calcul de l'attribut flux_Apres_Fiscalite pour l'hypothese basse
        */
        flux_Apres_Fiscalite_Bas: function () {
            return ((this.flux_Avant_Fiscalite/this.hypothese_Medium)*this.hypothese_Basse + this.is_A_Payer_Bas());

        },

        /*
        * méthode qui permet de remplacer les points par des virgules dans l'affichage des données
        */
        refresh: function(field)
        {
            field.value = field.value.replace(".",",");
        },


    },

    /*
    * liste des filtres
    */
    filters: {
        /*
        * filtre permettant d'appliquer un pourcentage à 2 chiffres après la virgule et d'ajouter le %
        */
        pourcentage: function (valeur, decimales) {
            if (decimales === undefined) {
                decimales = 2;
            }
            return Math.round(valeur * Math.pow(10, decimales)) / Math.pow(10, decimales) + ' %';
        },

        /*
        * filtre permettant d'appliquer les 2 chiffres après la virgule
        */
        deux_chiffres_apres_virgules: function (valeur) {
            return valeur.toFixed(2)
        },

        /*
        * filtre pour remplacer les points par des virgules
        */
        remplacement: function (valeur) {
            var str = ""+valeur;

            var resultat = str.replace(".",",");
            return resultat;

        },



        /*
        * applique un format millier au nombre passé en parametre
        */
        formatMillier: function (nombre) {
            nombre += '';
            var sep = ' ';
            var reg = /(\d+)(\d{3})/;
            while (reg.test(nombre)) {
                nombre = nombre.replace(reg, '$1' + sep + '$2');
            }
            return nombre;
        }

    },
    computed: {


        tableauData: function () {
            var tab=[];
            tab.push(this.nom_Scpi);
            tab.push(this.duree_Demembrement);
            return tab;
        },

        /*
        * permet d'afficher la liste d'option
        * */
        triedata: function () {


            var trie = [
[]
            ];

            for (var iter = 0; iter < this.ok.length; iter++) {
                if (this.ok[iter].showOpportunite == 1) {
                   // trie[this.ok[iter].name.substr(5)]=this.ok[iter].value;
                    trie[0].push([this.ok[iter].name.substr(5),this.ok[iter].value]);

                }

            }


                return trie;

        },


    /*
    permet de transfere les informations via l'url a une autre page pour générer le pdf
    */

        pageUrl() {
            return 'admin_lkje5sjwjpzkhdl42mscpi.php?p=SimuPdf&nom_Scpi=' + this.nom_Scpi.split(',', 1)
                +'&duree_Demembrement='+this.duree_Demembrement
                +'&prix_Part='+this.prix_Part
                +'&montant_Global_Investissement='+this.montant_Global_Investissement
                +'&montant_Nue_Propriete='+this.montant_Nue_Propriete
                +'&cle_Repartition_Nue_Propriete='+this.cle_Repartition_Nue_Propriete
                +'&cle_Repartition_usufruit='+this.cle_Repartition_usufruit
                +'&montant_Usufruit='+this.montant_Usufruit
                +'&montant_Usufruit_negatif='+this.montant_Usufruit_negatif
                +'&nombre_Parts='+this.nombre_Parts
                +'&souscription_Divisible='+this.souscription_Divisible
                +'&annee='+this.annee
                +'&tdvm_Previsionnel='+this.tdvm_Previsionnel
                +'&dividende_Annuel='+this.dividende_Annuel
                +'&acompte_Trimestriel='+this.acompte_Trimestriel
                +'&dividende_Annuel_Part='+this.dividende_Annuel_Part
                +'&flux_Avant_Fiscalite='+this.flux_Avant_Fiscalite
                +'&amortissement_Usufruit='+this.amortissement_Usufruit
                +'&is_A_Payer='+this.is_A_Payer
                +'&flux_Apres_Fiscalite='+this.flux_Apres_Fiscalite
                +'&hypothese_Medium='+this.hypothese_Medium
                +'&hypothese_Basse='+this.hypothese_Basse
                +'&hypothese_Haute='+this.hypothese_Haute
                +'&acompte_Trimestriel_Basse='+this.acompte_Trimestriel_Basse
                +'&acompte_Trimestriel_Haute='+this.acompte_Trimestriel_Haute
                +'&dividende_Annuel_Part_Haute='+this.dividende_Annuel_Part_Haute
                +'&dividende_Annuel_Part_Basse='+this.dividende_Annuel_Part_Basse
                +'&irr_Avant_Basse='+this.irr_Avant_Basse
                +'&irr_Avant_Medium='+this.irr_Avant_Medium
                +'&irr_Avant_Haute='+this.irr_Avant_Haute
                +'&irr_Apres_Basse='+this.irr_Apres_Basse
                +'&irr_Apres_Medium='+this.irr_Apres_Medium
                +'&irr_Apres_Haute='+this.irr_Apres_Haute
                +'&gain_Net_Basse='+this.gain_Net_Basse
                +'&gain_Net_Medium='+this.gain_Net_Medium
                +'&gain_net_Haute='+this.gain_net_Haute
                +'&is='+this.is
                ;
        }


    }

    /* components: { message } */
});


</script>
#!/bin/bash

# Ce script permet de générer les fichiers 
echo '$$\
$$ |
$$ | $$$$$$\ $$\    $$\  $$$$$$\
$$ |$$  __$$\\$$\  $$  |$$  __$$\
$$ |$$ /  $$ |\$$\$$  / $$$$$$$$ |
$$ |$$ |  $$ | \$$$  /  $$   ____|
$$ |\$$$$$$  |  \$  /   \$$$$$$$\
\__| \______/    \_/     \_______|'

read -p 'Entrez le nom de votre fichier : ' nom
read -p 'Dans quel repertoire voulez-vous crer le fichier(pageAdmin(pa) ou page(p)) : ' page



# permet de savoir sur quel machine va tourner le script
unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    CYGWIN*)    machine=Cygwin;;
    MINGW*)     machine=MinGw;;
    *)          machine="UNKNOWN:${unameOut}"
esac

# Permet de savoir ou la personne veut crée sont fichier coter pageadmin ou page
if [ $page = "pageAdmin" ] || [ $page = "pa" ]
then

if [ -n $nom ]
then 	
	mkdir pageAdmin/$nom
else 
	echo "Vous devez préciser le nom du fichier"
fi

cheminadmin=pageAdmin
routingadmin=admin_lkje5sjwjpzkhdl42mscpi.php

# Permet de crée les fichiers avec le contenu
touch $cheminadmin/$nom/body.php
touch $cheminadmin/$nom/controller.php

echo "<?php
require_once(\"class/core/PageAdmin.php\");
class $nom extends PageAdmin
{
}" >$cheminadmin/$nom/controller.php

touch $cheminadmin/$nom/header.php
touch $cheminadmin/$nom/model.php
touch $cheminadmin/$nom/scriptBody.php
touch $cheminadmin/$nom/scriptHead.php
touch $cheminadmin/$nom/style.css


if [ $machine = "Mac" ]
then
    sed -i "" "s|//ROUTE_AUTOMATIQUE|\else if (\$p == \"$nom\"\) \{\
     \require_once\(\"pageAdmin\/$nom\/controller.php\");\
	 \$page =\ new $nom()\;}  //ROUTE_AUTOMATIQUE|" $routingadmin
    echo "Ajouté dans le systeme de routing (admin_lkje5sjwjpzkhdl42mscpi) :D"

elif [ $machine = "Linux" ]
then
    sed -i "s/ROUTE_AUTOMATIQUE/Remplacement/g" $routingadmin
    echo "Ajouté dans le systeme de routing (admin_lkje5sjwjpzkhdl42mscpi) :D"

else
    sed -i "s/ROUTE_AUTOMATIQUE/Remplacement/g" $routingadmin
    echo "Verifier que la route a bien été ajouté"
fi


elif [ $page = "page" ] || [ $page = "p" ]

then 

if [ -n $nom ]
then
        mkdir page/$nom
else
        echo "Vous devez préciser le nom du fichier"
fi

cheminpage=page
routing=index.php

touch $cheminpage/$nom/body.php
touch $cheminpage/$nom/controller.php

echo "<?php
require_once(\"class/core/Page.php\");
class $nom extends Page
{
}" >$cheminpage/$nom/controller.php

touch $cheminpage/$nom/header.php
touch $cheminpage/$nom/model.php

touch $cheminpage/$nom/scriptBody.php

touch $cheminpage/$nom/scriptHead.php
touch $cheminpage/$nom/style.css

if [ $machine = "Mac" ]
then
   # sed -i "" "s|//ROUTE_AUTOMATIQUE|\else if (\$p == \"$nom\"\) \{ \n
   #  \require_once\(\"page\/$nom\/controller.php\");\
 # \$page =\ new $nom()\;}  //ROUTE_AUTOMATIQUE|" $routing

 sed -i "" "s/ROUTE/\x0A/" $routing

elif [ $machine = "Linux" ]
then
    sed -i "s/ROUTE_AUTOMATIQUE/Remplacement/g" $routing

else
    sed -i "s/ROUTE_AUTOMATIQUE/Remplacement/g" $routing
    echo "Verifier que la route a bien été ajouté"
fi

fi

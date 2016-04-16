Clictopay SMT
=====================

**Clictopay SMT** est un module **Prestashop** de paiement en ligne pour **SPS Monétique Tunisie**.


**Caractéristiques et fonctionnalités du module Clictopay SMT** :

- Rapide, performant et totalement sécurisé

- Bilingue ``FR`` et ``EN``

- Compatible avec la version **v1.5.0**  et  **ultérieur** de **Prestashop** (v1.5 / v1.6 / ...)

- Accepte les paiements de différentes devises (TND, €, $).

- Accepte les paiements de différents cartes (locale et internationale).

- Enregistré sous la licence ``BSD``. Développé par **Ala Eddine Khefifi**



Installation
------------

1. Téléchargez le .zip du module depuis Github

2. ![Alt text](logos/download.jpg?raw=true "Téléchargez le .zip")

3. Décompressez le module ``Clictopay-master.zip``

4. Renommez le dossier ``Clictopay-master``  à  ``clictopay`` (**Attention tout est en minuscule!**).

5. Compressez (.zip) le dossier renommé ``clictopay`` (Résultat: clictopay.zip).

6. Chargez le module ``clictopay.zip`` depuis le back office de Prestashop, menu ``Modules``.

7. Installez le module ``Clictopay SMT`` depuis le back office de Prestashop, menu ``Modules``.



Configuration
-------------

1. Cliquez sur le bouton ``Configurer`` du module ``Clictopay SMT``.

2. Remplissez le champ ``URL`` avec le lien de page de paiement de SPS Monétique Tunisie :  (i.e: https://www.smt-sps.com.tn/clicktopay).

3. Remplissez le champ ``Affilie`` avec le code d'adhésion à la plateforme SPS.

4. Mettez à jour la configuration.


### Liens de Configuration:

Les liens de Configuration qu'il faut fournir à SPS Monétique Tunisie.

Changez ``www.domain.com`` par votre nom de domaine.


``` html
// Controle et Notification:

http://www.domain.com/index.php?fc=module&module=clictopay&controller=smtcontrol

// Succes:

http://www.domain.com/index.php?fc=module&module=clictopay&controller=succes

// Echec:

http://www.domain.com/index.php?fc=module&module=clictopay&controller=echec

```


Licence
-------

Ce Module est sous la licence ``BSD``.

Développé par **Ala Eddine Khefifi**

Voir [LICENCE](https://github.com/NAYZO/Clictopay/blob/master/LICENSE)

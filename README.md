Clictopay SMT
=====================

**Clictopay SMT** est un module **Prestashop** de paiement en ligne pour **SPS Monétique Tunisie**.

- Le Module est totalement securisé

- Le Module est bilingue ``FR`` et ``EN``

- Le Module est compatible avec la version **v1.5.0** ou **ultèrieur** de **Prestashop**

- Le Module est sous la licence ``BSD``. Développé par **Ala Eddine Khefifi**



Installation
------------

1. Téléchargez le .zip du module depuis Github.

![Alt text](logos/download.jpg?raw=true "Téléchargez le .zip")

2. Décompressez le module et renommez le dossier ``Clictopay-master``  à  ``clictopay``.

3. Placez le dossier ``clictopay`` dans le dossier ``modules`` de votre projet Prestashop.

 Ou compressez (.zip) le dossier renommé et chargez le module depuis le back office de Prestashop.

4. Installez le Module depuis le back office de Prestashop, menu ``Modules``, section ``Paiement``.



Configuration
-------------

Afin de Configurer le Module:

1. Cliquez sur ``Configurer``.

2. Remplissez le champ ``URL`` avec le lien de page de paiement de SPS Monétique Tunisie.

3. Remplissez le champ ``Affilie`` avec le Code d'adhésion à la plateforme SPS.

4. Mettre à jour la configuration.


### Liens de Configuration:

Les liens de Configuration qu'il faut fournir à SPS Monétique Tunisie.

Changez ``www.domain.com`` par votre nom de domain.


``` html
//CONTROLE:

http://www.domain.com/index.php?fc=module&module=clictopay&controller=smtcontrol

// SUCCES:

http://www.domain.com/index.php?fc=module&module=clictopay&controller=succes

// ECHEC:

http://www.domain.com/index.php?fc=module&module=clictopay&controller=echec

```



Licence
-------

Ce Module est sous la licence ``BSD``.

Développé par **Ala Eddine Khefifi**

Voir [LICENCE](https://github.com/NAYZO/Clictopay/blob/master/LICENSE)
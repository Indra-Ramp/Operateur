# Operateur - V1

## ETU004045:
- Creation de notre template
- Cote operateur :
  - Creation des modeles :
    - TypeOperationModel.php
    - FraisModel.php
    - PrefixeModel.php
    - CompteModel.php
    - OperationModel.php
  - Creation des controllers :
    - PrefixeController.php
    - FraisController.php
## ETU004086:
- Creation de repository (5 minutes)
- Creation base de donnees
  - type_operation (id, label)
  - frais (id, id_type, montant1, montant2, frais)
  - prefixe (id, label)
  - compte (id, tel, nom, prenom, date_naissance, genre, adresse)
  - operation (id, id_type, id_compte1, id_compte2, date_track, montant)
- Configuration du fichier App/Config/Database.php
- Cote client :
  - Creation des controllers :
    - AuthController.php
    - CompteController.php
    - OperationController.php

- login client:
    
- Faire les depots, retraits, transfert (automatique)
- voir solde (reste de l'argent dans le compte)
- Affichage de l'historique du compte
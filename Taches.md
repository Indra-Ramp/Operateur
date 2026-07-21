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
  - Configuration prefixe :
    - Creation fonction PrefixeController::displayForm
    - Creation fonction PrefixeController::addPrefix
    - Creation des Routes :
      - GET:/operateur/prefix
      - POST:/operateur/prefix/new
  - Configuration des frais :
    - Insertion des types d'operation en base
    - Creation des fonctions :
      - FraisController::listOperation
      - FraisController::list
      - FraisController::update
    - Creation des routes :
      - GET:/operateur/choose-operation
      - GET:/operateur/list-fees/{id}
      - POST:/operateur/fee/update 
      - POST:/operateur/fee/add
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
- Creation des fonction retrait, depot, transfert
- Creation du fonction getSolde()
- Affichage de l'historique dans dashboard 

# Operateur - V2
## ETU004086
- Par retrait -> ajouter frais (bool) 
- Appliquer la condition de frais dans transfert
- Creation de ajax pour l'affichage multiple
- Creation de fonction transfert multiple 
- Correction de getSolde(domme montant + frais + commission)
- Creation de controller

## ETU004045
- Creation table operateurs (id, label)
- modification table prefixe: ajout de colonne id_operateur (NULL raha ohatra ka le operateur-nay ihany)
- Creation table commission (id, id_operateur, perc)
- ajout de frais, commission, id_operateur dans la table operation
- Creation de fonction stat dans FraisController.php

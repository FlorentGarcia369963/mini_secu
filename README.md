# Bienvenue sur Social_Secu, 
## mini projet réalisé en vue d'accompagner ma candidature pour un poste en CDI.

Il s'agit de développer une application web simple permettant le transfert de fichiers en vue du traitement d'une demande.
Trois rôles importants:
  - Utilisateur,
  - Conseiller,
  - Agent de validation;

L'utilisateur soumet des factures, le conseiller peut les lire, accepter la soumission de la demande qui est alors transmise à l'agent de validation qui va décider du remboursement ou non.

Au programme, inscription et connexion, de la gestion d'affichage en fonction des rôles, de l'upload, des données sensibles...

**Réalisé avec symfony 6.4**, moteur de template **Twig**, un peu de **javascript**, et **bootstrap** pour le front-end.

Commandes pour mettre le projet en route avec les utilisateurs par défaut:
- "make create_db"
- "docker compose up -d --build"
- "make fixtures"

## Utilisateurs par défaut: 
- Le user: user@gmail.com,
- Le conseiller: advisor@gmail.com
- L'agent de validation: validator@gmail.com

Mot de passe dans tous les cas : password123
  

  

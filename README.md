Projet agence de voyage

Julien Denize - Nicolas Diebold

Agence appelée SymfTravel

Il y a trois rôles d'utilisateur:

- SuperAdmin qui peut accéder au backoffice et à la liste des collaborateurs et en supprimer. Sur le front il peut voir tous les circuits même s'ils n'ont pas de programmation valide (plus tard que la date actuelle)
Login: Superadmin
Mdp: superadmin

- Admin qui peut accéder au backoffice mais pas aux collaborateurs. Sur le front il peut voir tous les circuits même s'ils n'ont pas de programmation valide (plus tard que la date actuelle)
Login: admin
Mdp: admin

- User qui a les mêmes droits que les personnes non authentifiées et donc qui ne peut pas accéder au backoffice et n'a pas de vision sur les circuits n'ayant pas de programmation valide.
Login: lambda
mdp: lambda


Les fixtures définissent un utilisateur pour chaque rôle, ainsi que des circuits ayant tous des programmations. Le circuit Ile de france n'en a pas de valide et n'est donc pas affiché pour les visiteurs.

La route register est bloquée car seul le superadmin doit pouvoir ajouter des comptes. On a décidé que cette logique se ferait en-dehors de l'application web ( donc par ligne de commande ou SQL ).
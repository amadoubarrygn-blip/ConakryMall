---
description: Afficher l'état actuel du projet ConakryMall (Git + documentation)
---
// turbo-all

# Status — ConakryMall

Ce workflow affiche un résumé complet de l'état du projet.

## Étapes

1. État Git — fichiers modifiés
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git status --short
```

2. Derniers commits
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git log --oneline -5
```

3. Lire l'état du projet
```
cat /home/conakrymall/public_html/docs/PROJECT_STATE.md
```

4. Résumer à l'utilisateur :
   - Nombre de fichiers modifiés / non commités
   - Dernier commit (date + message)
   - État des fonctionnalités (depuis PROJECT_STATE.md)
   - Si un push GitHub est en attente

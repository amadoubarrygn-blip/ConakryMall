---
description: Démarrer une nouvelle session Antigravity en lisant l'état du projet ConakryMall
---
// turbo-all

# Session Start — ConakryMall

Ce workflow doit être exécuté au début de chaque session pour reprendre le contexte du projet.

## Étapes

1. Lire l'état actuel du projet
```
cat /home/conakrymall/public_html/docs/PROJECT_STATE.md
```

2. Lire les dernières modifications
```
cat /home/conakrymall/public_html/CHANGELOG.md
```

3. Vérifier l'état Git (fichiers modifiés non commités)
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git status
```

4. Voir les derniers commits
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git log --oneline -10
```

5. Résumer à l'utilisateur :
   - L'état actuel du projet (fonctionnalités actives)
   - Les dernières modifications effectuées
   - Les fichiers éventuellement modifiés mais non commités
   - Les prochaines étapes suggérées

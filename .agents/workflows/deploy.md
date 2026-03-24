---
description: Commiter et publier les modifications du projet ConakryMall
---

# Deploy — ConakryMall

Ce workflow commit les modifications locales et les pousse vers GitHub.

## Étapes

1. Vérifier les modifications en attente
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git status
```

2. Examiner les changements en détail
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git diff --stat
```

3. Demander à l'utilisateur un message de commit descriptif, ou en suggérer un basé sur les modifications

4. Ajouter les fichiers modifiés
// turbo
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git add -A
```

5. Commiter avec le message
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git commit -m "<message>"
```

6. Pousser vers GitHub (seulement si un remote est configuré)
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git push origin main
```

7. Mettre à jour `CHANGELOG.md` avec une entrée décrivant les modifications

8. Mettre à jour `docs/PROJECT_STATE.md` si nécessaire (nouvelles fonctionnalités, changements d'architecture, etc.)

9. Si le CHANGELOG ou PROJECT_STATE a été mis à jour, faire un commit supplémentaire :
// turbo
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git add -A && GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git commit -m "docs: mise à jour CHANGELOG et PROJECT_STATE"
```

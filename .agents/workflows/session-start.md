---
description: Démarrer une session Antigravity — lire projet + knowledge base + état Git
---
// turbo-all

# Session Start — ConakryMall

Ce workflow DOIT être exécuté au début de chaque nouvelle session pour reprendre le contexte complet du projet.

## Étapes

1. Lire l'état actuel du projet
```
cat /home/conakrymall/public_html/docs/PROJECT_STATE.md
```

2. Lire la roadmap
```
cat /home/conakrymall/public_html/docs/knowledge/roadmap.md
```

3. Lire les décisions techniques
```
cat /home/conakrymall/public_html/docs/knowledge/decisions.md
```

4. Lire les leçons apprises (CE QUI A MARCHÉ / ÉCHOUÉ)
```
cat /home/conakrymall/public_html/docs/knowledge/lessons-learned.md
```

5. Lire les dernières modifications
```
cat /home/conakrymall/public_html/CHANGELOG.md
```

6. Vérifier l'état Git
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git status
```

7. Voir les 10 derniers commits
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git log --oneline -10
```

8. Résumer à l'utilisateur :
   - L'état actuel du projet et la phase en cours (depuis roadmap)
   - Les dernières modifications
   - Les leçons importantes à retenir
   - Les fichiers modifiés non commités
   - Les prochaines étapes recommandées

## Règles importantes (issues des leçons apprises)

- ⚠️ **NE JAMAIS créer de contenu sans cahier des charges** (LEÇ-001)
- ⚠️ **Utiliser `GIT_DIR` + `GIT_WORK_TREE` pour toutes les commandes Git** (LEÇ-002)
- ⚠️ **Exécuter `chown -R conakrymall:conakrymall /home/conakrymall/public_html/` après modifications** (LEÇ-003)

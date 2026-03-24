---
description: Documenter les apprentissages après une session de travail
---

# Improve — ConakryMall

Ce workflow doit être exécuté **à la fin de chaque session de travail** pour capitaliser sur ce qui a été fait.

## Étapes

1. Demander à l'utilisateur ou déterminer :
   - Ce qui a été fait pendant cette session
   - Ce qui a bien fonctionné
   - Ce qui a posé problème
   - Les décisions prises

2. Mettre à jour `docs/knowledge/lessons-learned.md` avec les nouvelles leçons :
```
Ouvrir /home/conakrymall/public_html/docs/knowledge/lessons-learned.md
Ajouter les nouvelles entrées au format LEÇ-XXX
```

3. Mettre à jour `docs/knowledge/decisions.md` si de nouvelles décisions techniques ont été prises :
```
Ouvrir /home/conakrymall/public_html/docs/knowledge/decisions.md
Ajouter les nouvelles entrées au format DEC-XXX
```

4. Mettre à jour `docs/knowledge/roadmap.md` (cocher les tâches complétées, ajouter des nouvelles) :
```
Ouvrir /home/conakrymall/public_html/docs/knowledge/roadmap.md
```

5. Mettre à jour `docs/PROJECT_STATE.md` :
```
Ouvrir /home/conakrymall/public_html/docs/PROJECT_STATE.md
```

6. Mettre à jour `CHANGELOG.md` avec les modifications de cette session

7. Commiter toutes les mises à jour de documentation
// turbo
```
GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git add -A && GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git commit -m "docs: mise à jour knowledge base — session du [DATE]"
```

8. Fixer les permissions
// turbo
```
chown -R conakrymall:conakrymall /home/conakrymall/public_html/
```

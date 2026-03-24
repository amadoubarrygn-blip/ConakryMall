# Leçons Apprises

> Ce fichier est lu par l'IA à chaque session via `/session-start`.
> Il documente ce qui a **marché**, ce qui a **échoué**, et les **pièges à éviter**.

## Format

Pour chaque leçon :
- **Date** — Quand la leçon a été apprise
- **Action** — Ce qui a été tenté
- **Résultat** — 🟢 Succès | 🔴 Échec | 🟡 Partiel
- **Détail** — Ce qui s'est passé
- **Conclusion** — Ce qu'il faut retenir pour la suite

---

## LEÇ-001 — Ne pas créer de contenu avant le cahier des charges (2026-03-24)

- **Action** : Création d'un site web complet (index.html, CSS, JS) avant d'avoir les spécifications
- **Résultat** : 🔴 Échec
- **Détail** : Le site a été construit avec des hypothèses (centre commercial, services inventés) qui ne correspondaient pas aux besoins réels de l'utilisateur
- **Conclusion** : **Toujours attendre le cahier des charges complet avant de créer du contenu**. Préparer l'infrastructure d'abord, le contenu ensuite.

## LEÇ-002 — Git sur cPanel nécessite GIT_DIR (2026-03-24)

- **Action** : Utilisation de `git -C /path` et `cd /path && git config`
- **Résultat** : 🔴 Échec
- **Détail** : La version Git de cPanel ne supporte pas bien `git -C` et les commandes chaînées avec `cd`. Il faut utiliser les variables d'environnement.
- **Conclusion** : **Toujours utiliser `GIT_DIR=/home/conakrymall/public_html/.git GIT_WORK_TREE=/home/conakrymall/public_html git <commande>`** pour les opérations Git sur cet hébergement.

## LEÇ-003 — Fichiers créés par root sur cPanel (2026-03-24)

- **Action** : Création de fichiers dans `/home/conakrymall/public_html/`
- **Résultat** : 🟡 Partiel
- **Détail** : Les fichiers créés sont owned par root. Il faut faire `chown -R conakrymall:conakrymall` après création
- **Conclusion** : **Toujours exécuter `chown -R conakrymall:conakrymall /home/conakrymall/public_html/` après avoir créé ou modifié des fichiers**

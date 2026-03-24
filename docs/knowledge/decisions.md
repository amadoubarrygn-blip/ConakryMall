# Journal des Décisions Techniques

> Ce fichier est lu par l'IA à chaque session via `/session-start`.
> Il permet de comprendre **pourquoi** les choix ont été faits et d'éviter de les remettre en question sans raison.

## Format

Pour chaque décision, documenter :
- **Date** — Quand la décision a été prise
- **Contexte** — Quel problème on cherchait à résoudre
- **Options** — Les alternatives considérées
- **Choix** — Ce qui a été retenu
- **Raison** — Pourquoi ce choix
- **Statut** — ✅ Actif | ⚠️ À réévaluer | ❌ Abandonné

---

## DEC-001 — Hébergement et infrastructure (2026-03-24)

- **Contexte** : Choix de l'environnement d'hébergement
- **Options** : VPS / Cloud (AWS, Vercel) vs cPanel mutualisé
- **Choix** : cPanel mutualisé avec Apache+Nginx
- **Raison** : Infrastructure existante, support PHP 8.2, SSL inclus, simplicité de gestion
- **Statut** : ✅ Actif

## DEC-002 — Versioning et continuité (2026-03-24)

- **Contexte** : Comment assurer la continuité entre sessions IA et éviter de recommencer à zéro
- **Options** : (A) Tout gérer en mémoire IA / (B) Git local / (C) Git + GitHub + Knowledge Base
- **Choix** : Option C — Git local + GitHub + base de connaissances structurée
- **Raison** : GitHub = mémoire permanente, Knowledge base = contexte accessible par l'IA, Git = traçabilité complète
- **Statut** : ✅ Actif

## DEC-003 — Séparation sécurité (2026-03-24)

- **Contexte** : L'IA doit pouvoir accéder aux infos du projet sans compromettre la sécurité
- **Options** : (A) Tout sur GitHub / (B) Séparation via .gitignore
- **Choix** : Option B — Les fichiers sensibles (`.security-notes`, `.env`, credentials) restent locaux et sont exclus de Git
- **Raison** : L'IA accède à tout pour améliorer le projet, mais les infos sensibles ne quittent jamais le serveur
- **Statut** : ✅ Actif

## DEC-004 — Approche de développement (2026-03-24)

- **Contexte** : Comment aborder la construction du site
- **Options** : (A) L'IA construit tout seule / (B) L'utilisateur fournit un cahier des charges et l'IA implémente
- **Choix** : Option B — L'utilisateur dirige, l'IA exécute
- **Raison** : Le contenu et la vision doivent venir de l'utilisateur. L'IA apporte les compétences techniques et les bonnes pratiques
- **Statut** : ✅ Actif

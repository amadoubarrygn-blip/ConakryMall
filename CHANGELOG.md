# Changelog

Toutes les modifications notables du projet ConakryMall sont documentées ici.
Format basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.1.0/).

## [0.1.0] - 2026-03-24

### Ajouté
- Structure de l'espace de travail
- Configuration Git locale (branche `main`)
- `.gitignore` avec exclusions sécurité + cPanel
- `.htaccess` sécurisé (headers, HTTPS, CSP, caching, compression)
- Base de connaissances (`docs/knowledge/`)
  - `decisions.md` — 4 décisions techniques initiales
  - `lessons-learned.md` — 3 leçons apprises
  - `roadmap.md` — phases du projet
- Documentation (`PROJECT_STATE.md`, `SECURITY.md`)
- 4 workflows Antigravity (`/session-start`, `/deploy`, `/status`, `/improve`)
- Page placeholder "en construction"

### Corrigé
- Suppression du site web prématuré (créé avant réception du cahier des charges)

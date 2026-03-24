# ConakryMall — Site Web

> Site web professionnel hébergé sur cPanel. Géré avec Git et workflows Antigravity pour l'amélioration continue.

## 🏗️ Stack technique

- **HTML5 / CSS3 / JavaScript** — Site statique performant
- **PHP 8.2** — Disponible via cPanel (EasyApache)
- **Apache + Nginx** — Serveur web cPanel
- **SSL/TLS** — HTTPS activé
- **Git** — Versioning local + GitHub

## 📁 Structure du projet

```
public_html/
├── assets/
│   ├── css/style.css       # Design system
│   ├── js/main.js          # Interactions
│   └── images/             # Médias
├── docs/
│   ├── PROJECT_STATE.md    # État du projet (lu par Antigravity)
│   └── SECURITY.md         # Mesures de sécurité
├── .agents/workflows/      # Workflows Antigravity
├── index.html              # Page d'accueil
├── CHANGELOG.md            # Journal des modifications
└── .htaccess               # Config Apache + sécurité
```

## 🤖 Workflows Antigravity

| Commande | Description |
|----------|-------------|
| `/session-start` | Résume l'état actuel du projet pour la nouvelle session |
| `/deploy` | Commit + push des modifications vers GitHub |
| `/status` | Affiche l'état Git et du projet |

## 📋 Processus de travail

1. Chaque session Antigravity commence par `/session-start`
2. Les modifications sont documentées dans `CHANGELOG.md`
3. L'état du projet est mis à jour dans `docs/PROJECT_STATE.md`
4. Les changements sont commités via `/deploy`

## 📅 Créé le

24 Mars 2026

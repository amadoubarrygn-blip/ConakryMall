# ConakryMall — Espace de travail

> Espace de travail préparé pour le développement d'un site web professionnel. Géré avec Git et workflows Antigravity pour l'amélioration continue.

## 🏗️ Stack technique

- **Hébergement** : cPanel mutualisé (Apache + Nginx)
- **PHP** : 8.2 disponible
- **SSL/TLS** : HTTPS activé
- **Versioning** : Git local (GitHub à connecter)

## 📁 Structure

```
public_html/
├── .agents/workflows/      # Workflows Antigravity (IA)
├── docs/
│   ├── knowledge/          # Base de connaissances (décisions, leçons, roadmap)
│   ├── PROJECT_STATE.md    # État du projet (point d'entrée IA)
│   └── SECURITY.md         # Documentation sécurité
├── index.html              # Placeholder (en attente du site)
├── .htaccess               # Sécurité Apache
├── CHANGELOG.md            # Journal des modifications
└── README.md               # Ce fichier
```

## 🤖 Workflows Antigravity

| Commande | Quand | Description |
|----------|-------|-------------|
| `/session-start` | Début de session | Charge tout le contexte projet + knowledge base |
| `/deploy` | Après modifications | Commit + push GitHub |
| `/status` | À tout moment | État Git + projet |
| `/improve` | Fin de session | Documente les apprentissages |

## 📚 Base de connaissances (`docs/knowledge/`)

- **decisions.md** — Pourquoi chaque choix technique a été fait
- **lessons-learned.md** — Ce qui a marché/échoué (erreurs à ne pas répéter)
- **roadmap.md** — Vision et prochaines étapes

## 📅 Créé le 24 Mars 2026

# ConakryMall — Sécurité

> **Dernière mise à jour** : 24 Mars 2026

## Headers de sécurité (`.htaccess`)

| Header | Valeur | Protection |
|---|---|---|
| `X-Content-Type-Options` | `nosniff` | Empêche le MIME sniffing |
| `X-Frame-Options` | `SAMEORIGIN` | Protège contre le clickjacking |
| `X-XSS-Protection` | `1; mode=block` | Protection XSS navigateur |
| `Referrer-Policy` | `strict-origin-when-cross-origin` | Contrôle les infos referrer |
| `Permissions-Policy` | `camera=(), microphone=(), geolocation=()` | Restreint les APIs sensibles |
| `Content-Security-Policy` | Voir `.htaccess` | Contrôle les sources de contenu |

## Autres mesures

- ✅ HTTPS forcé via redirect `.htaccess`
- ✅ Listing de répertoires désactivé (`Options -Indexes`)
- ✅ Protection des fichiers sensibles (`.git`, `.env`, `.htpasswd`)
- ✅ ETag headers désactivés (empêche la fuite d'infos inode)

## Recommandations futures

- [ ] Configurer un WAF (Web Application Firewall) si disponible via cPanel
- [ ] Activer HSTS (HTTP Strict Transport Security) après validation HTTPS stable
- [ ] Mettre en place un CSP plus restrictif selon le contenu final

# ApiForge

Générateur automatique d'API REST à partir d'un schéma de base de données relationnelle.

## Prérequis

- Node.js v18+
- Une base de données MySQL, SQLite ou PostgreSQL

## Installation
```bash
npm install -g apiforge-gen
```

Copiez le fichier de configuration :
```bash
cp .env.example .env
```

Puis remplissez les valeurs dans `.env` selon votre base de données.

## Configuration
```env
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=
DB_DATABASE=nom_de_votre_base
OUTPUT_PATH=./output
```

## Utilisation

### Analyser le schéma de la base de données
```bash
node src/cli/index.js analyze
```

### Générer tous les fichiers Laravel
```bash
node src/cli/index.js generate
```

### Générer uniquement une partie
```bash
node src/cli/index.js generate --only migrations
node src/cli/index.js generate --only models
node src/cli/index.js generate --only controllers
node src/cli/index.js generate --only routes
```

### Surcharger les paramètres du `.env`
```bash
node src/cli/index.js generate --database autre_base
node src/cli/index.js generate --driver sqlite --database ./ma_base.db
node src/cli/index.js generate --output ./mon_projet_laravel
```

## Fichiers générés

Pour chaque table détectée, ApiForge génère :

| Fichier | Emplacement |
|---|---|
| Migration | `database/migrations/` |
| Modèle Eloquent | `app/Models/` |
| Contrôleur CRUD | `app/Http/Controllers/` |
| Routes REST | `routes/api.php` |

## Bases de données supportées

| Driver | Paramètre |
|---|---|
| MySQL / MariaDB | `--driver mysql` |
| SQLite | `--driver sqlite` |
| PostgreSQL | `--driver postgres` |

## Exemple

Avec une base de données contenant les tables `users`, `posts` et `comments`, ApiForge génère automatiquement :
```
output/
├── database/migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_posts_table.php
│   └── ..._create_comments_table.php
├── app/
│   ├── Models/
│   │   ├── Users.php
│   │   ├── Posts.php
│   │   └── Comments.php
│   └── Http/Controllers/
│       ├── UsersController.php
│       ├── PostsController.php
│       └── CommentsController.php
└── routes/
    └── api.php
```

## Architecture du projet
```
apiforge/
├── src/
│   ├── cli/          # Point d'entrée CLI
│   ├── drivers/      # Connexion aux bases de données
│   ├── analyzers/    # Analyse du schéma
│   ├── generators/   # Génération du code Laravel
│   └── writers/      # Écriture des fichiers
├── templates/        # Templates de génération
├── .env              # Configuration locale
├── .env.example      # Template de configuration
└── package.json
```

## Licence

ISC

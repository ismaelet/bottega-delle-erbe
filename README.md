# Bottega delle Erbe

A custom PHP website developed for **La Bottega delle Erbe**, a herbalist shop based in Predazzo, Trentino, Italy.

The project provides a digital presence for the business and includes a custom storefront, product presentation, and supporting administrative functionality.

## About the Project

La Bottega delle Erbe is a herbalist shop offering products and specialist advice relating to natural wellness and personal care.

The website was developed using a custom PHP architecture, without relying on a full-stack framework, to support the business's online presence and commercial functionality.

This repository is preserved as part of my web development portfolio and documents an earlier approach to building PHP applications.

## Technologies

- **PHP** — Server-side application logic
- **MySQL** — Relational database
- **HTML5** — Website structure
- **CSS3** — Styling and layout
- **JavaScript** — Client-side functionality
- **PHPMailer** — Email functionality
- **Composer** — PHP dependency management
- **PHP dotenv** — Environment-specific configuration

## Features

The codebase contains components for:

- Product and catalogue presentation
- Shopping cart functionality
- Business information and contact details
- Website content and page management
- Administrative functionality
- Email communication
- Multilingual configuration support

Not all features are necessarily active or fully configured in the current version.

## Project Structure

| Directory | Description |
|---|---|
| `app/` | Laravel application |
| `legacy/` | Original public website, administration, uploads, and example database |
| `docker/` | Root Docker configuration |

The legacy public and administrative applications maintain separate Composer dependency configurations.

## Legacy Local Setup

The following legacy instructions apply inside `legacy/`, not at the repository root.

### Requirements

- PHP with the extensions required by the application
- MySQL or a compatible database
- Composer
- A compatible PHP web server

### Install Dependencies

Install the dependencies for the main application:

```bash
composer install
```

Install the administrative application's dependencies:

```bash
cd admin
composer install
cd ..
```

### Environment Configuration

Create a local environment file:

```bash
cp .env.example .env
```

Configure the database and email settings:

```dotenv
DB_HOST=localhost
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_HOST=
MAIL_USERNAME=
MAIL_PASSWORD=
```

The application loads these values through PHP dotenv.

The `.env` file must remain outside version control.

### Database

A compatible database and schema are required for database-dependent features. Database exports are deliberately excluded from the repository.

The project may require additional configuration to run in a new environment.

## Architecture

### Custom PHP Application

The project uses traditional server-rendered PHP with a custom application structure.

Its architecture reflects direct control over routing, configuration, database interaction, and reusable application components.

### Administration

The Laravel application provides a Filament administration panel at `/admin`.
The original administration application remains under `legacy/admin/` for
reference.

### Email

Email functionality uses PHPMailer, with SMTP credentials provided through environment variables.

## Security and Repository Maintenance

The repository has undergone history sanitization to remove sensitive information and unnecessary generated content.

The cleanup includes:

- Removal of historically committed database and email credentials
- Removal of historical `.env` files
- Removal of database dumps
- Removal of uploaded content from Git history
- Removal of historically committed third-party dependencies
- Migration to environment-based configuration

Application credentials and uploaded files should be managed outside version control.

## Project Status

**Laravel migration in progress**

The landing page, news listing (`/blog`), articles (`/blog/post?id=...`),
course listing and details (`/courses` and `/courses/course?id=...`), storefront
catalogue (`/shop`, `/shop/list`, `/shop/item?id=...`, `/item?id=...`, and
`/herbs`), and the contacts page (`/contacts`) have been
migrated to Laravel. Checkout, public-user authentication and cart indicators
are not yet migrated. Product add-to-cart controls are disabled until checkout
is available, and links to unmigrated routes do not work in Laravel yet. The
Laravel application is not yet a replacement for the public site.

The Filament panel supports legacy administrators and managers, product,
news and course management, and product CSV imports.
Public pages are always accessible.
The old editable administration menu is replaced by Filament navigation.
Administrators can sign in with their existing email and password;
legacy plaintext or MD5 passwords are upgraded to Laravel hashes on login.
This changes the existing password field, so keep a database backup and check
compatibility before returning to an older application.

Product CSV files use semicolon-separated columns in this order: `name`,
`type`, `tech`, `info`, `methods`, `ingredients`, `warnings`, `price`.
An optional first row beginning with `nome` is ignored. Update-only mode
matches by name, skips empty fields, and reports missing products. Existing
products retain their name and type during imports. Duplicate names in the
same file are rejected. The file is validated before writing, but the legacy
MyISAM tables do not support transactional
rollback; back up the database before bulk imports.

The panel requires PHP GD and writable public storage. After installing or
updating Composer dependencies, `filament:assets` publishes its CSS, JavaScript
and fonts automatically; if deploying dependencies without Composer scripts,
run `cd app && php artisan filament:assets` explicitly. These generated assets
are not tracked in Git. Uploaded images use the existing public storage paths
described below. Existing images are retained when a product changes type.

The contact form sends to the published shop email address using Laravel's
configured mailer. Configure a real mail transport and an authorized sender
before enabling the form in production. For the root Docker setup, set
`MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`,
`MAIL_SCHEME` (`smtp` or `smtps` as appropriate), `MAIL_FROM_ADDRESS`, and
`MAIL_FROM_NAME` in the Compose environment. The default `log` mailer and
placeholder sender do not deliver messages; the form reports an error instead
of claiming success. Apply environment changes to the app container using
your normal deployment procedure. The form retains the legacy email-provider
and message-content spam filters.

The migrated pages read the existing `posts`, `courses`, `items`, `items_types`,
and `items_uses` tables without changing them. Copy the existing `uploads/blog`, `uploads/courses`, and
`uploads/items` directories to `app/storage/app/public` without overwriting
newer uploads, and expose `app/storage/app/public` at `app/public/storage`.
For example, from the repository root, when `app/public/storage` does not
already exist:

```bash
mkdir -p app/storage/app/public/blog
cp -n legacy/uploads/blog/*.jpg app/storage/app/public/blog/
cp -an legacy/uploads/courses app/storage/app/public/
cp -an legacy/uploads/items app/storage/app/public/
ln -s ../storage/app/public app/public/storage
```

In production, use the actual deployed upload directory as the source, not the
example files in `legacy/`. The relative link works both on the host and in the
root Docker container. Uploaded files and the link are not tracked by Git.

The legacy database must be retained. Laravel's starter migration no longer
creates or drops the legacy `users` table; it only manages Laravel's
`password_reset_tokens` and `sessions` tables. This does not yet adapt Laravel
authentication to the legacy user schema. Back up the database and review all
migrations before applying them to an existing installation. In particular,
do not use `migrate:fresh` or other commands that drop existing tables.

Further compatibility, functionality, and security testing is recommended before production deployment.

## License

No open-source license is currently specified. All rights are reserved unless otherwise stated.

Third-party dependencies and assets remain subject to their respective licenses.
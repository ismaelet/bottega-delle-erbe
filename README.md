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
| `app/` | Main PHP application, configuration, and modules |
| `admin/` | Administrative application and its dependencies |
| `pages/` | Website pages, assets, and presentation resources |
| `system/` | Supporting application functionality |
| `listeners/` | Application event and request handlers |
| `uploads/` | Runtime-uploaded content, excluded from Git |
| `database/` | Local database resources, excluded from Git |

The root application and administrative application maintain separate Composer dependency configurations.

## Local Setup

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

The administrative application is maintained separately under `admin/`, with its own Composer configuration.

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

**Legacy portfolio project**

This repository is retained as a record of the original implementation and its development history.

Further compatibility, functionality, and security testing is recommended before production deployment.

## License

No open-source license is currently specified. All rights are reserved unless otherwise stated.

Third-party dependencies and assets remain subject to their respective licenses.
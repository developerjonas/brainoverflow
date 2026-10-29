# Brainoverflow

## Requirements

- PHP 8.1+ with `mysqli` and `mysqlnd`
- MySQL or MariaDB with the schema in `brainoverflow.sql`
- A dedicated database account with only the permissions this application needs

## Configure the database

Import `brainoverflow.sql`, then set `DB_HOST`, `DB_NAME`, `DB_USER`, and
`DB_PASSWORD` in the PHP web server environment. `.env.example` lists the
required names; PHP does not load that file automatically. Do not use the
database root account or commit real credentials.

Existing databases created before this update should also migrate the admin
timestamp column:

```sql
ALTER TABLE admin
  MODIFY dt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
```

## Create the first administrator

Admin registration is restricted to an already authenticated administrator.
For a fresh installation, generate a password hash with PHP:

```sh
php -r 'echo password_hash("replace-this-password", PASSWORD_DEFAULT), PHP_EOL;'
```

Insert the administrator using the generated hash (not the plaintext password):

```sql
INSERT INTO admin (name, email, pass)
VALUES ('admin-name', 'admin@example.com', 'paste-generated-hash-here');
```

After signing in, use **Create Admin** in the dashboard to add additional
administrators.

## Security and project layout

- `partials/_helpers.php` centralizes HTML escaping, session setup, and CSRF tokens.
- `partials/admin/_auth.php` protects administrator pages and actions by role.
- `partials/database/_connect.php` reads credentials from the environment and
  enables strict MySQLi errors.
- Mutating forms use CSRF tokens; queries that consume user or session input use
  prepared statements.

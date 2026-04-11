---
layout: default
title: OJS Installation Notes
permalink: /journal/ojs-install-notes.html
---

# OJS 3.5 Installation Requirements (Ubuntu)

This guide installs all required dependencies to run **Open Journal Systems (OJS) 3.5** on Ubuntu, including PHP 8.3, required extensions, and 
a database server (MySQL/MariaDB/PostgreSQL). It also sets up a ready-to-use OJS database.

---

# 1. Install PHP 8.3 and required extensions

This step installs PHP 8.3 and all extensions required by OJS such as:

- mbstring (text handling)

- xml (XML processing)

- intl (internationalization support)

- database drivers for MySQL and PostgreSQL

```bash
sudo apt update && sudo apt install -y software-properties-common && sudo add-apt-repository -y ppa:ondrej/php && sudo apt update && sudo apt install -y \
php8.3 php8.3-cli php8.3-common \
php8.3-mbstring php8.3-xml php8.3-intl \
php8.3-mysql php8.3-pgsql
```

---

# 2. Install and start database server

OJS supports multiple databases. This step installs MySQL (recommended), MariaDB, and PostgreSQL.

## MySQL (recommended)

MySQL will be used as the primary database for OJS in this setup.

```bash

sudo apt install -y mysql-server

sudo systemctl start mysql

sudo systemctl enable mysql

sudo systemctl status mysql

```

## MariaDB (alternative to MySQL)

MariaDB is a drop-in replacement for MySQL.

```bash

sudo apt install -y mariadb-server

sudo systemctl start mariadb

sudo systemctl enable mariadb

sudo systemctl status mariadb

```

## PostgreSQL (alternative)

PostgreSQL can also be used if preferred.

```bash

sudo apt install -y postgresql postgresql-contrib

sudo systemctl start postgresql

sudo systemctl enable postgresql

sudo systemctl status postgresql

```

---

# 3. Create OJS database and user (MySQL)

This step creates a dedicated database and user for OJS and assigns permissions.

```bash

sudo mysql

```

Inside the MySQL shell, run:

```sql

CREATE DATABASE ojs;

CREATE USER 'ojsuser'@'localhost' IDENTIFIED BY 'StrongPassword123';

GRANT ALL PRIVILEGES ON ojs.* TO 'ojsuser'@'localhost';

FLUSH PRIVILEGES;

EXIT;

```

---

# 4. Test database connection

This step verifies that the database user works correctly and can access the OJS database.

```bash

mysql -u ojsuser -p ojs

```

---

# 5. Verify PHP installation

This step ensures PHP and all required modules are correctly installed and active.

```bash

php -v

php -m | grep -E "mbstring|xml|intl"

```

---

# Notes for OJS 3.5

* Recommended database: **MySQL or MariaDB**

* Use `127.0.0.1` instead of `localhost` if connection issues occur

* Ensure database credentials match during OJS web installer

* Change default passwords before production use

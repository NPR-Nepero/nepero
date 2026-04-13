---
layout: default
title: OJS Installation Notes
permalink: /journal/ojs-install-notes.html
---

# OJS 3.5.0-3 SSH Install Guide

This is a very short guide to install OJS on a personal Ubuntu server or on commercial hosting such as IONOS. The example assumes SSH access to the server and OJS version `3.5.0-3`.

## Requirements

- Object: server access. You need SSH access to the remote server and a web-accessible directory such as `~/public` or `~/public/nepero/journal`.
- Object: PHP runtime. OJS must run with PHP `8.2`.
- Object: MySQL server. You need MySQL `8` and the database connection credentials: host, database name, user, and password.
- Object: browser. The final OJS setup is completed from the web installer in a browser.

## Optional Ubuntu Setup

If you are using your own Ubuntu server, install PHP 8.2, common PHP extensions, and MySQL 8 first:

```bash
sudo apt update
sudo apt install -y wget tar php8.2 php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring php8.2-gd php8.2-curl php8.2-zip php8.2-intl mysql-server
sudo systemctl enable --now mysql
```

Object: system packages and services. This installs the PHP runtime, the extensions commonly needed by OJS, and the MySQL server.

If needed, create the OJS database and user:

```sql
CREATE DATABASE ojs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ojsuser'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON ojs.* TO 'ojsuser'@'localhost';
FLUSH PRIVILEGES;
```

Object: database credentials. These values are required later in the OJS web installer.

## Install Steps

1. SSH into the server:

```bash
ssh your-user@your-server
```

Object: SSH session. This opens a remote shell on the machine where OJS will run.

2. Go to the web directory:

```bash
cd ~/public/journal
```

Object: web root. This is the folder that will contain the OJS files served by the web server.

3. Download OJS:

```bash
wget https://pkp.sfu.ca/ojs/download/ojs-3.5.0-3.tar.gz
```

Object: OJS archive. This fetches the official OJS release package from PKP.

4. Extract OJS and enter the directory:

```bash
tar -xzf ojs-3.5.0-3.tar.gz
cd ojs-3.5.0-3
```

Object: application files. This creates the OJS source directory on the server.

5. Start or verify MySQL:

```bash
sudo systemctl start mysql
```

Object: MySQL service. OJS stores its data in MySQL, so the database server must be running and you must know the connection credentials.

If you are on commercial hosting such as IONOS, MySQL is usually already running. In that case, use the host, database name, user, and password provided by the hosting control panel.

6. Start PHP from inside the extracted OJS directory:

```bash
php -S 0.0.0.0:8000
```

Object: PHP application server. This starts a simple PHP web server from the current OJS directory.

7. Open the installer in your browser:

```text
http://your-server:8000
```

Object: OJS web installer. Complete the installation form and enter the MySQL host, database name, user, and password so OJS can connect to the database.

## Note for Hosted Servers

On IONOS or similar hosting, PHP and MySQL are often already available. In that case, you may only need to upload the files, confirm the correct PHP version is set to `8.2`, and then open the site URL in your browser to complete the installer. If the hosting uses Apache or Nginx directly, the built-in `php -S` command may be unnecessary.
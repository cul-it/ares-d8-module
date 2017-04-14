SimpleSAMLphp - customized for Pantheon
=============

This is an unofficial fork of simplesaml 1.13.1.

How to use:
===========

1. If it's not already there, create a /private directory in your Drupal site root directory (same place as Drupal's index.php).
2. Download the .zip version of this repo and extract it into /private/pantheon-simplesamlphp. This readme file should end up at /private/simplesamlphp/README.md
3. Create a symlink in your Drupal site root directory called simplesaml that leads to the www directory inside /private/pantheon-simplesamlphp. (1)
4. Add some code to your settings.php file. (2)
5. Push the changes to the remote Pantheon git repo.
6. Test at http://[sitename]/simplesaml/module.php/core/authenticate.php

(1)

```
ln -s ./private/pantheon-simplesamlphp/www simplesaml
```

(2)

```
<?php
if (defined('PANTHEON_ENVIRONMENT')) {
  if (!empty($_SERVER['PRESSFLOW_SETTINGS'])) {
    $config_version = '/code/private/pantheon-simplesamlphp';
    $ps = json_decode($_SERVER['PRESSFLOW_SETTINGS'], TRUE);
    $conf['simplesamlphp_auth_installdir'] = '/srv/bindings/'. $ps['conf']['pantheon_binding'] . $config_version;
  }
}
?>
```

Your Drupal directory should end up looking like this:

```
.
├── CHANGELOG.txt
├── COPYRIGHT.txt
├── INSTALL.mysql.txt
├── INSTALL.pgsql.txt
├── INSTALL.sqlite.txt
├── INSTALL.txt
├── LICENSE.txt
├── MAINTAINERS.txt
├── README.txt
├── UPGRADE.txt
├── authorize.php
├── cron.php
├── includes
├── index.php
├── install.php
├── misc
├── modules
├── pantheon.yml
├── private
├── profiles
├── robots.txt
├── scripts
├── simplesaml -> private/pantheon-simplesamlphp/www
├── sites
├── themes
├── update.php
├── web.config
└── xmlrpc.php
```


Details:
===========
There are 3 files that differ depending on whether you're in production or non-production (test) mode:

* 	config/authsources.php
* 	metadata/shib13-idp-remote.php
* 	metadata/saml20-idp-remote.php

Each of these files has a default [filename].default, test [filename].test, and production [filename].prod version.

The files themselves contain logic to inclued one of the 3 versions depending on the state of some Pantheon environment variables.

The production version is only used on the live Pantheon site, and only WORKs when you use the official domain name of the site. (It works on https://hlm.library.cornell.edu, but not on https://live-hlmlibrarycornelledu.pantheonsite.io)

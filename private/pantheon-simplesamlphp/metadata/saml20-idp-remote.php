<?php

/**
 * select which version to include based on Pantheon environmental variables
 * original contents of this file now in saml20-idp-remote.php.default
 */

if (defined('PANTHEON_ENVIRONMENT') && !empty($_ENV['PANTHEON_ENVIRONMENT'])) {
    if ($_ENV['PANTHEON_ENVIRONMENT'] == 'live') {
        require 'saml20-idp-remote.php.prod';
    }
    else {
        require 'saml20-idp-remote.php.test';
    }
}
else {
    require 'saml20-idp-remote.php.default';
}


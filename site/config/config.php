<?php
use Kirby\Filesystem\F;

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen. 
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */

return [
    'debug' => false,
    'yaml.handler' => 'symfony', // already makes use of the more modern Symfony YAML parser: https://getkirby.com/docs/reference/system/options/yaml (will become the default in a future Kirby version)
    'url' => getenv('KIRBY_URL'),
    'languages' => true,
    'languages' => [
        'detect' => true
    ],
    'content' => [
        'extension' => 'txt'
    ],
    'markdown' => [
        'extra' => true,
        'breaks' => true
    ],
    'panel' => true,
    'panel' =>[
        'install' => true
    ],
    'thathoff' => [
        'oauth' => [
            'providers' => [
                'custom' => [
                    // this one uses \League\OAuth2\Client\Provider\GenericProvider automatically
                    'name'                    => 'University of Bern', // The name is optional
                    'clientId'                => getenv('KIRBY_OIDC_CLIENT_ID'),    // The client ID assigned to you by the provider
                    'clientSecret'            => getenv('KIRBY_OIDC_CLIENT_SECRET'),   // The client password assigned to you by the provider
                    'redirectUri'             => getenv('KIRBY_OIDC_REDIRECT_URI'),
                    'urlAuthorize'            => getenv('KIRBY_OIDC_URL_AUTHORIZE'),
                    'urlAccessToken'          => getenv('KIRBY_OIDC_URL_ACCESS_TOKEN'),
                    'urlResourceOwnerDetails' => getenv('KIRBY_OIDC_URL_RESOURCE_OWNER_DETAILS'),
                    'icon'                    => 'account',  // Pick any default Kirby icon for the login button (optional)
                    'scope'                   => 'openid email profile User.Read'  //specify the scope passed form the OIDC provider to kirby
                ],
            ],
        ],
        // Only allow logins for existing kirby users (don’t create new users)
        'onlyExistingUsers' => false,

         // Set the default role of newly created users.
        'defaultRole' => 'nobody',

        // Allow every valid user of all OAuth providers to login.
        // For details see “Configure Allowed Users” below.
        // DANGEROUS: Make sure you know what you’re doing when setting this to true!
        'allowEveryone' => false,

        // List of E-mail domains which are allowed to login
        'domainWhitelist' => [
          'unibe.ch'
        ],

        // List of E-mail addresses which are allowed to login
        'emailWhitelist' => [
          // For details see “Configure Allowed Users” below.
        ],

        // Remove the standard Kirby login form and only display OAuth options.
        'onlyOauth' => true,
    ],
    'ready' => function($kirbyLicense) {
        $license_file = $kirbyLicense->root('license');
        $license = getenv('KIRBY_LICENSE');

        if ($license && !F::exists($license_file)) {
            F::write($license_file, $license);
        }
    }
];

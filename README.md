# ActOn for Custom Contact Forms

## Install

Add the repository in `composer.json`:

    "repositories": [
        {
            "type": "vcs",     
            "url": "https://github.com/inviqa/wordpress-ccf-acton"
        }
    ],
    "require": [
        "inviqa/wordpress-ccf-acton": "dev-master"
    ]

If your WordPress installation lives in `public` folder, add:

    "extra": {
        "installer-paths": {   
            "public/wp-content/plugins/{$name}": [ "inviqa/wordpress-ccf-acton" ]
        }
    }

Run:

    composer update

## Use

In WordPress administration, go to Settings > ActOn and follow the instructions within.

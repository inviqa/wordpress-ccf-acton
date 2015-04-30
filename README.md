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

Add the installed path to your `.gitignore`:

    # Handled by composer
    public/wp-content/plugins/ccf-acton

Run:

    composer update

## Use

* Activate the plugin in WordPress administration.
* Go to Settings > ActOn and follow the instructions within.

# The Binding of Isaac RESTful API

[![Build Status](https://travis-ci.org/jamesmcfadden/binding-of-isaac-api.svg?branch=master)](https://travis-ci.org/jamesmcfadden/binding-of-isaac-api)

The Binding of Isaac API is a project aiming to make available as much data about the Binding of Isaac game series as possible.

The current release can be found at [isaac.jamesmcfadden.co.uk/api/v1](https://isaac.jamesmcfadden.co.uk/api/v1). Note that the API is still in early development, so changes to the data may happen regularly.

    > curl https://isaac.jamesmcfadden.co.uk/api/v1/item/2JrEs
    {
      "id": "2JrEs",
      "name": "Pentagram",
      "url": "https://isaac.jamesmcfadden.co.uk/api/v1/item/2JrEs"
    }

## Documentation

Documentation is currently being written. For the time being, API endpoints can be found on the API index ([isaac.jamesmcfadden.co.uk/api/v1](https://isaac.jamesmcfadden.co.uk/api/v1)).

## Contributing

Contribution is both welcome and encouraged! Please submit a pull request if you'd like to add features or fixes to either the API data or the source code itself.

### Source Code Contribution

The API is written in PHP, and uses the [Laravel](https://laravel.com/docs) framework, which is easy to use. Check `composer.json` for the version in use.

#### Installation

It is recommended you run the API in [Laravel Homestead](https://laravel.com/docs/homestead), as this will take care of the necessary system dependencies and server configuration (as well as ensure you're running PHP >= 7.0).

After forking and cloning the repository, setup your configuration file:

    cd path/to/binding-of-isaac-api
    cp .env.example .env
    php artisan key:generate

Install (if required) and run [composer](https://getcomposer.org) to install necessary dependencies:

    composer install
    
Install the database:

    php artisan migrate
    
Import the data to the database:
    
    php artisan import
    
After modifying the data files, you'll need to refresh the database and re-import to see your changes. Note that this will completely wipe the database and import the data fresh:

    php artisan migrate:refresh && php artisan import

#### Tests

The test suite uses PHPUnit and can be run from the project root with:

    vendor/bin/phpunit

### Data Contribution

The data files use CSV and can be found in the `data` directory. Each file represents a database table.

Please use the following format:

- Filenames must match the database table name;
- Data files are headed with the associated database column names;
- Records are separated with a newline character;
- Fields are separated with by a comma (`,`);
- Text fields with a comma inside should be enclosed in quotes (`"`);
- Text fields with quotes inside should be escaped with another quote (`"`);
- Empty fields are treated as `null`

Example:

    id,name,description,optional_data,order
    1,Record One,"This is some text, with a comma",,1
    2,Record Two,"This is some text with ""quotes"" within",,2

#### Data Identifiers

The project makes use of string identifiers as opposed to incremental integers. This keeps the data files flexible and eliminates the urge to order numerical identifiers, making maintenance easier and minimising the risk of foreign key constraint violations.

You may run the following command in the project root to generate as many identifiers as you require:

    php artisan generate-ids 10

Note that the identifiers generated are only unique for the current command - there is a small chance the identifier is already in use in an existing data file, but MySQL will let you know if there is upon importing. All identifiers should have a character length of 5.

## License

View the license file [here](https://github.com/jamesmcfadden/binding-of-isaac-api/blob/master/LICENSE.md).

## Disclaimer

This is a fan-driven open source project and is not in any way affiliated with any proprietor of the Binding of Isaac video game series.

<img style="float: right;" src="https://s11.postimg.org/71lnw7tn7/Isaac_Descent.png">

# kollex Coding Challenge – Wholesaler Integration
by Andrés Romero Valiente

## Approach
My approach is more or less minimalistic. Actually it is a library that can be implemented in other applications. It has only one
service containing one facade method as entry point.

## Dependencies
To keep them as minimal as possible I only use `PHP8`. `phpunit`,`phpstan`,`phplint` and `php-cs-fixer` are for testing and static code analysing purposes only and are not required in
production environments.    

## Setup
- Setup/start container: `docker-compose up -d`
- Login to container: `docker-compose exec app bash`
- Install composer/vendor packages: `composer install --prefer-dist`

## Run test app
- CSV: `php ./examples/app.php /var/www/kollex/data/wholesaler_a.csv`
- JSON: `php ./examples/app.php /var/www/kollex/data/wholesaler_b.json`

## Run tests
- static code analysis and tests: `composer ci`
- tests only: `composer tests`

## Data Structure
The data structure is simple. I use thin DTOS that live inside the `Model` folder. I also moved ProductInterface there.
DataProviderInterface has only one new method: `toArray()`

## DataProvider
Here you find strategies for reading both, JSON and CSV formats (new ones can easily be added). 

## Further thoughts / TBD / TODOS
- There are valid arguments to not create unit and packaging instances (KISS/Performance vs data consistency).
  This truly can/should be discussed.
- Regarding the DataProvider structure it is possible to get rid of `DataProviderInterface` and instead move the
abstraction to `BaseDataProvider` and make this class abstract.
- Adding a logger would be in a real-world application essential to retrace why and which records might be skipped. In this case the logger should be injected 
to the service.
- The validation of the source files is rudimentary. It would make sense to validate also the structure of the files (e.g. CSV: Amount of columns, JSON: Structure).
   

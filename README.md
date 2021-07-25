# kollex Coding Challenge – Wholesaler Integration
by Andrés Romero Valiente

## Approach
My approach is more ore less minimalistic. Actually it is a library than can be implemented in applications. It has only one
service containing one facade method.

## Dependencies
To keep them as minimal as possible I only use PHP8. `phpunit`,`phpstan`,`phplint` and `php-cs-fixer` are for testing and static code analysing purposes only and are not required in
production environments.    

## Setup
- Setup/start container: `docker-compose up -d`
- Login in container: `docker-compose exec app bash`
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
Here you find strategies for reading both, JSON and CSV formats(New ones can easily be added). 

## Further thoughts / TBD / TODOS
- There are valid arguments to not create manufacturer and packaging instances. (KISS/Performance vs data consistency).
  This truly can/should be discussed.
- Regarding the DataProvider structure it is possible to get rid of `DataProviderInterface` and instead moved the
abstraction to `BaseDataProvider` and make this class abstract.
- Adding a Logger would be in a real world application essential to retrace why and which records might be skipped. In this case the logger should be injected 
to the Service.
- The validation of the source files is rudimentary. It would make sense to valid also the structure of the files(e.g. CSV: Amount of columns, JSON: Structure)
   

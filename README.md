# REST API for products

This application exposes a REST API with a single endpoint for querying products.

It is based on Slim Framework 4. The classes have been generated 100% from scratch.

## Endpoints

The API exposes the following endpoints:

* **/products** Lists all the products stored in the system storage.
* **/products/category/{category}** Filters the products stored in the system storage by category.
* **/products/price/{price}** Filters the products stored in the system storage by price.

## Unit tests

Run this command in the project root to execute the unit tests:

```bash
vendor/phpunit/phpunit/phpunit
```
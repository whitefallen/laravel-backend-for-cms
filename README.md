# Laravel-backend-for-cms
[![coverage report](https://gitlab.com/der-eine-aegyptische-gott/laravel-backend-for-cms/badges/master/coverage.svg)](https://gitlab.com/der-eine-aegyptische-gott/laravel-backend-for-cms/commits/master)
[![pipeline status](https://gitlab.com/der-eine-aegyptische-gott/laravel-backend-for-cms/badges/master/pipeline.svg)](https://gitlab.com/der-eine-aegyptische-gott/laravel-backend-for-cms/commits/master)

## Setup
1. clone this repository.
2. run ``npm install`` in the root directory
3. run ``composer update`` in the root directory
4. create a ``.env`` file in the root directory and copy the content from ``.env.example``
5. run ``php artisan key:generate`` to fill the ``API_KEY`` line in ``.env``
6. run ``php artisan jwt:secret`` to generate a secret
7. run ``php artisan config:clear`` to clear the config cache
8. run ``php artisan config:cache`` to make a config cache
9. Seed the SQLite DB via ``php artisan migrate:refresh --seed``

If all steps are completed, you should now be able to run the project via ``php artisan serve`` and navigate to http://127.0.0.1:8000/ if not specified otherwise 

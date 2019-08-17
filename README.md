# Laravel CRUD Helper

[![Build Status](https://travis-ci.com/technote-space/laravel-crud-helper.svg?branch=master)](https://travis-ci.com/technote-space/laravel-crud-helper)
[![Coverage Status](https://coveralls.io/repos/github/technote-space/laravel-crud-helper/badge.svg?branch=master)](https://coveralls.io/github/technote-space/laravel-crud-helper?branch=master)
[![CodeFactor](https://www.codefactor.io/repository/github/technote-space/laravel-crud-helper/badge)](https://www.codefactor.io/repository/github/technote-space/laravel-crud-helper)
[![License: GPL v2+](https://img.shields.io/badge/License-GPL%20v2%2B-blue.svg)](http://www.gnu.org/licenses/gpl-2.0.html)
[![PHP: >=5.6](https://img.shields.io/badge/PHP-%3E%3D5.6-orange.svg)](http://php.net/)
[![WordPress: >=5.0](https://img.shields.io/badge/WordPress-%3E%3D5.0-brightgreen.svg)](https://wordpress.org/)

CRUD helper for Laravel.

[Packagist](https://packagist.org/packages/technote/laravel-crud-helper)

## Install

```
composer require technote/laravel-crud-helper
```

## Usage
1. Implement Crudable contract and Crudable Trait.
   ```php
   <?php
   namespace App\Models;
   
   use Eloquent;
   use Illuminate\Database\Eloquent\Model;
   use Technote\CrudHelper\Models\Contracts\Crudable as CrudableContract;
   use Technote\CrudHelper\Models\Traits\Crudable;
    
   /**
    * Class Item
    * @mixin Eloquent
    */
   class Item extends Model implements CrudableContract
   {
       use Crudable;
   
       /**
        * @var array
        */
       protected $guarded = [
           'id',
       ];
   }
   ```

## Routes
CRUD routes are set automatically.
```
> php artisan route:clear
> php artisan route:list
+--------+-----------+------------------+---------------+-----------------------------------------------------------------+------------+
| Domain | Method    | URI              | Name          | Action                                                          | Middleware |
+--------+-----------+------------------+---------------+-----------------------------------------------------------------+------------+
|        | GET|HEAD  | api/items        | items.index   | Technote\CrudHelper\Http\Controllers\Api\CrudController@index   | api        |
|        | POST      | api/items        | items.store   | Technote\CrudHelper\Http\Controllers\Api\CrudController@store   | api        |
|        | GET|HEAD  | api/items/{item} | items.show    | Technote\CrudHelper\Http\Controllers\Api\CrudController@show    | api        |
|        | PUT|PATCH | api/items/{item} | items.update  | Technote\CrudHelper\Http\Controllers\Api\CrudController@update  | api        |
|        | DELETE    | api/items/{item} | items.destroy | Technote\CrudHelper\Http\Controllers\Api\CrudController@destroy | api        |
+--------+-----------+------------------+---------------+-----------------------------------------------------------------+------------+
```

## Details
### Validation
Validation rules are generated by column settings automatically.
- Type
  - integer
  - boolean
  - numeric
  - date
  - time
  - string
- Length
- Unsigned
- by column name
  - email
  - url
  - phone

### Model name
Model name is determined by api name.  
#### ex. test_items
1. to singular: test_item
1. to studly: TestItem

### Namespace
- `App\\Models`  
  - Library does not search recursively.
#### To Change
1. Run command.
   ```
   php artisan vendor:publish --provider="Technote\CrudHelper\Providers\CrudHelperServiceProvider" --tag=config
   ```
1. Change setting (e.g. `App\\Models\\Crud`).
   ```php
   'namespace' => 'App\\Models\\Crud',
   ``` 
   
## Search feature
If implement Searchable, you can add search feature.
### [Laravel Search Helper](https://github.com/technote-space/laravel-search-helper)
```
api/items?s=keyword
```

## Author
[GitHub (Technote)](https://github.com/technote-space)  
[Blog](https://technote.space)

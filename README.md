## PHP Elasticsearch Builder

A PHP implementation of the Elasticsearch Query DSL.

Inspired by Eloquent query building.

**Why:**

## Installation

```bash
composer require hypefactors/elasticsearch-builder
```

## API Basics

...

```php
$queryBuilder = new QueryBuilder();
$queryBuilder->bool(function (BoolQueryInterface $boolQuery) {
    $boolQuery->filter(function (FilterQueryInterface $filterQuery) {
        $filterQuery->term('my-field', 'my-value');
    });
});
```

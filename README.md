<p align="center"><img width="280" src="https://s3.eu-central-1.amazonaws.com/assets.beatswitch.com/distil-logo.svg"></p>
<p align="center">
    <a href="https://travis-ci.org/BeatSwitch/distil"><img src="https://img.shields.io/travis/BeatSwitch/distil/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://styleci.io/repos/102117231/shield"><img src="https://styleci.io/repos/102117231/shield" alt="StyleCI"></a>
    <a href="license.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Licence"></a>
</p>

Distil provides a simple API for dynamically constructing queries in PHP through small value objects.

- [Getting Started](#getting-started)
    - [Simple Example](#simple-example)
    - [Installation](#installation)
    - [Requirements](#requirements)
- [Concepts](#concepts)
    - [Criterion](#criterion)
    - [Criteria Collection](#criteria-collection)
    - [Common Criteria](#common-criteria)
    - [Keywords](#keywords)

## Getting Started

### Simple Example
Let's consider the following scenario: you have a query object `GetPosts` that returns all posts of your blog by default. However, you only need to retrieve from a specific author on some places. 
The query itself is identical, you only need to strip out the ones that were created by anyone other than the given author. To do so, the query object can accept a Criteria collection that may or may not hold the "author" condition. 
```php
use Distil\Criteria;

$authorId = 369;

// Author is an implementation of Distil\Criterion which acts as a Criteria factory.
$posts = (new GetPosts())->get(Author::criteria($authorId));
```

The query object internals can then append statements to the query depending of the given criteria:
```php
use Distil\Criteria;

final class GetPosts
{
    public function get(Criteria $criteria)
    {
        ...
        
        if ($criteria->has(Author::NAME)) {
            $query->where('creator_id', '=', $criteria->get(Author::NAME)->value());
        }
    }
}
```

This approach comes in handy when you need to pass along a variable number of criteria to a single query. Imagine we'd use that `GetPosts`  query object to expose those posts through an API and allow users to filter them by author, publish_date, ... and eventually sort them differently:
```php
use Distil\Criteria;

$criteria = new Criteria();

if (isset($_GET[Author::NAME])) {
    $criteria->add(Author::fromString($_GET[Author::NAME]));
}

if (isset($_GET['sort'])) {
    $criteria->add(new Sort($_GET['sort']));
}

...

$posts = (new GetPosts())->get($criteria);
```

### Installation
You can install this package through Composer:
```
$ composer require beatswitch/distil:dev-master
```

### Requirements
- PHP >= 7.1

## Concepts

### Criterion
A <i>Criterion</i> is a small object (identified by a unique name) that wraps around a single value used as a conditional for a result set. Think of filters, limiting, sorting, ... Those objects must adhere to the `Distil\Criterion`  interface.

#### Example
Let's reconsider the example at the top of the docs and create that `author` filter for the query object. This filter should simply hold the ID of an author:
```php
use Distil\Criterion;

final class Author implements Criterion
{
    public function __construct(int $value)
    {
        $this->value = $value;    
    }
    
    public function name(): string
    {
        return 'author';
    }
    
    public function value(): int
    {
        return $this->value;
    }
}
```

#### Typed Criteria
Distil ships with a set of strictly typed abstract classes (one for each value type) which you can use to add some default behaviour to your `Criterion` instances:
- **Distil\Types\BooleanCriterion** - Wraps around a boolean value.
- **Distil\Types\DateTimeCriterion** - Wraps around an instance of PHP's `DateTimeInterface` and optionally accepts a datetime format.
- **Distil\Types\IntegerCriterion** - Wraps around a integer value.
- **Distil\Types\ListCriterion** - Wraps around an array value.
- **Distil\Types\StringCriterion** - Wraps around a string value.

Each of these can:
- be constructed from a string value through the `fromString` named constructor (remember, the default constructor of these are all strictly typed). This is particularly useful when instantiating `Criterion` instances from a URI query string.
- be constructed from string keywords (see [Keywords](#keywords)).
- be casted to a string.
- act as a `Distil\Criteria` factory (see [Criteria Collection](#criteria-collection)).

So, we can simplify our `Author`  filter from above as such:
```php
use Distil\Types\IntegerCriterion;

final class Author extends IntegerCriterion
{
    public function name(): string
    {
        return 'author';
    }
}
```

### Criteria Collection

### Common Criteria

### Keywords

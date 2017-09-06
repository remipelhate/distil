<p align="center"><img width="280" src="https://s3.eu-central-1.amazonaws.com/assets.beatswitch.com/distil-logo.svg"></p>
<p align="center">
    <a href="https://travis-ci.org/BeatSwitch/distil"><img src="https://img.shields.io/travis/BeatSwitch/distil/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://styleci.io/repos/102117231/shield"><img src="https://styleci.io/repos/102117231/shield" alt="StyleCI"></a>
    <a href="license.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Licence"></a>
</p>

Distil provides a simple API to describe a variable number of conditions that should be met by a result set in PHP. This, for example, makes dynamically constructing queries through small value objects a breeze.

- [Getting Started](#getting-started)
    - [Simple Example](#simple-example)
    - [Installation](#installation)
    - [Requirements](#requirements)
- [Concepts](#concepts)
    - [Criteria](#criteria)
    - [Criterion](#criterion)
    - [Keywords](#keywords)
    - [Common Criteria](#common-criteria)


# Getting Started

## Simple Example

Let's consider the following scenario: you have a query object `GetPosts` that returns all posts of your blog by default. However, you only need to retrieve posts from a specific author on some places. 
The query itself is identical, you only need to strip out the ones that were created by anyone other than the given author. To do so, the query object can accept criteria that may or may not hold the "author" criterion:
```php
$authorId = 369;

// Author is an implementation of Distil\Criterion which acts as a Criteria factory.
$criteria = Author::criteria($authorId);

$posts = (new GetPosts())->get($criteria);
```

The query object internals can then append statements to the query depending of the given criteria. Distil only describes the criteria, you can interpret them however you want. You're fully in control:
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
$criteria = new Distil\Criteria();

if (isset($_GET[Author::NAME])) {
    $criteria->add(Author::fromString($_GET[Author::NAME]));
}

if (isset($_GET['sort'])) {
    $criteria->add(new Sort($_GET['sort']));
}

...

$posts = (new GetPosts())->get($criteria);
```

## Installation

You can install this package through Composer:

```
$ composer require beatswitch/distil:dev-master
```

## Requirements

- PHP >= 7.1


# Concepts

## Criteria

*Criteria* is a collection of conditionals that describe which records should be included within a result set (filtering, limiting, ...)  or how it should be presented (e.g. sorting). Distil represents these single conditionals within the `Distil\Criteria` collection as `Distil\Criterion` instances (see next chapter).

### Adding Criteria

Let's reconsider the example at the top of the docs. Imagine we'd want to retrieve all posts from author with ID 1 and sort them in ascending order of the publish_date. You can pass along `Distil\Criterion` instances on construction:
```php
$criteria = new Distil\Criteria(new Author($authorId), new Sort('publish_date'));
```

… or fluently through the `add()` method:
```php
$criteria = new Distil\Criteria();

$criteria->add(new Author($authorId))
    ->add(new Sort('publish_date'));
```

Each `Distil\Criterion` instance within the collection is unique by name. `add()` does not allow to overwrite an instance in the collection with another one carrying the same name. If you event need to overwrite one, you can use the `set()` method:
```php
$criteria = new Distil\Criteria(new Author(1));

$criteria->add(new Author(2)); // This will throw an Exception.
$criteria->set(new Author(2)); // This will overwrite new Author(1) with new Author(2)
```

### Getting Criteria

You can check if it contains a `Distil\Criterion` instance by name:
```php
$criteria = new Distil\Criteria(new Author(1));

$criteria->has('published'); // returns false
$criteria->has(Author::NAME); // returns true
```

… and get it:
```php
$criteria = new Distil\Criteria(new Author(1));

$criteria->get('published'); // returns null
$criteria->get(Author::NAME); // returns the Author instance
```

### Array Access

`Distil\Criteria` implements PHP's `ArrayAccess` interface, meaning you can interact with it as an array:
```php
$criteria[] = new Author(1); // Acts as set()
$author = $criteria[Author::NAME]; // Acts as get(), but throws an error if the name doesn't exist
```

## Criterion

A *Criterion* is a single condition to which a result set should adhere. Think of a filter, a limit, sorting, ...  Distil represents these as small value objects (identified by a unique name) that wrap around a single value. Those objects must implement the `Distil\Criterion`  interface.

### Example

Once more, let's go back to our example at the top of the docs and create that `author` filter for the query object. This filter holds the ID of an author:
```php
use Distil\Criterion;

final class Author implements Criterion
{
    const NAME = 'author';

    public function __construct(int $id)
    {
        $this->id = $id;    
    }
    
    public function name(): string
    {
        return self::NAME;
    }
    
    public function value(): int
    {
        return $this->id;
    }
}
```

### Typed Criteria

Distil ships with a set of strictly typed abstract classes that you can use to add some default behaviour to your `Distil\Criterion` implementations:
  - **Distil\Types\BooleanCriterion** - Wraps around a boolean value.
  - **Distil\Types\DateTimeCriterion** - Wraps around an instance of PHP's `DateTimeInterface` and optionally accepts a datetime format.
  - **Distil\Types\IntegerCriterion** - Wraps around a integer value.
  - **Distil\Types\ListCriterion** - Wraps around an array value.
  - **Distil\Types\StringCriterion** - Wraps around a string value.

Each of these can:
  - be constructed from a string value through the `fromString` named constructor (remember, the default constructor of these are all strictly typed). This is particularly useful when instantiating `Criterion` instances from a URI query string value.
  - be constructed from string keywords (see [Keywords](#keywords)).
  - be casted to a string.
  - act as a `Distil\Criteria` factory (see [Criterion as Criteria Factories](#criterion-as-criteria-factories)).

So, we can simplify our `Author`  filter from above as such:
```php
use Distil\Types\IntegerCriterion;

final class Author extends IntegerCriterion
{
    const NAME = 'author';
    
    public function name(): string
    {
        return self::NAME;
    }
}
```

### Criterion as Criteria Factories

Any `Distil\Criterion` instance that extends either one of the `Distil\Types` can also be used as `Distil\Criteria` factories:
```php
new Distil\Criteria(new Author($authorId));

// can be rewritten as...

Author::criteria($authorId);
```

Under the hood, this named constructor will delegate its arguments to the Criterion's default constructor, and pass itself along a new `Distil\Criteria` instance.

## Keywords

When creating a `Distil\Criterion` from a string, you can't always cast that string value to the appropriate value type. Therefor, Distil allows you to define keywords for some specific values.

### Working with keyword values

Let's illustrate this with an example and create a `Limit` filter. The value contained by this filter should either be an integer or `null` (aka, there is no limit):
```php
use Distil\Criterion;

final class Limit implements Criterion
{
    public function __construct(?int $value)
    {
        $this->value = $value;
    }
    
    public static function fromString(string $value): self
    {
        return new self((int) $value);
    }

    public function name(): string
    {
        return 'limit';
    }
    
    public function value(): ?int
    {
        return $this->value;
    }
}
```

If we were to offer this as a filter on, for example, a public API, we'd want to be able to resolve `limit=unlimited` to `new Limit(null)`. 'unlimited' can't be naturally casted to a  `null` value, so we need to register it as a keyword. To do so, our `Limit` criterion needs to implement the `Distil\Keywords\HasKeywords` interface, which requires you to define a `keywords()` method:
```php
use Distil\Criterion;
use Distil\Keywords\HasKeywords;
use Distil\Keywords\Keyword;

final class Limit implements Criterion, HasKeywords
{
    ...
    
    public static function fromString(string $value): self
    {
        $value = (new Keyword(self::class, $value))->value();
        
        return new self($value ? (int) $value : $value);
    }
    
    public static function keywords(): array
    {
        return ['unlimited' => null];
    }
}
```

Note the usage of the `Distil\Keywords\Keyword` class in our `fromString()` constructor. It's a small value object that accepts the Criterion class name and the given string value on construction. Using the `keywords()` method, it can check whether or not the given string value is a keyword for another value. If it is, the actual value will be returned:
```php
new Limit(null) == Limit::fromString('unlimited'); // true
```

Now, imagine you'd want to be able to cast the Criterion value back to a string. Using the `Distil\Keywords\Value` class, you can easily derive the keyword for a value:
```php
use Distil\Criterion;
use Distil\Keywords\HasKeywords;
use Distil\Keywords\Keyword;

final class Limit implements Criterion, HasKeywords
{
    ...
    
    public static function keywords(): array
    {
        return ['unlimited' => null];
    }
    
    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword() ?: (string) $this->value;
    }
}
```

If the value is associated with a keyword, the keyword will be returned. If it isn't, we'll get `null`:
```php
(string) Limit::fromString('unlimited') === 'unlimited'; // true
```

### Keywords on Typed Criteria

As mentioned in the [Typed Criteria](#typed-criteria) section, any `Distil\Criterion` intance that extends either one of the `Distil\Types` automatically handles keywords when created from or casted to a string. This means you only need to implement the `Distil\Keywords\HasKeywords` interface without having to overwrite the `fromString()` or `__toString()`.

In addition, any instances of `Distil\Types\BooleanCriterion` will automatically handle 'true' and 'false' string values.

## Common Criteria


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
    - [Factories](#factories)
- [Contributing](#contributing)
- [Changelog](#changelog)
- [License](#license)


# Getting Started

## Simple Example

Let's consider the following scenario: you have a query object `GetPosts` that returns all posts of your blog by default. However, you only need to retrieve posts from a specific author on some places. 
The query itself is identical, you only need to strip out the ones that were created by anyone other than the given author. To do so, the query object can accept criteria that may or may not hold the "author" criterion:

```php
$authorId = 369;

// Author is an implementation of Distil\Criterion which acts as a Criteria factory.
$criteria = Author::criteria($authorId);

$posts = $getPostsQuery->get($criteria);
```

The query object internals can then append statements to the query depending of the given criteria. Distil only describes the criteria, you can interpret them however you want. You're fully in control:

```php
use Distil\Criteria;

final class GetPosts
{
    public function get(Criteria $criteria)
    {
        ...
        
        if ($criteria->has('author')) {
            $query->where('creator_id', '=', $criteria->get('author')->value());
        }
    }
}
```

This approach comes in handy when you need to pass along a variable number of criteria to a single query. Imagine we'd use that `GetPosts`  query object to expose those posts through an API and allow users to filter them by author, publish_date, ... and eventually sort them differently:

```php
$criteria = new Distil\Criteria();

if (isset($requestData['author'])) {
    $criteria->add(Author::fromString($requestData['author']));
}

if (isset($requestData['sort'])) {
    $criteria->add(new Sort($requestData['sort']));
}

...

$posts = $getPostsQuery->get($criteria);
```

## Installation

You can install this package through Composer:

```
$ composer require beatswitch/distil
```

## Requirements

- PHP >= 7.1


# Concepts

## Criteria

*Criteria* is a collection of conditionals that describe which records should be included within a result set (filtering, limiting, ...)  or how it should be presented (e.g. sorting). Distil represents these single conditionals within the `Distil\Criteria` collection as `Distil\Criterion` instances (see next chapter).

### Adding Criteria

Let's reconsider the example at the top of the docs. Imagine we'd want to retrieve all posts from author with ID 1 and sort them in ascending order of the publish_date. You can pass along Criterion instances on construction:

```php
$criteria = new Distil\Criteria(new Author($authorId), new Sort('publish_date'));
```

… or fluently through the `add()` method:

```php
$criteria = new Distil\Criteria();

$criteria->add(new Author($authorId))
    ->add(new Sort('publish_date'));
```

**Each Criterion instance within the collection is unique by name.** `add()` does not allow to overwrite an instance in the collection with another one carrying the same name. If you event need to overwrite one, you can use the `set()` method:

```php
$criteria = new Distil\Criteria(new Author(1));

$criteria->add(new Author(2)); // This will throw an Exception.
$criteria->set(new Author(2)); // This will overwrite new Author(1) with new Author(2)
```

### Getting Criteria

You can check if it contains a Criterion instance by name:

```php
$criteria = new Distil\Criteria(new Author(1));

$criteria->has('published'); // returns false
$criteria->has('author'); // returns true
```

… and get it:

```php
$criteria = new Distil\Criteria(new Author(1));

$criteria->get('published'); // returns null
$criteria->get('author'); // returns the Author instance
```

### Array Access

`Distil\Criteria` implements PHP's `ArrayAccess` interface, meaning you can interact with it as an array:

```php
$criteria[] = new Author(1); // Acts as set()
$author = $criteria['author']; // Acts as get(), but throws an error if the name doesn't exist
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

Distil ships with a set of strictly typed abstract classes that you can use to add some default behaviour to your Criterion implementations:
  - **Distil\Types\BooleanCriterion** - Wraps around a boolean value.
  - **Distil\Types\DateTimeCriterion** - Wraps around an instance of PHP's `DateTimeInterface` and optionally accepts a datetime format.
  - **Distil\Types\IntegerCriterion** - Wraps around a integer value.
  - **Distil\Types\ListCriterion** - Wraps around an array value.
  - **Distil\Types\StringCriterion** - Wraps around a string value.

Each of these can:
  - be constructed from a string value through the `fromString` named constructor (remember, the default constructor of these are all strictly typed). This is particularly useful when instantiating `Criterion` instances from a URI query string value.
  - be constructed from string keywords (see [Keywords](#keywords)).
  - be casted to a string.
  - act as a `Distil\Criteria` factory (see [Criteria Factories](#criteria-factories)).

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

If we were to offer this as a filter on, for example, a public API, we'd want to be able to resolve `limit=unlimited` to `new Limit(null)`. 'unlimited' can't be naturally casted to a  `null` value, so we need to register it as a keyword. To do so, our limit Criterion needs to implement the `Distil\Keywords\HasKeywords` interface, which requires you to define a `keywords()` method:

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

> **Note**: Limit was simply used here as an example. It's actually available out of the box. Make sure to check out the [Common Criteria](#common-criteria) section.

### Keywords on Typed Criteria

As mentioned in the [Typed Criteria](#typed-criteria) section, any Criterion instance that extends either one of the `Distil\Types` automatically handles keywords when created from or casted to a string. This means you only need to implement the `Distil\Keywords\HasKeywords` interface without having to overwrite the `fromString()` or `__toString()` methods.

In addition, any instances of `Distil\Types\BooleanCriterion` will automatically handle 'true' and 'false' string values.

## Common Criteria

Distil provides a couple of common criteria out of the box:

### Limit

`Distil\Common\Limit` is Criterion implementation that wraps around an integer or null value. It does not extend a Criterion Type, but has the same capabilities as any of them:
  - It can be constructed from a string value through the `fromString` named constructor.
  - When constructed from a string value, it accepts the "unlimited" keyword (which is mapped to `null`).
  - It can be casted to a string.
  - It can be used as a Criteria factory.

In addition, Limit has a default value (being 10). So you can instantiate it without any arguments:

```php
$limit = new Distil\Common\Limit();

$limit->value(); // Returns 10, its default value
```

### Sort

`Distil\Common\Sort` is an extension of `Distil\Types\ListCriterion`. It accepts a list of field or properties by which a result set should be sorted:

```php
$sort = new Distil\Common\Sort('-name', 'created_at');
```

Note the usage of the "-" sign in front of the "name" property to indicate the result set should be sorted in descending order on that property. 

Its `value()` method simply returns an array containing those sort fields, but you can also retrieve them as small `Distil\Common\SortField` value objects:

```php
use Distil\Common\SortField;

$sort = new Distil\Common\Sort('-name');

$sort->sortFields() == [new SortField('name', SortField::DESC)];
```

## Factories

### Criteria Factories

Any Criterion instance that extends either one of the `Distil\Types` can also be used as `Distil\Criteria` factories:

```php
new Distil\Criteria(new Author($authorId));

// can be rewritten as...

Author::criteria($authorId);
```

Under the hood, this named constructor will delegate its arguments to the Criterion's default constructor, and pass itself along a new `Distil\Criteria` instance.

If you want to enable using a Criterion as Criteria factory without extending any of the available Criterion Types, you can use the `Distil\ActsAsCriteriaFactory` trait.

### CriterionFactory

In some cases, you may want to instantiate a Criterion by name. Take the following snippet from the example at the top of the docs:

```php
$criteria = new Distil\Criteria();

if (isset($requestData['sort'])) {
    $criteria->add(new Sort($requestData['sort']));
}

if (isset($requestData['limit'])) {
    $criteria->add(Limit::fromString($requestData['limit']));
}

...
```

Rather than doing this in every controller that may use the Sort and Limit criteria, you can register a resolvers for them in the `Distil\CriterionFactory`. A resolver is either a class name or a callable (e.g. named constructor, anonumous function, ...) that actually instantiates the Criterion:

```php
// Note that these resolvers could be injected into the factory through your IoC container.
$factory = new Distil\CriterionFactory([
    'sort' => Distil\Common\Sort::class,
    'limit' => Distil\Common\Limit::class.'::fromString',
]);
$criteria = new Distil\Criteria();

foreach ($requestData as $name => $value) {
    $criteria->add($factory->createByName($name, $value)),
}
```

## Contributing

Please see [the contributing file](CONTRIBUTING.md) for details.

## Changelog

You can see a list of changes for each release in [our changelog file](CHANGELOG.md).

## License

The MIT License. Please see [the license file](LICENSE) for more information.

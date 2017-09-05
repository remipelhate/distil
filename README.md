<p align="center"><img width="280" src="https://s3.eu-central-1.amazonaws.com/assets.beatswitch.com/distil-logo.svg"></p>
<p align="center">
    <a href="https://travis-ci.org/BeatSwitch/distil"><img src="https://img.shields.io/travis/BeatSwitch/distil/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://styleci.io/repos/102117231/shield"><img src="https://styleci.io/repos/102117231/shield" alt="StyleCI"></a>
    <a href="license.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Licence"></a>
</p>

Distil provides a simple API for dynamically constructing queries in PHP through small value objects.

## Getting Started

### Simple Example
Let's consider the following scenario: you have a query object `GetPosts` that returns all posts of your blog by default. However, you only need to retrieve the most recent posts on some places (let's say the ones that were published today). 
The query itself is identical, you only need to strip out the ones that were created before today. To do so, the query object can accept a Criteria collection that may or may not hold the "recent" condition. 
```php
use Distil\Criteria;

$today = (new DateTimeImmutable())->setTime(0, 0, 0);

// Since is an implementation of Distil\Criterion which acts as a Criteria factory.
$posts = (new GetPosts())->get(Since::criteria($today));
```

The query object internals can then append statements to the query depending of the given criteria:
```php
use Distil\Criteria;

final class GetPosts
{
    public function get(Criteria $criteria)
    {
        ...
        
        if ($criteria->has(Since::NAME)) {
            $query->where('created_at', '>', $criteria->get(Since::NAME)->value());
        }
    }
}
```

This approach comes in handy when you need to pass along a variable number of criteria to a single query. Imagine we'd use that `GetPosts`  query object to expose those posts through an API and allow users to filter them by author, publish_date, ... and eventually sort them differently:
```php
use Distil\Criteria;

$criteria = new Criteria();

if (isset($_GET['since'])) {
    $criteria->add(Since::fromString($_GET['since']));
}

if (isset($_GET['sort'])) {
    $criteria->add(new Sort($_GET['sort']));
}

...

$posts = (new GetPosts())->get($criteria);
```

> **Note**: There are shorter ways to instantiate a variable number of criteria, but we'll tackle those further along the docs.

### Installation
You can install this package through Composer:
```
$ composer require beatswitch/distil:dev-master
```

### Requirements
- PHP >= 7.1

## Concepts

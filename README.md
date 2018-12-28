<h1 align="center">Pipeline</h1>

<p align="center">Pipeline Like Laravel</p>

<p align="center">
<a href="https://travis-ci.org/RunnerLee/pipeline"><img src="https://travis-ci.org/RunnerLee/pipeline.svg?branch=master" /></a>
<a href="https://scrutinizer-ci.com/g/RunnerLee/pipeline/?branch=master"><img src="https://scrutinizer-ci.com/g/RunnerLee/pipeline/badges/coverage.png?b=master" title="Scrutinizer Code Coverage"></a>
<a href="https://scrutinizer-ci.com/g/RunnerLee/pipeline/?branch=master"><img src="https://scrutinizer-ci.com/g/RunnerLee/pipeline/badges/quality-score.png?b=master" title="Scrutinizer Code Quality"></a>
<a href="https://styleci.io/repos/163383488"><img src="https://styleci.io/repos/82630238/shield?branch=master" alt="StyleCI"></a>
<a href="https://github.com/RunnerLee/pipeline"><img src="https://poser.pugx.org/runner/pipeline/v/stable" /></a>
<a href="http://www.php.net/"><img src="https://img.shields.io/badge/php-%3E%3D5.6-8892BF.svg" /></a>
<a href="https://github.com/RunnerLee/pipeline"><img src="https://poser.pugx.org/runner/pipeline/license" /></a>
</p>

## Usage

```php
<?php

use Runner\Pipeline\Pipeline;

$pipeline = new Pipeline();

$a = function ($payload, $next) {
    echo 'a' . PHP_EOL;
    return $next($payload);
};
$b = function ($payload, $next) {
    echo 'b' . PHP_EOL;
    return $next($payload);
};
$c = new class{
    public function handle($payload, $next)
    {
        echo 'c' . PHP_EOL;
        return $next($payload);
    }
};

$pipeline->pipe($a)->pipe($b)->pipe($c)->method('handle')->payload(1)->process(function ($payload) {
    return $payload * 20;
});

```
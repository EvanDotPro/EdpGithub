<?php
/**
* EdpGithub
*
*/

if (
    !($loader = @include __DIR__ . '/../vendor/autoload.php')
    && !($loader = @include __DIR__ . '/../../../autoload.php')
) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

$loader->add('EdpGithubTest\\', __DIR__);

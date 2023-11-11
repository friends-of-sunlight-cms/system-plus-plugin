<?php

use Composer\Semver\Semver;
use Sunlight\Core;

return function (array $args) {
    if ($args['name'] !== 'plugins') {
        return;
    }

    $this->enableEventGroup('system-plus');
    if (Semver::satisfies(Core::VERSION, '>=8.0.2')) {
        $this->enableEventGroup('system-plus-802');
    }
};

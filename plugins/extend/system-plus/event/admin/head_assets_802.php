<?php

use Composer\Semver\Semver;
use Sunlight\Core;

return function (array $args) {
    $args['js'][] = $this->getAssetPath('public/js/plugins-tabs.js');
};

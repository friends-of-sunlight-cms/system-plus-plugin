<?php

return function (array $args) {
    $args['js'][] = $this->getAssetPath('public/js/plugins-filter.js');
};

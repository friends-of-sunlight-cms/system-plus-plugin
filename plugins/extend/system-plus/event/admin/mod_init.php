<?php

return function (array $args) {
    if ($args['name'] === 'plugins') {
        $this->enableEventGroup('system-plus');
    }
};

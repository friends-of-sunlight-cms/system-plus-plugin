<?php

namespace SunlightExtend\SystemPlus;

use Fosc\Feature\Plugin\Config\FieldGenerator;
use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;

class ConfigAction extends BaseConfigAction
{
    protected function getFields(): array
    {
        $langPrefix = '%p:systemplus.config';

        $gen = new FieldGenerator($this->plugin);
        $gen->generateField('service_buttons', $langPrefix, '%checkbox');

        return $gen->getFields();
    }
}
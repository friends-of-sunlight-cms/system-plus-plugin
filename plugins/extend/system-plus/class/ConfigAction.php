<?php

namespace SunlightExtend\SystemPlus;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;

class ConfigAction extends BaseConfigAction
{
    public function getConfigLabel(string $key): string
    {
        return _lang('systemplus.config.' . $key);
    }
}

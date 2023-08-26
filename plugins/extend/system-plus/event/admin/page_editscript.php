<?php

use Sunlight\Admin\AdminState;
use Sunlight\Core;
use Sunlight\Extend;
use Sunlight\Router;
use Sunlight\User;
use Sunlight\Util\Request;

function getBoxButton(string $link, string $iconName, string $label, array $options = []): string
{
    $options += [
        'css_class' => [],
        'target' => '_blank',
    ];

    $plugin = Core::$pluginManager->getPlugins()->getExtend('system-plus');
    $icon = $plugin->getAssetPath('public/icons/' . $iconName . '.png');
    return '<a class="' . implode(' ', $options['css_class']) . '" href="' . _e($link) . '" target="' . $options['target'] . '">'
        . '<img src="' . _e($icon) . '" alt="' . $iconName . '" class="icon">'
        . $label
        . '</a>';
}

return function (array $args) {
    /**  @var $_admin AdminState */
    global $_admin, $new, $editscript_setting_extra, $query;

    $buttons = [];

    $config = $this->getConfig();

    if ($config['service_buttons']) {
        // add save and preview buttons
        $buttons['content_service'] = '<div id="service-container"><button type="submit" class="button savebtn block bigger" accesskey="s">
            <img src="' . _e($this->getAssetPath('public/icons/save.png')) . '" alt="save" class="icon">'
            . ($new ? _lang('global.create') : _lang('global.savechanges'))
            . '</button>'

            . (!$new ? getBoxButton(
                Router::page($query['id'], $query['slug']),
                'magnifier',
                _lang('systemplus.btn.preview'),
                ['css_class' => ['button', 'prevbtn', 'bigger']]
            ) : '')
            . '</div>';
    }

    // add buttons to category script
    if ($_admin->currentModule === 'content-editcategory' && !$new) {
        $buttons['article_create'] = getBoxButton(
            Router::admin('content-articles-edit', ['query' => ['new_cat' => Request::get('id')]]),
            'edit',
            _lang('admin.content.articles.create'),
            ['css_class' => ['button', 'block', 'bigger']]
        );
        $buttons['article_list'] = getBoxButton(
            Router::admin('content-articles-list', ['query' => ['cat' => Request::get('id')]]),
            'list',
            _lang('admin.content.articles.list.title'),
            ['css_class' => ['button', 'block', 'bigger']]
        );
    }

    // add buttons to gallery script
    if ($_admin->currentModule === 'content-editgallery' && !$new) {
        $buttons['image_manage'] = getBoxButton(
            Router::admin('content-manageimgs', ['query' => ['g' => Request::get('id')]]),
            'images',
            _lang('admin.content.form.manageimgs'),
            ['css_class' => ['button', 'block', 'bigger']]
        );
        if (User::hasPrivilege('adminsettings')) {
            $buttons['image_settings'] = getBoxButton(
                Router::admin('settings', ['fragment' => 'settings_galleries']),
                'settings',
                _lang('systemplus.btn.gallery.settings'),
                ['css_class' => ['button', 'block', 'bigger']]
            );
        }
    }

    // event
    $editscript_setting_extra .= Extend::buffer('system-plus.buttonbox.before', [
        'admin' => $_admin,
        'new' => $new,
        'buttons' => &$buttons,
    ]);
    // render buttonbox
    if (!empty($buttons)) {
        $editscript_setting_extra .= '<div class="systemplus-buttonbox">' . implode('', $buttons) . '</div>';
    }
    //event
    $editscript_setting_extra .= Extend::buffer('system-plus.buttonbox.after', [
        'admin' => $_admin,
    ]);
};

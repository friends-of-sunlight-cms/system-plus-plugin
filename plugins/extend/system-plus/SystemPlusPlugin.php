<?php

namespace SunlightExtend\SystemPlus;

use Sunlight\Admin\AdminState;
use Sunlight\Extend;
use Sunlight\Plugin\ExtendPlugin;
use Sunlight\Router;
use Sunlight\User;
use Sunlight\Util\Request;

class SystemPlusPlugin extends ExtendPlugin
{
    public function onHead(array $args): void
    {
        /** @var $_admin AdminState */
        global $_admin;

        // register only for plugins module
        if (isset($_admin) && $_admin->currentModule === 'plugins') {
            $args['js'][] = $this->getWebPath() . '/resources/js/plugins-filter.js';
        }
    }

    /**
     * Event of adding a function buttons to editscripts
     */
    public function onPageEditScript(array $args): void
    {
        /**  @var $_admin AdminState */
        global $_admin, $new, $editscript_setting_extra;

        $buttons = [];

        // add buttons to category script
        if ($_admin->currentModule === 'content-editcategory' && !$new) {
            $buttons['article_create'] = $this->getBoxButton(
                Router::admin('content-articles-edit', ['query' => ['new_cat' => Request::get('id')]]),
                'edit',
                _lang('admin.content.articles.create')
            );
            $buttons['article_list'] = $this->getBoxButton(
                Router::admin('content-articles-list', ['query' => ['cat' => Request::get('id')]]),
                'list',
                _lang('admin.content.articles.list.title')
            );
        }

        // add buttons to gallery script
        if ($_admin->currentModule === 'content-editgallery' && !$new) {
            $buttons['image_manage'] = $this->getBoxButton(
                Router::admin('content-manageimgs', ['query' => ['g' => Request::get('id')]]),
                'images',
                _lang('admin.content.form.manageimgs')
            );
            if (User::hasPrivilege('adminsettings')) {
                $buttons['image_settings'] = $this->getBoxButton(
                    Router::admin('settings', ['fragment' => 'settings_galleries']),
                    'settings',
                    _lang('systemplus.btn.gallery.settings')
                );
            }
        }

        // event
        $editscript_setting_extra .= Extend::buffer('plugin.system-plus.buttonbox.before', [
            'admin' => $_admin,
            'new' => $new,
            'buttons' => &$buttons,
        ]);
        // render buttonbox
        if (!empty($buttons)) {
            $editscript_setting_extra .= '<div class="systemplus-buttonbox">' . implode('', $buttons) . '</div>';
        }
        //event
        $editscript_setting_extra .= Extend::buffer('plugin.system-plus.buttonbox.after', [
            'admin' => $_admin,
        ]);
    }

    private function getBoxButton(string $link, string $iconName, string $label): string
    {
        $icon = $this->getWebPath() . '/resources/icons/' . $iconName . '.png';
        return '<a class="button block bigger" href="' . _e($link) . '">'
            . '<img src="' . _e($icon) . '" alt="' . $iconName . '" class="icon">'
            . $label
            . '</a>';
    }

    /**
     * Register custom CSS to dynamic system style
     */
    public function onAdminStyle($args)
    {
        $args['output'] .= "\n/* System Plus Plugin */\n";
        // editscript buttonbox
        $args['output'] .= ".module-content-editgallery>form>p>a.button {display: none;}\n";
        $args['output'] .= "button.block.bigger {margin: 6px;}\n";
        $args['output'] .= "button.block img.icon {float: none; margin: 0; padding: 0 10px 0 0;}\n";
        // settings highlight
        $args['output'] .= "fieldset:target {border: 1px solid " . $GLOBALS['scheme_bar'] . ";}";
        $args['output'] .= "\n/* /System Plus Plugin */\n";
    }
}

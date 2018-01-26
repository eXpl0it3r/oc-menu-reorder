<?php namespace Lukas\MenuReorder;

use Event;
use Backend;
use Lang;
use Backend\Controllers\Users as UsersController;
use System\Classes\PluginBase;
use Backend\Classes\NavigationManager;
use Lukas\MenuReorder\Models\BackendMainMenu;

/**
 * UserMenu Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'lukas.menureorder::lang.title',
            'description' => 'lukas.menureorder::lang.description',
            'author'      => 'Lukas Dürrenberger',
            'icon'        => 'icon-reorder',
            'homepage'    => 'https://github.com/eXpl0it3r/octobercms-menu-reorder'
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'users' => [
                'label'       => 'lukas.menureorder::lang.title',
                'url'         => Backend::url('lukas/menureorder/menu/reorder'),
                'icon'        => 'icon-reorder'
            ],
        ];
    }

    public function boot()
    {
        Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {
            $this->adjustMainMenu();
        });
    }

    private function adjustMainMenu()
    {
        $dbItems = BackendMainMenu::all();
        $navItems = NavigationManager::instance()->listMainMenuItems();

        foreach ($navItems as $navItem) {
            $contains = false;

            foreach ($dbItems as $dbItem) {
                if ($dbItem->code == $navItem->code) {
                    $dbItem->label = Lang::get($navItem->label);
                    $dbItem->save();

                    $navItem->order = $dbItem->sort_order;

                    $contains = true;
                }
            }

            if (!$contains) {
                $newDbItem = new BackendMainMenu;
                $newDbItem->label = Lang::get($navItem->label);
                $newDbItem->code = $navItem->code;
                $newDbItem->save();

                // Set initial sort value.
                $newDbItem->sort_order = $newDbItem->id;
                $newDbItem->save();
            }

            NavigationManager::instance()->removeMainMenuItem($navItem->owner, $navItem->code);
        }

        usort($navItems, function($a, $b) {
            return ($a->order > $b->order);
        });

        foreach ($navItems as $navItem) {
            NavigationManager::instance()->addMainMenuItem($navItem->owner, $navItem->code, (array) $navItem);
        }
    }
}
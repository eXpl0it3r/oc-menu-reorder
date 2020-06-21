<?php namespace Lukas\MenuReorder;

use Event;
use Backend;
use Lang;
use Backend\Controllers\Users as UsersController;
use System\Classes\PluginBase;
use Backend\Classes\NavigationManager;
use Lukas\MenuReorder\Models\BackendMainMenu;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'lukas.menureorder::lang.title',
            'description' => 'lukas.menureorder::lang.description',
            'author'      => 'Lukas Dürrenberger',
            'icon'        => 'icon-reorder',
            'homepage'    => 'https://github.com/eXpl0it3r/oc-menu-reorder'
        ];
    }

    public function registerSettings()
    {
        return [
            'menureorder' => [
                'label'       => 'lukas.menureorder::lang.title',
                'description' => 'lukas.menureorder::lang.description',
                'category'    => 'system::lang.system.categories.system',
                'icon'        => 'icon-reorder',
                'url'         => Backend::url('lukas/menureorder/menu/reorder'),
                'order'       => 500,
                'keywords'    => 'menu backend reorder'
            ]
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

        $this->deleteRemovedNavigationItems($dbItems, $navItems);
        $this->updateAndSortNavigationItems($dbItems, $navItems);
    }

    private function deleteRemovedNavigationItems($dbItems, $navItems)
    {
        foreach ($dbItems as $dbItem) {
            $contains = false;

            $matchingNavItems = array_filter($navItems, function($navItem) use ($dbItem) {
                return $dbItem->code == $navItem->code;
            });

            if (empty($matchingNavItems)) {
                $dbItem->delete();
            }
        }
    }

    private function updateAndSortNavigationItems($dbItems, $navItems)
    {
        foreach ($navItems as $navItem) {
            $contains = false;

            foreach ($dbItems as $dbItem) {
                if ($dbItem->code == $navItem->code) {
                    // Update label in database
                    $dbItem->label = Lang::get($navItem->label);
                    $dbItem->save();

                    // Set saved order value
                    $navItem->order = $dbItem->sort_order;

                    $contains = true;
                    break;
                }
            }

            if (!$contains) {
                // Insert new navigation item
                $newDbItem = new BackendMainMenu;
                $newDbItem->label = Lang::get($navItem->label);
                $newDbItem->code = $navItem->code;
                $newDbItem->save();

                // Set initial sort value
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
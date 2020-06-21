<?php namespace Lukas\MenuReorder\Controllers;

use Backend\Classes\Controller;
use Backend;
use BackendMenu;
use Redirect;
use System\Classes\SettingsManager;

class Menu extends Controller
{
    public $implement = ['Backend\Behaviors\ReorderController'];
    
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();
    
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Lukas.MenuReorder', 'menureorder');
    }

    public function index()
    {
        return Redirect::to(Backend::url('lukas/menureorder/menu/reorder'), 302);
    }
}
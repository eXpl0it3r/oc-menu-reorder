<?php namespace Lukas\MenuReorder\Controllers;

use Backend\Classes\Controller;
use Backend;
use Redirect;

class Menu extends Controller
{
    public $implement = ['Backend\Behaviors\ReorderController'];
    
    public $reorderConfig = 'config_reorder.yaml';

    public function index()
    {
        return Redirect::to(Backend::url('lukas/menureorder/menu/reorder'), 302);
    }
}
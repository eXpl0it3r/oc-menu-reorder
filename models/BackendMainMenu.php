<?php namespace Lukas\MenuReorder\Models;

use Model;

/**
 * Model
 */
class BackendMainMenu extends Model
{
    use \October\Rain\Database\Traits\Sortable;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'lukas_menureorder_backendmainmenu';
}
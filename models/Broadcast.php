<?php namespace MoonWalkerz\Press\Models;

use Model;



/**
 * Model
 */
class Broadcast extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'moonwalkerz_press_broadcasts';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];


    public $belongsTo = [
        'release' => [
            'MoonWalkerz\Press\Models\Release',
            'table' => 'moonwalkerz_press_releases',
            'order' => 'title'
        ],
    ];

    public function scopeSendable($query)
    {
        return $query->where('date', '<', date('Y-m-d H:i:s'))->where('sent', 0)->orWhere('sent', null)->orderBy('date', 'asc');
    }

  
}

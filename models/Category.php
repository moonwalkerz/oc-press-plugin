<?php namespace MoonWalkerz\Press\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'moonwalkerz_press_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'releases' => ['MoonWalkerz\Press\Models\Release',
            'table' => 'moonwalkerz_press_releases_categories',
            'order' => 'published_at desc',
//            'scope' => 'isPublished'
        ],
        'reviews' => ['MoonWalkerz\Press\Models\Review',
            'table' => 'moonwalkerz_press_reviews_categories',
            'order' => 'created_at desc',
//            'scope' => 'isPublished'
        ],
    ];
    
}

<?php namespace MoonWalkerz\Press\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'moonwalkerz_press_tags';

    public $timestamps=false;
   /**
     * @var array Relations
     */
    public $belongsToMany = [
        'releases' => [
            //'MoonWalkerz\Press\Models\Release',
            Release::class
           // ,
           // 'table' => 'moonwalkerz_press_releases_tags',
           // 'key' => 'tag_id',
           // 'otherKey' => 'release_id'
        ]
    ];

    /**
     * @var array Fillable fields
     */
    public $fillable = [
        'name',
        'slug',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|unique:moonwalkerz_releases_tags'
    ];

 /**
     * Before create.
     *
     * @return void
     */
    public function beforeCreate()
    {
        $this->setInitialSlug();
    }

    /**
     * Set the initial slug.
     *
     * @return void
     */
    protected function setInitialSlug()
    {
        $this->slug = str_slug($this->name);
    }
        /**
     * Convert tag names to lower case
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtolower($value);
    }

}

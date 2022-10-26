<?php namespace MoonWalkerz\Press\Models;

use Db;
use Url;
use App;
use Str;
use Html;
use Lang;
use Model;
use Markdown;
use BackendAuth;
use ValidationException;

use Backend\Models\User;
use Carbon\Carbon;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;

/**
 * Model
 */
class Review extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at','updated_at','created_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'moonwalkerz_press_reviews';

    /*
     * Validation
     */
    public $rules = [
        'title' => 'required',
        'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:moonwalkerz_press_reviews'],
        'content' => 'required'
        
    ];



    public $attachMany = [
        'images' => ['System\Models\File', 'order' => 'sort_order'],
        'documents' => ['System\Models\File', 'order' => 'sort_order']
   ];

   public $belongsToMany = [
    'categories' => [
        'MoonWalkerz\Press\Models\Category',
        'table' => 'moonwalkerz_press_reviews_categories',
        'order' => 'title'
    ]
    ];
   public $belongsTo = [
    'newspaper' => [
        'MoonWalkerz\Press\Models\Newspaper',
        'key' => 'newspaper_id'
    ]
];

   
    /**
     * The attributes on which the post list can be ordered
     * @var array
     */
    public static $allowedSortingOptions = [
        'title asc' => 'Title (ascending)',
        'title desc' => 'Title (descending)',
        'created_at asc' => 'Created (ascending)',
        'created_at desc' => 'Created (descending)',
        'updated_at asc' => 'Updated (ascending)',
        'updated_at desc' => 'Updated (descending)',
        'published_at asc' => 'Published (ascending)',
        'published_at desc' => 'Published (descending)',
        'random' => 'Random'
    ];


     /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug,
        ];

        //expose published year, month and day as URL parameters
        if ($this->published) {
            $params['y'] = Carbon::parse($this->published_at)->format('Y');
            $params['m'] = Carbon::parse($this->published_at)->format('m');
            $params['d'] = Carbon::parse($this->published_at)->format('d');
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    
    /**
     * Used to test if a certain user has permission to edit post,
     * returns TRUE if the user is the owner or has other posts access.
     * @param User $user
     * @return bool
     */
    public function canEdit(User $user)
    {
        return ($this->user_id == $user->id) || $user->hasAnyAccess(['rainlab.blog.access_other_posts']);
    }


    //
    // Scopes
    //

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('published')
            ->where('published', true)
        ;
    }
            
    /**
     * Lists posts for the front end
     *
     * @param        $query
     * @param  array $options Display options
     *
     * @return Post
     */
    public function scopeListFrontEnd($query, $options)
    {
        
        /*
         * Default options
         */
        extract(array_merge([
            'page'       => 1,
            'perPage'    => 30,
            'sort'       => 'created_at',
            'search'     => '',
            'published'  => true,
            'exceptPost' => null,
        ], $options));

        $searchableFields = ['title', 'slug',  'content'];

        if ($published) {
            $query->isPublished();
        }

        /*
         * Sorting
         */
        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {

            if (in_array($_sort, array_keys(self::$allowedSortingOptions))) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                if ($sortField == 'random') {
                    $sortField = Db::raw('RAND()');
                }
                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }
//        $query->with('newspaper');

        return $query->paginate($perPage, $page);
    }


}

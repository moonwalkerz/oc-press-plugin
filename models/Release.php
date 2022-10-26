<?php

namespace MoonWalkerz\Press\Models;

use Db;
use Url;
use App;
use Str;
use Html;
use Lang;
use Model;
use Request;
use Redirect;
use Markdown;
use BackendAuth;
use ValidationException;
use Backend;
use Backend\Models\User;
use Carbon\Carbon;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;
use Log;
use MoonWalkerz\Press\Models\Tag;
use MoonWalkerz\Press\Models\Broadcast;

/**
 * Model
 */
class Release extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['published_at', 'published_until', 'deleted_at', 'created_at', 'updated_at','date_send'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'moonwalkerz_press_releases';

    protected $jsonable = ['tags_array', 'tags_array_id'];

    /*
     * Validation
     */
    public $rules = [
        'title' => 'required',
        'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:moonwalkerz_press_releases'],
        'content' => 'required'

    ];


    public $belongsToMany = [
        'categories' => [
            'MoonWalkerz\Press\Models\Category',
            'table' => 'moonwalkerz_press_releases_categories',
            'order' => 'title'
        ],
        'tags' => [
            //'MoonWalkerz\Press\Models\Tag',
            Tag::class,
            'table' => 'moonwalkerz_press_releases_tags',
            'key' => 'release_id',
            'otherKey' => 'tag_id'

        ]
    ];

    public $attachMany = [
        'images' => ['System\Models\File', 'order' => 'sort_order'],
        'documents' => ['System\Models\File', 'order' => 'sort_order']
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
        //     if ($this->published_at) {
        $params['y'] = $this->published_at->format('Y');
        $params['m'] = $this->published_at->format('m');
        $params['d'] = $this->published_at->format('d');
        //   }

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
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }


    public function afterSave()
    {
        parent::afterSave();

        if (Request::input('broadcast') == 1) {
        
            //ray("broadcast");
            //ray(Request::all()['Release']['_date_send']);
            
            $broadcast = new Broadcast();
            $broadcast->date = Request::all()['Release']['_date_send'];
            $broadcast->body = $this->excerpt;
            $broadcast->release_id = $this->id;
            $broadcast->subject = $this->title;
            $broadcast->save();
        }
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
            'skip'       => 0,
            'featured_only' => false,
            'categories'    => '',
            'sort'       => 'created_at',
            'search'     => '',
            'paginate'  => true,
            'published'  => true,
            'exceptPost' => null,
        ], $options));

        $searchableFields = ['title', 'slug',  'content'];

        //    if ($published) {
        $query->isPublished();
        //        }

        if ($featured_only) {
            $query->featured();
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
        * filter by categories
        */
        //dd($categories);
        if (!empty($categories) && !empty($categories[0])) {
            $query->whereHas('categories', function ($q) use ($categories) {

                //  dd($categories);
                $q->whereIn('slug', $categories);
            });
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }



        //if ($skip) {
        //}
        //Log::info('skip'.$skip." ".$query->paginate($perPage, $page)->toSql());
        //dd();
        if ($paginate) {

            return $query->paginate($perPage, $page);
        } else {
            $query->skip($skip);
            $query->take($perPage);

            //Log::info($query->toSql());
            return $query->get();
        }
    }

    //
    // Options
    //

    public function getTagsArrayOptions($value, $formData)
    {
        return Tag::all()->lists('name');
    }

    public function getTagsStringOptions($value, $formData)
    {
        return self::getTagsArrayOptions($value, $formData);
    }

    public function getTagsArrayIdOptions($value, $formData)
    {
        return Tag::all()->pluck('name', 'id')->toArray();
    }

    public function getTagsStringIdOptions($value, $formData)
    {
        return self::getTagsArrayIdOptions($value, $formData);
    }
}

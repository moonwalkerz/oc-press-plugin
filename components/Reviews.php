<?php namespace Moonwalkerz\Press\Components;

use Redirect;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use MoonWalkerz\Press\Models\Review as R;
use Log;

class Reviews extends ComponentBase
{
    public $reviews;

     /**
     * Message to display when there are no messages.
     * @var string
     */
    public $noReviewsMessage;
     /**
     * Reference to the page name for linking to posts.
     * @var string
     */
    public $reviewPage;

    public $pageParam;
     /**
     * If the post list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'moonwalkerz.press::lang.components.reviews.title',
            'description' => 'moonwalkerz.press::lang.components.reviews.description'
        ];
    }


    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'moonwalkerz.press::lang.settings.page_number',
                'description' => 'moonwalkerz.press::lang.settings.page_number_description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'reviewsPerPage' => [
                'title'             => 'moonwalkerz.press::lang.settings.reviews_per_page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'moonwalkerz.press::lang.settings.reviews_per_page_validation',
                'default'           => '10',
            ],
            'noReviewsMessage' => [
                'title'        => 'moonwalkerz.press::lang.settings.no_reviews',
                'description'  => 'moonwalkerz.press::lang.settings.no_reviews_description',
                'type'         => 'string',
                'default'      => 'No posts found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title'       => 'moonwalkerz.press::lang.settings.reviews_order',
                'description' => 'moonwalkerz.press::lang.settings.reviews_order_description',
                'type'        => 'dropdown',
                'default'     => 'published_at desc'
            ],
            'reviewPage' => [
                'title'       => 'moonwalkerz.press::lang.settings.review_page',
                'description' => 'moonwalkerz.press::lang.settings.review_page_description',
                'type'        => 'dropdown',
                'default'     => 'blog/post',
                'group'       => 'Links',
            ]
        ];
    }

    public function getReviewPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
 
    public function getSortOrderOptions()
    {
        return R::$allowedSortingOptions;
    }

    public function onRun()
    {        
        $this->prepareVars();
        $this->reviews = $this->page['reviews'] = $this->listReviews();
        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->reviews->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noReviewsMessage = $this->page['noReviewsMessage'] = $this->property('noReviewsMessage');

        /*
         * Page links
         */
        $this->reviewPage = $this->page['reviewPage'] = $this->property('reviewPage');
    }

    protected function listReviews()
    {
        //$lifestyle = $this->lifestyle ? $this->lifestyle->id : null;

        /*
         * List all the posts, eager load their lifestyles
         */
        $isPublished = !$this->checkEditor();

        $reviews = R::listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $this->property('sortOrder'),
            'perPage'    => $this->property('reviewsPerPage'),
            'search'     => trim(input('search')),
            'published'  => $isPublished
        ]);

        /*
         * Add a "url" helper attribute for linking to each post and lifestyle
         */
        $reviews->each(function($review) {
            $review->setUrl($this->reviewPage, $this->controller);
        });

        return $reviews;
    }
    
    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();
        return $backendUser && $backendUser->hasAccess('moonwalkerz.press.access_reviews');
    }
}

<?php namespace Moonwalkerz\Press\Components;

use Redirect;
use BackendAuth;
use Cms\Classes\ComponentBase;
use MoonWalkerz\Press\Models\Review as R;


class Review extends ComponentBase
{
    public $review;

    public function componentDetails()
    {
        return [
            'name'        => 'moonwalkerz.press::lang.components.review.title',
            'description' => 'moonwalkerz.press::lang.components.review.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'moonwalkerz.press::lang.settings.slug',
                'description' => 'moonwalkerz.press::lang.settings.slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'y' => [
                'title'       => 'moonwalkerz.press::lang.settings.y',
                'description' => 'moonwalkerz.press::lang.settings.y_description',
                'default'     => '{{ :y }}',
                'type'        => 'string'
            ],
            'm' => [
                'title'       => 'moonwalkerz.press::lang.settings.m',
                'description' => 'moonwalkerz.press::lang.settings.m_description',
                'default'     => '{{ :m }}',
                'type'        => 'string'
            ],
            'd' => [
                'title'       => 'moonwalkerz.press::lang.settings.d',
                'description' => 'moonwalkerz.press::lang.settings.d_description',
                'default'     => '{{ :d }}',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $review = $this->loadReview();
        if (!$review || !$review->exists) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
           }
    
        $this->review = $this->page['review'] = $review;
        $this->page['title'] = $review->title;
    }

    protected function loadReview()
    {
        $slug = $this->property('slug');
        $review = new R;
     //   $date= $this->property('y')."-".$this->property('m')."-".$this->property('d');

        
        $review = $review->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $review->transWhere('slug', $slug)
            : $review->where('slug', $slug);
        
   //     $review= $review->whereDate('created_at','=',date('y-m-d',$date));
        $review->whereDay('created_at', '=', $this->property('d'));
        $review->whereMonth('created_at', '=',$this->property('m'));
        $review->whereYear('created_at', '=', $this->property('y'));

        $sql =$review->toSql();

        if (!$this->checkEditor()) {
            $review = $review->isPublished();
        }
       
        $review = $review->first();
            
        return $review;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();
        return $backendUser && $backendUser->hasAccess('moonwalkerz.press.access_reviews');
    }


}

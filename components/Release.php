<?php namespace Moonwalkerz\Press\Components;

use Redirect;
use BackendAuth;
use Cms\Classes\ComponentBase;
use MoonWalkerz\Press\Models\Release as R;


class Release extends ComponentBase
{
    public $release;

    public function componentDetails()
    {
        return [
            'name'        => 'moonwalkerz.press::lang.components.release.title',
            'description' => 'moonwalkerz.press::lang.components.release.description'
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
        $release = $this->loadRelease();
        if (!$release || !$release->exists) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
           }
    
        $this->release = $this->page['release'] = $release;
        $this->page['title'] = $release->title;
    }

    protected function loadRelease()
    {
        $slug = $this->property('slug');
        $release = new R;
        $release = $release->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $release->transWhere('slug', $slug)
            : $release->where('slug', $slug);
        if (!$this->checkEditor()) {
            $release = $release->isPublished();
        }
        $release = $release->first();
        return $release;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();
        return $backendUser && $backendUser->hasAccess('moonwalkerz.press.access_releases');
    }


}

<?php namespace MoonWalkerz\Press;

use System\Classes\PluginBase;
use Log;
use MoonWalkerz\Press\Controllers\Broadcasts;

class Plugin extends PluginBase
{

    public function registerComponents()
    {
    	return [
                'MoonWalkerz\Press\Components\Reviews' => 'reviews',
                'MoonWalkerz\Press\Components\Review' => 'review',
                'MoonWalkerz\Press\Components\Releases' => 'releases',
                'MoonWalkerz\Press\Components\Release' => 'release'
    	];
    }

     /**
     * Registers any back-end settings.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'moonwalkerz.press::lang.plugin.name',
                'description' => 'moonwalkerz.press::lang.plugin.manage_settings',
                'category'    => 'system::lang.system.categories.cms',
                'icon'        => 'icon-newsparper-o',
                'class'       => 'MoonWalkerz\Press\Models\Settings',
                'order'       => 500,
                'keywords'    => 'search',
                'permissions' => ['moonwalkerz.press.manage_settings']
            ],
        ];
    }
    public function registerSchedule($schedule)
    {
        
        $schedule->call(function() {
            touch(storage_path('schedule.txt'));
            //Log::info('every minute');
            Broadcasts::send();
        })->everyMinute();
    }


    public function registerPermissions()
    {
        return [
            'moonwalkerz.press.access_releases' => [
                'label' => 'Access all releases',
                'tab' => 'Press',
                'order' => 200,
            ],
            'moonwalkerz.press.access_own_releases' => [
                'label' => 'Access own releases',
                'tab' => 'Press',
                'order' => 210,
            ],
            'moonwalkerz.press.access_group_releases' => [
                'label' => 'Access group releases',
                'tab' => 'Press',
                'order' => 220,
            ],
            'moonwalkerz.press.edit_releases' => [
                'label' => 'Edit the release',
                'tab' => 'Press',
                'order' => 230,
            ],
            'moonwalkerz.press.edit_own_releases' => [
                'label' => 'Edit own releases',
                'tab' => 'Press',
                'order' => 240,
            ],
            'moonwalkerz.press.edit_group_releases' => [
                'label' => 'Edit group releases',
                'tab' => 'Press',
                'order' => 250,
            ],

            'moonwalkerz.press.access_reviews' => [
                'label' => 'Access all reviews',
                'tab' => 'Press',
                'order' => 260,
            ],
            'moonwalkerz.press.access_own_reviews' => [
                'label' => 'Access own reviews',
                'tab' => 'Press',
                'order' => 270,
            ],
            'moonwalkerz.press.access_group_reviews' => [
                'label' => 'Access group reviews',
                'tab' => 'Press',
                'order' => 280,
            ],
            'moonwalkerz.press.edit_reviews' => [
                'label' => 'Edit the reviews',
                'tab' => 'Press',
                'order' => 290,
            ],
            'moonwalkerz.press.edit_own_reviews' => [
                'label' => 'Edit own reviews',
                'tab' => 'Press',
                'order' => 300,
            ],
            'moonwalkerz.press.edit_group_reviews' => [
                'label' => 'Edit group reviews',
                'tab' => 'Press',
                'order' => 310,
            ],
            'moonwalkerz.press.access_categories' => [
                'label' => 'Access Categories',
                'tab' => 'Press',
                'order' => 290,
            ],
            'moonwalkerz.press.access_tags' => [
                'label' => 'Access tags',
                'tab' => 'Press',
                'order' => 290,
            ],
            'moonwalkerz.press.access_newspapers' => [
                'label' => 'Access newspapers',
                'tab' => 'Press',
                'order' => 290,
            ],
            
        ];
    }
}

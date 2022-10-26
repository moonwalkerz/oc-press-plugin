<?php namespace MoonWalkerz\Press\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Event;

class Reviews extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'moonwalkerz.press.access_reviews',

    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('MoonWalkerz.Press', 'main-menu-item', 'side-menu-item2');
    }

    public function index()
    {
        parent::index();
        
        /*
        Event::listen('backend.filter.extendQuery', function (
            $filterWidget,
            $query,
            $scope
            ) {
          //  if ($scope->scopeName == 'status') {
                $query->where('id', '<', 4);
            //}
        });
        */
    }

}

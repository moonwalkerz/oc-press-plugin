<?php namespace MoonWalkerz\Press\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Categories extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController'
        ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    
    public $requiredPermissions = [
        'moonwalkerz.press.access_categories',
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('MoonWalkerz.Press', 'main-menu-item', 'side-menu-item3');
    }
}

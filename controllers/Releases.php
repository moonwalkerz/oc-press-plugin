<?php namespace MoonWalkerz\Press\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Backend;
use Request;
class Releases extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\FormController::class,
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'moonwalkerz.press.access_releases',
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('MoonWalkerz.Press', 'main-menu-item', 'side-menu-item');
    }

    public function update_onSave($context = null)
    {
        parent::update_onSave($context);

        if (Request::input('close') == 1) {
            return Backend::redirect("moonwalkerz/press/releases");
            }
        if (Request::input('broadcast') == 1) {
        return Backend::redirect("moonwalkerz/press/broadcasts");
        }
    }

    
}

<?php

namespace MoonWalkerz\Press\Controllers;

use Backend\Classes\Controller;

use Cms\Classes\Controller as C;
use BackendMenu;
use MoonWalkerz\Press\Models\Settings;
use MoonWalkerz\Press\Models\Broadcast;
use Telegram\Bot\Api;

class Broadcasts extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('MoonWalkerz.Press', 'main-menu-item', 'side-menu-broadcast');
    }

    public static function send()
    {
        $token = Settings::get('telegram_api');
        $releasePage = Settings::get('release_page');
        $broadcasts = Broadcast::query()->sendable()->get();


        if ($token) {
            if ($broadcasts->count() > 0) {
                foreach ($broadcasts as $broadcast) {
                    $r=$broadcast->release()->get()->first();

                    $params = [
                        'id'   => $r->id,
                        'slug' => $r->slug,
                    ];

                    //expose published year, month and day as URL parameters
                    //     if ($this->published_at) {
                    $params['y'] = $r->published_at->format('Y');
                    $params['m'] = $r->published_at->format('m');
                    $params['d'] = $r->published_at->format('d');
                    //   }
                    $controller = C::getController() ?: new C;

                    $url = $controller->pageUrl($releasePage, $params);

                    $telegram = new Api($token);
                    $msg = '<b>' . $broadcast->subject . "</b>";
                    $msg .= "\n\n";
                    $msg .= preg_replace('/<br(\s+)?\/?>/i', "\n", strip_tags(preg_replace('/<\/p(\s+)?>/i', "<br>", preg_replace('/<p(\s+)?>/i', "", $broadcast->body)), ['br', 'b', 'i', 'u', 'a', 's', 'code', 'pre']));
                    $msg .= "\n\n";
                    $msg .= '👉 <a href="'. $url.'">Più informazioni</a>';
                    $telegram->sendMessage([
                        'chat_id' => Settings::get('telegram_channel'),
                        'text' => $msg,
                        'parse_mode' => 'HTML',
                        'disable_web_page_preview' => 'true',
                        'no_webpage' => true
                    ]);
                    $broadcast->sent = 1;
                    $broadcast->save();
                }
            }
        };
        return;
    }

}

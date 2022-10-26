<?php
return [
    "components" => [
        "broadcast" => ["broadcasts" => "", "created_at" => "", "date" => "", "sent" => "", "subject" => ""],
        "release" => ["description" => "Single press release", "title" => "Release"],
        "releases" => ["description" => "Lista of releases", "title" => "Releases"],
        "review" => ["description" => "Single review", "title" => "Review"],
        "reviews" => ["description" => "Reviews list", "title" => "Reviews"]
    ],
    "form" => ["save_and_send" => "Save and send"],
    "lang" => [
        "components" => [
            "broadcast" => [
                "broadcasts" => "Transmissions",
                "created_at" => "Creation date",
                "date" => "Sending date",
                "message" => "Message",
                "sent" => "Sent?",
                "subject" => "Item"
            ]
        ]
    ],
    "plugin" => [
        "description" => "Press Releases and Reviews",
        "manage_settings" => "Managing settings for sending press releases",
        "name" => "Press"
    ],
    "settings" => [
        "categories" => "Categories",
        "categories_description" => "Categories filter or parameter",
        "d" => "Day",
        "d_description" => "Day parameter",
        "featured_only" => "Featured only",
        "m" => "Month",
        "m_description" => "Month parameter",
        "no_releases" => "No releases found at this time",
        "no_releases_description" => "Message when there is no releases",
        "page_number" => "Page number",
        "page_number_description" => "Page number or parameter",
        "paginate" => "Paginate?",
        "releases_order" => "Releases order",
        "releases_order_description" => "",
        "releases_per_page" => "Releases per page",
        "releases_per_page_description" => "Set how many releases per page",
        "skip" => "Skip",
        "skip_description" => "Skip first n releases",
        "skip_validation" => "",
        "slug" => "Slug",
        "slug_description" => "Search Url Alias",
        "telegram_api" => "Telegram API",
        "telegram_api_comment" => "Insert the full API token composed o key:password pair",
        "telegram_channel" => "Telegram Channel",
        "telegram_channel_comment" => "Input the name of the channel were messages are sent to",
        "y" => "Year",
        "y_description" => "Year parameter"
    ]
];

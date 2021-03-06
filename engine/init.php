<?php
    session_start();
    !empty(filter_input(INPUT_GET, 'lang')) ? define('__LANG', filter_input(INPUT_GET, 'lang')) : define('__LANG', 'ru');
    define('__ROOT', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/');
    define('__TEMPLATE', 'webmag');
    if (!empty(filter_input(INPUT_GET, 'module'))) {
        $modact = explode(':', filter_input(INPUT_GET, 'module'));
        if (!isset($modact[1])) {
            $modact[1] = 'index';
        }
    } else {
        $modact = ['news', 'index'];
    }
    define('__MODULE', $modact[0]);
    define('__ACTION', $modact[1]);
    require_once('./engine/dbconnect.class.php');
    require_once('./engine/rdset.class.php');
    require_once('./engine/main.class.php');
    require_once('./engine/localization.class.php');
    require_once('./engine/modules.class.php');
    require_once('./engine/components.class.php');
    require_once('./engine/tmp.class.php');
    require_once('./engine/permission.class.php');
    require_once('./engine/user.class.php');
    require_once('./engine/inputdata.class.php');

    $MODULES = [];
    $COMPONENTS = [];
    $SETTINGS = [
        "modules" => [
            "news", "logform", "pages"
        ],
        "components" => [
            "postingform", "pagenavigator", "comments"
        ]
    ];

    Main::readSettings();
    InputData::check();

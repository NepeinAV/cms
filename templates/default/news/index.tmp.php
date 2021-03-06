<!DOCTYPE html>
<html lang="ru">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>
            <?echo Modules::getModuleTitle();?>
        </title>
        <link rel="stylesheet" href="/templates/default/news/css/style.css" />
    </head>

    <body>
        <?echo Template::addTmp('header');?>
        <?echo Template::addTmp('menu');?>
        <div class="flex_c wrap">
            <main>
                <?global $USER; if ($USER->hasPermission('ADD_ARTICLES')): ?>
                    <a href="/news/add/">Добавить новость</a>
                <?endif;?>
                <?echo News::showArticles(false);?>
                <?echo Components::getComponent('index', 'pagenavigator', ['p_module' => 'news']);?>
            </main>
            <?print(Template::addTmp('aside', 'news'));?>
        </div>
    </body>

</html>
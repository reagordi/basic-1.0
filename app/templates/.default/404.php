<?php
use Reagordi\Framework\Web\Asset;

Reagordi::$app->context->setTitle( '404 Not Found' );
Reagordi::$app->context->setDescription( '404 Not Found' );
Reagordi::$app->context->setRobots( 'noindex,follow' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= Reagordi::getInstance()->getContext()->getHead() ?>
</head>
<body>
    <h1>Упс! Страница не найдена</h1>
    <h2>Эта страница не может быть найдена или отсутствует.</h2>
    <hr />
    <a href="<?= HOME_URL ?>"> На главную</a>
</body>
</html>
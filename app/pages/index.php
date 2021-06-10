<?php

/** @var $collector Phroute\Phroute\RouteCollector */

$collector->get(
  '',
  function () {
    Reagordi::$app->context->setTitle('Reagordi Basic');
    Reagordi::$app->context->setDescription('Reagordi Basic Demo');

    ob_start();

    ?>
<h1>Reagordi Basic</h1>
<a href="https://reagordi.com">go Reagordi site</a>
    <?php

    Reagordi::$app->context->view->assign('conteiner', ob_get_clean());

    return Reagordi::$app->context->view->fech();
  }
);

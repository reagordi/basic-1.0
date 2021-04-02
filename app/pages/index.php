<?php

/** @var $collector Phroute\Phroute\RouteCollector */

use Reagordi\Framework\Config\Config;
use Reagordi\Framework\Web\View;

$collector->get(
  '',
  function () {
    Reagordi::getInstance()->getContext()->setTitle('Reagordi Basic');
    Reagordi::getInstance()->getContext()->setDescription('Reagordi Basic Demo');

    ob_start();

    ?>
<h1>Reagordi Basic</h1>
<a href="https://reagordi.com">go Reagordi site</a>
    <?php

    View::getInstance()->assign('conteiner', ob_get_clean());

    return View::getInstance()->fech();
  }
);

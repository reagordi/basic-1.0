<?php
/**
 * Reagordi Framework
 *
 * @package reagordi
 * @author Sergej Rufov <support@freeun.ru>
 */

/**
 * Абсолютный путь до сайта
 *
 * @var string
 */
define('ROOT_DIR', str_replace('\\', '/', __DIR__));

if (is_file(ROOT_DIR . '/config.php')) {
  require_once ROOT_DIR . '/config.php';
}

/**
 * Путь до ядра reagordi
 *
 * @var string
 */
defined('VENDOR_DIR') or define('VENDOR_DIR', ROOT_DIR . '/vendor');

require_once VENDOR_DIR . '/autoload.php';
require_once VENDOR_DIR . '/reagordi/framework/reagordi.php';
require_once VENDOR_DIR . '/reagordi/framework/include.php';

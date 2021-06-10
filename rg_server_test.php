<?php
#####################################
define('LAST_MODIFIED','20.04.2020');
#####################################

ob_implicit_flush(true);

/**
 * Отладка скрипта
 *
 * @global
 * @var bool
 */
$debug = isset($_REQUEST['debug']) ? true: false;

/**
 * Абсолютный путь до директории сайта
 *
 * @var string
 */
define('ROOT_DIR', dirname(__FILE__));

/**
 * Разделитель директории
 *
 * @var string
 */
define('DS', DIRECTORY_SEPARATOR);

# Отладка
if ($debug) {
    // Время запуска скрипта
    $_SERVER['MLE_START_TIME'] = microtime(true);
    // Начальный занятое пространство ОЗУ
    $_SERVER['MLE_START_MEN'] = memory_get_usage();
    // Показ ошибок
    @error_reporting(E_ALL);
    @ini_set('error_reporting', E_ALL);
    @ini_set('html_errors', true);
    @ini_set('display_errors', true);
    @ini_set('display_startup_errors', true);
    // Логирование ошибок
    @error_log(ROOT_DIR.DS.'mle_php_error.log');
    @ini_set('error_log', ROOT_DIR.DS.'mle_php_error.log');
    @ini_set('log_errors', true);
} else {
    // Показ ошибок
    @error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
    @ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
    @ini_set('html_errors', false);
    @ini_set('display_errors', true);
    @ini_set('display_startup_errors', true);
    // Логирование ошибок
    @ini_set('log_errors', false);
}

// Время на выполнение скрипта
@set_time_limit(0);

// Установка внутренней кодировки в UTF-8
if (function_exists('mb_internal_encoding')) {
	mb_internal_encoding('UTF-8');
}

// Старт сессии
$sid = !empty($_REQUEST['sid']) ? $_REQUEST['sid']: null;
if ($sid) {
    session_id($sid);
}
session_start();
if (!$sid) {
    $sid = session_id();
}

/**
 * Минимальная версия PHP
 *
 * @var string
 */
define('PHP_MIN', '5.5.10');

/**
 * Минимальная версия MySQL
 *
 * @var string
 */
define('MYSQL_MIN', '5.0');

// Имя сервера
$_SERVER['SERVER_NAME'] = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
// ПОрт сервера
$_SERVER['SERVER_PORT'] = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 80;

// Язык системы
$lang = isset($_REQUEST['lang']) ? ($_REQUEST['lang'] == 'ru' ? 'ru': 'en'): (@preg_match('#ru#i', $_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'ru': 'en');

// Тип и кодировка страницы
header('Content-type:text/html; charset=utf-8');

// Переводы
$_MESSAGES = array();
if ($lang == 'en') {
    $_MESSAGES['LANG'] = 'en';
    $_MESSAGES['SELF_VERSION'] = 'Test version';
    $_MESSAGES['HOME'] = 'On the main';
	$_MESSAGES['TITLE'] = 'MediaLife Engine test server';
    $_MESSAGES['NA'] = 'Not defined';
    $_MESSAGES['WEB_SERVER'] = 'Version of the web server';
	$_MESSAGES['WEB_SERVER_DESC'] = 'Requires Apache 1.3.0 and higher or IIS 5.0 and higher';
	$_MESSAGES['SAPI'] = 'Php interface';
	$_MESSAGES['SAPI_DESC'] = 'It is recommended to run PHP as an Apache module, it is faster than CGI and gives more flexible settings';
	$_MESSAGES['PHP_VER'] = 'Version of PHP';
	$_MESSAGES['PHP_VER_DESC'] = 'Is required '.PHP_MIN;
	$_MESSAGES['SAFE_DESC'] = 'Safe_mode mode is not supported';
    $_MESSAGES['SHORT_TAG'] = 'The value of short_open_tag';
	$_MESSAGES['SHORT_TAG_DESC'] = 'short_open_tag=off is not supported';
	$_MESSAGES['MEM_LIMIT'] = 'Value memory_limit';
	$_MESSAGES['MEM_LIMIT_DESC'] = 'The memory limit must be at least 32 MB. We recommend disabling unused PHP modules in php.ini to increase the amount of memory available for applications.';
	$_MESSAGES['MEM_FACT'] = 'The actual memory limit';
	$_MESSAGES['MEM_FACT_DESC'] = 'Sometimes the actual memory limit may differ from php installations';
    $_MESSAGES['OPEN_RESULT'] = 'Open the test result';
    $_MESSAGES['NOT_TESTED'] = 'Not test';
    $_MESSAGES['YES'] = 'Yes';
	$_MESSAGES['NO'] = 'No';
	$_MESSAGES['TIME'] = 'Time';
    $_MESSAGES['SENDMAIL'] = 'Send mail';
	$_MESSAGES['SENDMAIL_DESC'] = 'Attempt to call the mail() function';
    $_MESSAGES['SOCK_TEST'] = 'Functions for working with sockets';
	$_MESSAGES['SOCK_TEST_DESC'] = 'Required for the update system to work';
    $_MESSAGES['TEST_SESS'] = 'Saving a session';
	$_MESSAGES['TEST_SESS_DESC'] = 'Required to save authorization';
	$_MESSAGES['TEST_SESS_UA'] = 'Saving sessions without UserAgent';
	$_MESSAGES['TEST_SESS_UA_DESC'] = 'It is necessary for applet multiple file upload and sharing';
    $_MESSAGES['NO_CONNECT'] = 'No connection';
    $_MESSAGES['SYSUPDATE'] = 'Update system';
	$_MESSAGES['SYSUPDATE_DESC'] = 'An attempt is being made to connect to the server api.mle-news.ru to port 443';
    $_MESSAGES['HTTP_AUTH'] = 'HTTP authorization';
    $_MESSAGES['HTTP_AUTH_DESC'] = 'Required for integration with MS Outlook. Connectionк <b>'.$_SERVER['HTTP_HOST'].'</b> on <b>'.$_SERVER['SERVER_PORT'].'</b> port';
    $_MESSAGES['TIME_TEST'] = 'Test of time';
	$_MESSAGES['TIME_TEST_DESC'] = 'Attempt to execute the script within 60 seconds';
    $_MESSAGES['TIME_TEST_CPU'] = 'Time test with CPU load';
	$_MESSAGES['TIME_TEST_CPU_DESC'] = 'In some cases scripts are disabled when the CPU load is exceeded';
    $_MESSAGES['PHP_ACC'] = 'Php accelerator';
	$_MESSAGES['PHP_ACC_DESC'] = 'We recommend that you have a PHP accelerator (APC, XCache, or any other one other than the deprecated EAccelerator). this allows you to reduce the CPU load several times and reduce the execution time of PHP code. It is desirable that the accelerator memory is sufficient to accommodate all frequently used PHP pages. We recommend installing filters, for example (for eA): eaccelerator.filter !*/admin/* */.*.php<br />If the accelerator is not detected, analysis is required <a href="'.$_SERVER['PHP_SELF'].'?phpinfo=y';
    if ($debug) {
        $_MESSAGES['PHP_ACC_DESC'] .= '&debug=y';
    }
    $_MESSAGES['PHP_ACC_DESC'] .= '">phpinfo()</a>';
    $_MESSAGES['MAX_INPUT_VARS'] = 'Must be at least 10000';
    $_MESSAGES['DATA_TIMEZONE_DESC'] = 'The time zone of the server';
    $_MESSAGES['EREGS'] = 'PHP regular expressions';
    $_MESSAGES['ZLIB_D'] = 'Required for the compression module to work and quickly download updates';
	$_MESSAGES['GDLIB'] = 'Displaying graphs in the statistics and working with images';
	$_MESSAGES['GDLIB_D'] = 'Required for CAPTCHA operation';
    $_MESSAGES['MCRYPT_TEST'] = 'Encryption modules';
    $_MESSAGES['MCRYPT_TEST_DESC'] = 'Required for encryption of information';
    $_MESSAGES['HASH_TEST'] = 'Hash Module';
    $_MESSAGES['CURL_DESC'] = 'Required to get responses from another server';
    $_MESSAGES['MYSQLI_CLASS_DESC'] = 'Required for working with MySQL databases';
    $_MESSAGES['POST_MS'] = 'Value post_max_size';
    $_MESSAGES['D_SPACE'] = 'Disk space';
	$_MESSAGES['D_SPACE_DESC'] = 'At least 500 MB';
    $_MESSAGES['F_PERM'] = 'Rights to the current folder';
    $_MESSAGES['F_CREATE'] = 'Create folder';
	$_MESSAGES['F_CREATE_DESC'] = 'Attempt to create a test folder';
	$_MESSAGES['F_NEW_PERM'] = 'Rights to the created folder';
	$_MESSAGES['F_DELETE'] = 'Delete a folder';
    $_MESSAGES['FL_CREATE'] = 'File creation';
	$_MESSAGES['FL_CREATE_D'] = 'Attempt to create a text file';
	$_MESSAGES['FL_PERM'] = 'Rights to the created file';
	$_MESSAGES['FL_DEL'] = 'File deletion';
	$_MESSAGES['FL_EXEC'] = 'Launch the created file';
	$_MESSAGES['FL_EXEC_D'] = 'In some cases, problems occur when running a file created using PHP';
    $_MESSAGES['HTACCESS'] = 'Processing .htaccess';
	$_MESSAGES['HTACCESS_D'] = 'An attempt is being made to configure processing of the 404th error in the newly created folder';
	$_MESSAGES['FILE_UPL'] = 'Value file_uploads';
    $_MESSAGES['IMG'] = 'Image';
	$_MESSAGES['IMG_D'] = 'When loading successfully, the image is displayed';
	$_MESSAGES['SETTINGS_TEST'] = 'Configuring the test';
	$_MESSAGES['ON_LOG'] = 'Enable debugging mode';
	$_MESSAGES['OFF_LOG'] = 'To turn off debug mode';
	$_MESSAGES['LOG_TEST'] = 'The test log';
	$_MESSAGES['LANGUAGES'] = 'Language';
	$_MESSAGES['SELECTS_TESTS'] = 'Select the tests';
    $_MESSAGES['GLOBAL_CONFIG'] = 'General configuration';
    $_MESSAGES['GLOBAL_FILES'] = 'File system test';
    $_MESSAGES['GLOBAL_PHP'] = 'PHP extension';
    $_MESSAGES['GLOBAL_CPU'] = 'CPU test';
    $_MESSAGES['GLOBAL_MYSQLI'] = 'MySQL Test';
    $_MESSAGES['GLOBAL_ADD'] = 'Additional information';
    $_MESSAGES['GLOBAL_CONF_MYSQLI'] = 'Configuration Of MySQL';
    $_MESSAGES['HOSTING_DB'] = 'DB hosting';
    $_MESSAGES['USERS_DB'] = 'DB user';
    $_MESSAGES['PASS_DB'] = 'The password database';
    $_MESSAGES['NAME_DB'] = 'The name of the database';
    $_MESSAGES['UPLOAD_IMAGE'] = 'Uploading an image';
    $_MESSAGES['SELECT_IMAGE'] = 'Selected image';
    $_MESSAGES['START_TESTING'] = 'To start testing';
    $_MESSAGES['TIMER_SCRIPTS'] = 'Time to execute the script';
    $_MESSAGES['START_PZU'] = 'The initial value of the RAM';
    $_MESSAGES['END_PZU'] = 'The final value RAM';
    $_MESSAGES['GET_VARS'] = 'Use variables';
    $_MESSAGES['WRITE_TIME_FILE'] = 'Writing to a file';
    $_MESSAGES['READ_TIME_FILE'] = 'Reading from a file';
    $_MESSAGES['DROP_TMP_TABLE'] = 'Deleting a test table';
    $_MESSAGES['SELECT_TMP_TABLE'] = 'Getting millions of rows';
    $_MESSAGES['SELECT_TMP_TABLE_DESC'] = 'Executing SELECT queries';
    $_MESSAGES['INSERT_TMP_TABLE'] = 'Creating millions of rows';
    $_MESSAGES['INSERT_TMP_TABLE_DESC'] = 'Executing INSERT queries';
    $_MESSAGES['CREATE_TMP_TABLE'] = 'Creating a test table';
    $_MESSAGES['TABLE_TEST'] = 'Test';
    $_MESSAGES['DB_BENCHMARK_TEST'] = 'Benchmark (million sinuses)';
    $_MESSAGES['DB_CONECT'] = 'Connecting to MySQL';
    $_MESSAGES['MLN_SIN'] = 'Million sinuses';
    $_MESSAGES['MLN_SIN_DESC'] = 'Performing the sin() function';
    $_MESSAGES['MLN_SCIN_TK'] = 'Number of line merges through a point';
    $_MESSAGES['MLN_SCIN_TK_DESC'] = 'The merger of the two lines';
    $_MESSAGES['MLN_SCIN_TKKV'] = 'Number of quoted string merges';
    $_MESSAGES['MLN_SCIN_TKKV_DESC'] = 'The merger of two quoted strings';
    $_MESSAGES['MLN_SCIN_ARRAY'] = 'How to merge rows through an array';
    $_MESSAGES['MLN_SCIN_ARRAY_DESC'] = 'The concatenation of the strings in an array';
    $_MESSAGES['URL_SITE'] = 'Server address';
    $_MESSAGES['DATABASE_NO_CONECT'] = 'Unable to connect to the database';
    $_MESSAGES['TEST_NO'] = 'Test skipped';
    $_MESSAGES['DB_INVALID_DATA'] = 'DB data is not entered and / or the mysqli class is missing';
    $_MESSAGES['NF1'] = 'I can\'t open the file (%file%) to write';
    $_MESSAGES['NF2'] = 'I can\'t write to a file (%file%)';
    $_MESSAGES['NF3'] = 'I can\'t open the file (%file%) for reading';
    $_MESSAGES['SEC'] = 'sec.';
    $_MESSAGES['SERVER_ANS'] = 'Server response';
    $_MESSAGES['LIMIT'] = 'limit:';
    $_MESSAGES['MYSQL_VER'] = 'MySQL server version';
    $_MESSAGES['MYSQL_REQ']='MySQL '.MYSQL_MIN.' and higher (No alpha or beta releases are allowed).'; 
    $_MESSAGES['SQL_MODE_DESC']='`STRICT*` modes are not supported';
} else {
    $_MESSAGES['LANG'] = 'ru';
    $_MESSAGES['SELF_VERSION'] = 'Версия теста';
    $_MESSAGES['HOME'] = 'На главную';
	$_MESSAGES['TITLE'] = 'Сервер-тест MediaLife Engine';
    $_MESSAGES['NA'] = 'Не определено';
    $_MESSAGES['WEB_SERVER'] = 'Версия веб-сервера';
	$_MESSAGES['WEB_SERVER_DESC'] = 'Требуется Apache 1.3.0 и выше или IIS 5.0 и выше';
	$_MESSAGES['SAPI'] = 'Интерфейс php';
	$_MESSAGES['SAPI_DESC'] = 'Рекомендуется запускать PHP как модуль Apache, это быстрее чем CGI и даёт более гибкие настройки';
	$_MESSAGES['PHP_VER'] = 'Версия php';
	$_MESSAGES['PHP_VER_DESC'] = 'Требуется '.PHP_MIN;
	$_MESSAGES['SAFE_DESC'] = 'Режим safe_mode не поддерживается';
    $_MESSAGES['SHORT_TAG'] = 'Значение short_open_tag';
	$_MESSAGES['SHORT_TAG_DESC'] = 'short_open_tag = off не поддерживается';
	$_MESSAGES['MEM_LIMIT'] = 'Значение memory_limit';
	$_MESSAGES['MEM_LIMIT_DESC'] = 'Ограничение памяти должно быть не ниже 32 Мб. Неиспользуемые PHP модули в php.ini желательно отключить чтобы увеличить размер памяти, доступной для приложений.';
	$_MESSAGES['MEM_FACT'] = 'Фактическое ограничение памяти';
	$_MESSAGES['MEM_FACT_DESC'] = 'Иногда фактическое ограничение памяти может отличаться от установок php';
    $_MESSAGES['OPEN_RESULT'] = 'Открыть результат теста';
    $_MESSAGES['NOT_TESTED'] = 'Не тестировалось';
    $_MESSAGES['YES'] = 'Да';
	$_MESSAGES['NO'] = 'Нет';
	$_MESSAGES['TIME'] = 'Время';
    $_MESSAGES['SENDMAIL'] = 'Отправка почты';
	$_MESSAGES['SENDMAIL_DESC'] = 'Попытка вызвать функцию mail()';
    $_MESSAGES['SOCK_TEST'] = 'Функции работы с сокетами';
	$_MESSAGES['SOCK_TEST_DESC'] = 'Необходимы для работы системы обновлений';
    $_MESSAGES['TEST_SESS'] = 'Сохранение сессии';
	$_MESSAGES['TEST_SESS_DESC'] = 'Необходимо для сохранения авторизации';
	$_MESSAGES['TEST_SESS_UA'] = 'Сохранение сессий без UserAgent';
	$_MESSAGES['TEST_SESS_UA_DESC'] = 'Необходимо для апплета множественной загрузки файлов и обмена';
    $_MESSAGES['NO_CONNECT'] = 'Нет подключения';
    $_MESSAGES['SYSUPDATE'] = 'Система обновлений';
	$_MESSAGES['SYSUPDATE_DESC'] = 'Осуществляется попытка подключиться к серверу api.mle-news.ru на порт 443';
    $_MESSAGES['HTTP_AUTH'] = 'HTTP авторизация';
    $_MESSAGES['HTTP_AUTH_DESC'] = 'Требуется для интеграцией с MS Outlook. Подключение к <b>'.$_SERVER['HTTP_HOST'].'</b> на <b>'.$_SERVER['SERVER_PORT'].'</b> порт';
    $_MESSAGES['TIME_TEST'] = 'Тест на время';
	$_MESSAGES['TIME_TEST_DESC'] = 'Попытка выполнять скрипт в течение 60 секунд';
    $_MESSAGES['TIME_TEST_CPU'] = 'Тест на время с нагрузкой на процессор';
	$_MESSAGES['TIME_TEST_CPU_DESC'] = 'В ряде случаев скрипты отключаются при превышении нагрузки на процессор';
    $_MESSAGES['PHP_ACC'] = 'Акселератор php';
	$_MESSAGES['PHP_ACC_DESC'] = 'Рекомендуется наличие акселератора PHP (APC, XCache или любого другого кроме устаревшего EAccelerator), это позволяет снизить нагрузку на CPU в несколько раз и уменьшить время выполнения PHP кода. Желательно, чтобы памяти акселератора было достаточно для размещения всех часто используемых PHP страниц. Рекомендуется установить фильтры, например (для eA): eaccelerator.filter !*/admin/* */.*.php<br />Если акселератор не обнаружен, требуется анализ <a href="'.$_SERVER['PHP_SELF'].'?phpinfo=y';
    if ($debug) {
        $_MESSAGES['PHP_ACC_DESC'] .= '&debug=y';
    }
    $_MESSAGES['PHP_ACC_DESC'] .= '">phpinfo()</a>';
    $_MESSAGES['MAX_INPUT_VARS'] = 'Должно быть не меньше 10000';
    $_MESSAGES['DATA_TIMEZONE_DESC'] = 'Временная зона сервера';
    $_MESSAGES['EREGS'] = 'Регулярные выражения PHP';
    $_MESSAGES['ZLIB_D'] = 'Требуется для работы модуля компрессии и быстрой загрузки обновлений';
	$_MESSAGES['GDLIB'] = 'Отображение графиков в статистике, работа с изображениями';
	$_MESSAGES['GDLIB_D'] = 'Необходима для работы CAPTCHA';
    $_MESSAGES['MCRYPT_TEST'] = 'Модули шифрования';
    $_MESSAGES['MCRYPT_TEST_DESC'] = 'Требуется для шифрования информации';
    $_MESSAGES['HASH_TEST'] = 'Модуль Hash';
    $_MESSAGES['CURL_DESC'] = 'Тредуется для получения ответов с другого сервера';
    $_MESSAGES['MYSQLI_CLASS_DESC'] = 'Тредуется для работы с БД MySQL';
    $_MESSAGES['POST_MS'] = 'Значение post_max_size';
    $_MESSAGES['D_SPACE'] = 'Место на диске';
	$_MESSAGES['D_SPACE_DESC'] = 'Не менее 500 Мб';
    $_MESSAGES['F_PERM'] = 'Права на текущую папку';
    $_MESSAGES['F_CREATE'] = 'Создание папки';
	$_MESSAGES['F_CREATE_DESC'] = 'Попытка создать тестовую папку';
	$_MESSAGES['F_NEW_PERM'] = 'Права на созданную папку';
	$_MESSAGES['F_DELETE'] = 'Удаление папки';
    $_MESSAGES['FL_CREATE'] = 'Создание файла';
	$_MESSAGES['FL_CREATE_D'] = 'Попытка создать тестовый файл';
	$_MESSAGES['FL_PERM'] = 'Права на созданный файл';
	$_MESSAGES['FL_DEL'] = 'Удаление файла';
	$_MESSAGES['FL_EXEC'] = 'Запуск созданного файла';
	$_MESSAGES['FL_EXEC_D'] = 'В ряде случаев возникают проблемы при запуске файла, созданного средствами PHP';
    $_MESSAGES['HTACCESS'] = 'Обработка .htaccess';
	$_MESSAGES['HTACCESS_D'] = 'Осуществляется попытка настроить обработку 404-й ошибки во вновь созданной папке';
	$_MESSAGES['FILE_UPL'] = 'Значение file_uploads';
    $_MESSAGES['IMG'] = 'Изображение';
	$_MESSAGES['IMG_D'] = 'При успешной загрузке отображается картинка';
	$_MESSAGES['SETTINGS_TEST'] = 'Настройка теста';
	$_MESSAGES['ON_LOG'] = 'Включить режим отладки';
	$_MESSAGES['OFF_LOG'] = 'Выключить режим отладки';
	$_MESSAGES['LOG_TEST'] = 'Журнал тестирования';
	$_MESSAGES['LANGUAGES'] = 'Язык';
	$_MESSAGES['SELECTS_TESTS'] = 'Выбирите тесты';
    $_MESSAGES['GLOBAL_CONFIG'] = 'Общая конфигурация';
    $_MESSAGES['GLOBAL_FILES'] = 'Тест файловой системы';
    $_MESSAGES['GLOBAL_PHP'] = 'Расширения php';
    $_MESSAGES['GLOBAL_CPU'] = 'Тест CPU';
    $_MESSAGES['GLOBAL_MYSQLI'] = 'Тест MySQL';
    $_MESSAGES['GLOBAL_ADD'] = 'Дополнительная информация';
    $_MESSAGES['GLOBAL_CONF_MYSQLI'] = 'Конфигурация MySQL';
    $_MESSAGES['HOSTING_DB'] = 'Хостинг БД';
    $_MESSAGES['USERS_DB'] = 'Пользователь БД';
    $_MESSAGES['PASS_DB'] = ' Пароль БД';
    $_MESSAGES['NAME_DB'] = ' Имя БД';
    $_MESSAGES['UPLOAD_IMAGE'] = 'Загрузка изображения';
    $_MESSAGES['SELECT_IMAGE'] = 'Выбирите изображение';
    $_MESSAGES['START_TESTING'] = 'Начать тестирование';
    $_MESSAGES['TIMER_SCRIPTS'] = 'Время на выполнение скрипта';
    $_MESSAGES['START_PZU'] = 'Начальное значение ОЗУ';
    $_MESSAGES['END_PZU'] = 'Конечное значение ОЗУ';
    $_MESSAGES['GET_VARS'] = 'Используемые переменные';
    $_MESSAGES['WRITE_TIME_FILE'] = 'Запись в файл';
    $_MESSAGES['READ_TIME_FILE'] = 'Чтение из файла';
    $_MESSAGES['DROP_TMP_TABLE'] = 'Удаление тестовой таблицы';
    $_MESSAGES['SELECT_TMP_TABLE'] = 'Получение млн. строк';
    $_MESSAGES['SELECT_TMP_TABLE_DESC'] = 'Выполнение запросов SELECT';
    $_MESSAGES['INSERT_TMP_TABLE'] = 'Создание млн. строк';
    $_MESSAGES['INSERT_TMP_TABLE_DESC'] = 'Выполнение запросов INSERT';
    $_MESSAGES['CREATE_TMP_TABLE'] = 'Создание тестовой таблицы';
    $_MESSAGES['TABLE_TEST'] = 'Тест';
    $_MESSAGES['DB_BENCHMARK_TEST'] = 'Benchmark (млн. синусов)';
    $_MESSAGES['DB_CONECT'] = 'Соединение с MySQL';
    $_MESSAGES['MLN_SIN'] = 'млн. синусов';
    $_MESSAGES['MLN_SIN_DESC'] = 'Выполнение функции sin()';
    $_MESSAGES['MLN_SCIN_TK'] = 'млн. слияний строк через точку';
    $_MESSAGES['MLN_SCIN_TK_DESC'] = 'Слияние двух строк';
    $_MESSAGES['MLN_SCIN_TKKV'] = 'млн. слияний строк в кавычках';
    $_MESSAGES['MLN_SCIN_TKKV_DESC'] = 'Слияние двух строк в кавычках';
    $_MESSAGES['MLN_SCIN_ARRAY'] = 'млн. слияний строк через массив';
    $_MESSAGES['MLN_SCIN_ARRAY_DESC'] = 'Слияние строк через массив';
    $_MESSAGES['URL_SITE'] = 'Адрес сервера';
    $_MESSAGES['DATABASE_NO_CONECT'] = 'Не удается соеденитьс с БД';
    $_MESSAGES['TEST_NO'] = 'Тест пропущен';
    $_MESSAGES['DB_INVALID_DATA'] = 'Данные об БД не введены и/или класс mysqli отсутствует';
    $_MESSAGES['NF1'] = 'Не могу открыть файл (%file%) на запись';
    $_MESSAGES['NF2'] = 'Не могу произвести запись в файл (%file%)';
    $_MESSAGES['NF3'] = 'Не могу открыть файл (%file%) на чтение';
    $_MESSAGES['SEC'] = 'сек.';
    $_MESSAGES['SERVER_ANS'] = 'Ответ сервера';
    $_MESSAGES['LIMIT'] = 'лимит:';
    $_MESSAGES['MYSQL_VER']="Версия MySQL сервера";
	$_MESSAGES['MYSQL_REQ']='Минимальные требования: '.MYSQL_MIN.' и выше. Альфа и бета версии не допускаются.';
    $_MESSAGES['SQL_MODE_DESC']='Режимы `STRICT*` не поддерживаются';
}

if (isset($_REQUEST['auth_test'])) { // Авторизация пользователя
    $_SERVER['REMOTE_USER'] = isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER']: null;
    $_SERVER['REDIRECT_REMOTE_USER'] = isset($_SERVER['REDIRECT_REMOTE_USER']) ? $_SERVER['REMOTE_USER']: null;
    $_SERVER['PHP_AUTH_USER'] = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER']: null;
    $_SERVER['PHP_AUTH_PW'] = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW']: null;
    $remote_user = $_SERVER['REMOTE_USER'] ? $_SERVER['REMOTE_USER']: $_SERVER['REDIRECT_REMOTE_USER'];
    $str_tmp = base64_decode(substr($remote_user, 6));
    if ($str_tmp) {
        list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', $str_tmp);
    }
    if ($_SERVER['PHP_AUTH_USER'] == 'test_user' && $_SERVER['PHP_AUTH_PW'] == 'test_password') {
        die('SUCCESS');
    } else {
        header('HTTP/1.x 401 Authorization required');
        header('WWW-Authenticate: Basic realm="Restricted area"');
        die('<h1>401 Authorization required</h1>');
    }
} elseif (isset($_REQUEST['session_test']))  {// Тест сессии
    if (isset($_SESSION['session_test']) && $_SESSION['session_test'] == 'ok') {
        die('SUCCESS');
    } else {
        die('Fault');
    }
} elseif (isset($_GET['image']) && isset($_GET['name']) && isset($_GET['type'])) { // Вывод картинки
    header('Content-type: image/'.$_GET['type']);
    $image_file = ROOT_DIR.DS.$_GET['name'];
    if (is_file($image_file)) {
        echo file_get_contents($image_file);
        @unlink($image_file);
    }
    die();
} elseif (isset($_REQUEST['phpinfo'])) { // PHPInfo
    date_default_timezone_set('UTC');
    ob_start();
    phpinfo();
    $php_info = ob_get_clean();
    preg_match_all('#<style[^>]*>(.*)</style>#siU', $php_info, $style);
    $style = preg_replace('#<table[^>]*>#', '<table class="table table-striped adminlist">', $style[1][0]);
    preg_match_all('#<body[^>]*>(.*)</body>#siU', $php_info, $output);
    $output = preg_replace('#<table[^>]*>#', '<table class="table table-striped adminlist">', $output[1][0]);
    echo '<!DOCTYPE html><html><head>';
    echo '<meta http-equiv="content-type" content="text/html;charset=utf-8" /><meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width" /><meta http-equiv="X-UA-Compatible" content="IE=edge" /><title>PHP info</title>';
    echo '<style>';
    echo $style;
    echo '</style></head><body>';
    echo '<div class="center"><a href="'.$_SERVER['PHP_SELF'].'?';
    if ($debug) {
        echo 'debug=1&';
    }
    echo 'lang='.$lang.'">'.__('HOME').'</a></div>';
    echo $output;
    echo '</body></html>';
    die();
} elseif (isset($_REQUEST['time_test'])) { // Тест времени
	@set_time_limit(0);
	@ini_set('max_execution_time', 0);
	$t = time();
	while (time() - $t < 60)  {
		if (isset($_GET['max_cpu'])) {
			date('Y-m-d H:i:s');
		} else {
			sleep(1);
        }
	}
	die('SUCCESS');
}   elseif (isset($_REQUEST['memory_test']))  { // Тест памяти
    $max = isset($_REQUEST['max']) ? intval($_REQUEST['max']): 256;
    if (!$max) {
        $max = 255;
    }
    for ($i = 1; $i <= $max; $i++) {
        $a[]=str_repeat(chr($i),1024*1024); // 1 Mb
    }
    die('SUCCESS');
}

/**
 * Отладка скрипта
 *
 * Создает журнал тестирования при включенной отладки.
 * Если передан только один параметр, то берём предыдущую
 * строку и помещает в журнал
 *
 * @param int $line Текущая строка
 * @param string $my_text Текст для логирования
 * @return void
 */
function debug($line, $my_text = '') {
    static $f, $fail, $file;
    global $debug;
    if (!$debug || $fail) {
        return;
    }
    if (!$f) {
		if ($f = fopen(ROOT_DIR.'/mle_server_test.log', 'a'))
			$file = @file(__FILE__);
		else
			$fail = 1;
	}
    if ($my_text) {
        $txt = $my_text;
    } else {
        $txt = str_replace('//', '', trim($file[$line - 2]));
    }
	fwrite($f, '['.date('d.m.Y H:i:s').'] '.$txt."\n");
}

/**
 * Показ данных
 *
 * @param string $title Название теста
 * @param string $desc Описание теста
 * @param string $value Значение теста
 * @param string $status Статус
 * @return void
 */
function show($title, $desc, $value, $status = '') {
    $s_text = '';
    if (is_bool($status) && $status === true) {
        $s_text = ' status_green';
    } elseif (is_bool($status) && $status === false) {
        $s_text = ' status_red';
    }
    $text = '<div ';
    $text .= 'class="pb_10">';
    $text .= '<div class="col_md">'.$title.':';
    if ($desc) {
        $text .= '<br /><span class="text_desc">'.$desc.'</span>';
    }
    $text .= '</div>';
    $text .= '<div class="col_md'.$s_text.'">'.$value.'</div>';
    $text .= '</div>';
    echo $text;
}

/**
 * Отправка запроса к другому серверу
 *
 * @param string $file URL путь
 * @param array $post_params массив POST параметров
 * @return string
 */
function http_get_contents($file, $post_params = false) {
    $data = false;
    if (stripos($file, 'http://') !== 0 and stripos($file, 'https://') !== 0) {
        return false;
    }
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file);
        if (is_array($post_params)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_params));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($data !== false) {
            return $data;
        }
    }
    if (preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'))) {
        if (is_array($post_params)) {
            $file .= '?'.http_build_query($post_params);
        }
        $data = @file_get_contents($file);
        if ($data !== false) {
            return $data;
        }
    }
    return false;
}

/**
 * Отправка данных через сокетами
 *
 * @param object $res экземпляр сокета
 * @param string $str_request параметры запроса
 * @return string
 */
function get_http_response($res, $str_request) {
    fputs($res, $str_request);
    $b_chunked = false;
    $length = 0;
    while (($line = fgets($res, 4096)) && $line != "\r\n") {
        if (@preg_match('/Transfer-Encoding: +chunked/i', $line)) {
            $b_chunked = true;
        } elseif (@preg_match('/Content-Length: +([0-9]+)/i', $line, $regs)) {
            $length = $regs[1];
        }
    }
    $str_res = '';
    if ($b_chunked) {
        $max_read_size = 4096;
        $length = 0;
        $line = fgets($res, $max_read_size);
        $line = StrToLower($line);
        $str_chunk_size = '';
        $i = 0;
        while ($i < StrLen($line) && in_array($line[$i], array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'))) {
            $str_chunk_size .= $line[$i];
            $i++;
        }
        $chunk_size = hexdec($str_chunk_size);
        while ($chunk_size > 0) {
            $processed_size = 0;
            $read_size = (($chunk_size > $max_read_size) ? $max_read_size : $chunk_size);
            while ($read_size > 0 && $line = fread($res, $read_size)) {
                $str_res .= $line;
                $processed_size += strlen($line);
                $new_size = $chunk_size - $processed_size;
                $read_size = (($new_size > $max_read_size) ? $max_read_size : $new_size);
            }
            $length += $chunk_size;
            $line = fgets($res, $max_read_size);
            $line = fgets($res, $max_read_size);
            $line = strtolower($line);
            $str_chunk_size = '';
            $i = 0;
            while ($i < strlen($line) && in_array($line[$i], array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'))) {
                $str_chunk_size .= $line[$i];
                $i++;
            }
            $chunk_size = hexdec($str_chunk_size);
        }
    } elseif ($length) {
        $str_res = fread($res, $length);
    } else {
        while ($line = fread($res, 4096)) {
            $str_res .= $line;
        }
    }
    return $str_res;
}

/**
 * Таймер определения затраченного времени
 *
 * @link http://www.eomy.net/forum/taimer-vt558.html
 * @param bool $shift Если ложь, то сбросить секундамер
 * @return float
 */
function timer($shift = false) {
    static $first = 0;
    static $last;

    $now = preg_replace('#^0(.*) (.*)$#', '$2$1', microtime());
    if (!$first) $first = $now;
    $res = $shift ? $now - $last : $now - $first;
    $last = $now;
    return round($res,6);
}

/**
 * Перевод размера файла с байта в Кб, Мб, Гб
 *
 * @param int $file_size размер файла
 * @return string
 */
function formatsize($file_size) {
    if (!$file_size OR $file_size < 1) {
        return '0 b';
    }
    $prefix = array('b', 'Kb', 'Mb', 'Gb', 'Tb');
    $exp = floor(log($file_size, 1024)) | 0;
    return round($file_size / (pow(1024, $exp)), 2).' '.$prefix[$exp];
}

/**
 * Информация о правах доступа
 *
 * @param string $dir Путь до директории или файла
 * @return string
 */
function dirinfo($dir) {
    if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
        $perm=substr(sprintf('%o', @fileperms($dir)), -4);
        $user=posix_getpwuid(fileowner($dir));
        $group=posix_getgrgid(filegroup($dir));
        return $perm." ".$user['name']." ".$group['name'];
    } else {
        return "N/A";
    }
}

/**
 * Создание директории и файлов для теста htaccess
 *
 * @return string имя директории
 */
function prepare_htaccess_test() {
    $dir = uniqid().'mle_server_test';
    $self = str_replace('\\', '/', dirname($_SERVER['PHP_SELF']));
	$path = $self.$dir;
    if (!is_dir(ROOT_DIR.DS.$dir)) {
        @mkdir(ROOT_DIR.DS.$dir, 0777);
    }
    if (!is_file(ROOT_DIR.DS.$dir.DS.'.htaccess')) {
        $f = @fopen(ROOT_DIR.DS.$dir.DS.'.htaccess','wb');
        if ($f) {
            $str = "ErrorDocument 404 ".$path."/404.php\n\n".
            "<IfModule mod_rewrite.c>\n".
            "	RewriteEngine Off\n".
            "</IfModule>";
            @fputs($f, $str);
            @fclose($f);
            @chmod(ROOT_DIR.DS.$dir.DS.'.htaccess', 0777);
        }
        $f = fopen(ROOT_DIR.DS.$dir.DS.'/404.php', 'wb');
        if ($f) {
            $str = "<?php\n".
            "header(\"HTTP/1.1 200 OK\");\n".
            "echo 'SUCCESS';\n";
            fputs($f, $str);
            fclose($f);
            @chmod(ROOT_DIR.DS.$dir.DS.'.htaccess', 0777);
        }
    }
    return $dir;
}

/**
 * Проверка загруженного файла
 *
 * @param array $file информация о файле
 * @return bool
 */
function is_security_file($file) {
    $name = $file['name'];
    $type = $file['type'];
    $size = $file['size'];
    if (
        $type != 'image/gif' &&
        $type != 'image/png' &&
        $type != 'image/jpg' &&
        $type != 'image/jpeg'
    ) {
        return false;
    }
    if ($size > 5 * 1024 * 1024) {
        return false;
    }
    return true;
}

/**
 * Возврат перевода
 *
 * @param string $name ключ перевода
 * @return string
 */
function __($name) {
    global $_MESSAGES;
    return isset($_MESSAGES[$name]) ? $_MESSAGES[$name]: $name;
}

/**
 * Вывод перевода
 *
 * @param string $name ключ перевода
 * @return void
 */
function _e($name) {
    echo __($name);
}
?>
<!DOCTYPE html>
<!-- last modified: <?php echo defined('LAST_MODIFIED') ? LAST_MODIFIED: date('d.m.Y H:i:s'); ?>  -->
<html lang="<?php _e('LANG'); ?>">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php _e('TITLE'); ?></title>
    <style>
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box
}

body {
    background-color: #edeef0;
    padding:0;
    margin: 0;
    color: #333;
    direction: ltr;
    font-size: 14px;
    font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;
    line-height: 1.154;
    font-weight: 400;
    -webkit-font-smoothing: subpixel-antialiased;
    -moz-osx-font-smoothing: auto;
}

img {
    border: 0;
    color: transparent;
}

a {
    color: #5d00c2;
    text-decoration: none
}

a:hover {
    text-decoration: underline
}

pre {
    margin-top: 0;
    margin-bottom: 1rem;
    overflow: auto;
    display: block;
    background-color: #edeef0;
    border-left: 1px solid #5d00c2;
    padding: 5px;
    color: #212529
}

.block {
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-top: 10px;
}

.block .head {
    font-size: 1.5rem;
    font-weight: 500;
    line-height: 1.2;
    border-bottom: 1px solid #ccc;
}

.block .head, .block .body {
    padding: 5px 10px;
}

.block .body table {
    width: 100%;
}

.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

@media (min-width: 768px) {
    .container {
        width: 750px;
    }
}

@media (min-width: 992px) {
    .container {
        width: 970px;
    }
}

@media (min-width: 1200px) {
    .container {
        width: 1170px;
    }
}

.col_md {
    position: relative;
    display: inline-block;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px
}

.block .body .col_md:first-child {
    font-weight: 700;
}

@media (min-width: 768px) {
    .col_md {
        -ms-flex: 0 0 49%;
        flex: 0 0 49%;
        max-width: 49%
    }
}

.pb_10 {
    padding-top: 10px;
    padding-bottom: 10px;
}

.pb_10:not(:last-child) {
    border-bottom: 1px solid #ccc;
}

.text_desc {
    color: #6c757d;
    font-size: 12px;
}

.status_red {
    color: red
}

.status_green {
    color: green
}

input {
    padding: 7px 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

label {
    cursor: pointer
}

label.col_md {
    padding-bottom: 10px
}

.fl_l {
    float: left
}

.fl_r {
    float: right
}

.clear {
    float: none;
    clear: both
}

.link_md {
    display: inline-block;
    margin-right: 10px;
    padding: 10px;
}

.ta_c {
    text-align: center
}

table th, table td {
    padding: 10px;
    border: 1px solid #ccc
}
    </style>
<script>
var last_mem = 8;
var max_success = 0;
var memory_errors = 5;
var absolute_max = 999;
var my_interval = 0;
var my_interval_cpu = 0;
var secund_test = 0;
var secund_test1 = 0;
var tmr = 70;
var tmr1 = 0;

function rand(mi, ma) { return Math.random() * (ma - mi + 1) + mi; }
function irand(mi, ma) { return Math.floor(rand(mi, ma)); }
function isUndefined(obj) { return typeof obj === 'undefined' };
function isFunction(obj) {return obj && Object.prototype.toString.call(obj) === '[object Function]'; }
function isArray(obj) { return Object.prototype.toString.call(obj) === '[object Array]'; }
function isString(obj) { return typeof obj === 'string'; }
function isObject(obj) { return Object.prototype.toString.call(obj) === '[object Object]'; }

//
//  Arrays, objects
//
function each(object, callback) {
  if (!isObject(object) && typeof object.length !== 'undefined') {
    for (var i = 0, length = object.length; i < length; i++) {
      var value = object[i];
      if (callback.call(value, i, value) === false) break;
    }
  } else {
    for (var name in object) {
      if (!Object.prototype.hasOwnProperty.call(object, name)) continue;
      if (callback.call(object[name], name, object[name]) === false)
        break;
    }
  }

  return object;
}

function indexOf(arr, value, from) {
  for (var i = from || 0, l = (arr || []).length; i < l; i++) {
    if (arr[i] == value) return i;
  }
  return -1;
}
function inArray(value, arr) {
  return indexOf(arr, value) != -1;
}

function ajx2q(qa, noSort) {
  var query = [], enc = function(str) {
    if (window._decodeEr && _decodeEr[str]) {
      return str;
    }
    try {
      return encodeURIComponent(str);
    } catch (e) { return ''; }
  };

  for (var key in qa) {
    if (qa[key] == null || isFunction(qa[key])) continue;
    if (isArray(qa[key])) {
      for (var i = 0, c = 0, l = qa[key].length; i < l; ++i) {
        if (qa[key][i] == null || isFunction(qa[key][i])) {
          continue;
        }
        query.push(enc(key) + '[' + c + ']=' + enc(qa[key][i]));
        ++c;
      }
    } else {
      query.push(enc(key) + '=' + enc(qa[key]));
    }
  }
  if (!noSort) query.sort();
  return query.join('&');
}

function NewXML() {
    try {
        xml = new XMLHttpRequest();
        xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xml.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    } catch(e) {
        try {
            xml = new ActiveXObject('Msxml2.XMLHTTP');
        } catch(e) {
            try {
                xml = new ActiveXObject('Microsoft.XMLHTTP');
            } catch(e) {}
        }
    }
    return xml;
}

function AjaxSend(xml, url, callback) {
    var q = (typeof(y) != 'string') ? ajx2q(url, false) : url;
    xml.open('POST', '<?php echo $_SERVER['PHP_SELF']; ?>?' + q, true);
    xml.send(q);
    if (null != callback) {
        xml.onreadystatechange = function ()  { 
            if (xml.readyState == 4 || xml.readyState == 'complete') {
                callback(xml.responseText);
            }
        }
    }
}

function memory_test(max_mem) {
    xml = NewXML();
    callback = function(a) {
        if (a == 'SUCCESS') {
            max_success = last_mem;
            last_mem *= 2;
            if (last_mem > absolute_max) {
                last_mem = parseInt((max_success + absolute_max) / 2);
            }
            if (max_success == last_mem) {
                memory_errors = 0;
                last_mem += 1;
            }
            if (max_success < 256) {
                document.getElementById('memory_limit').innerHTML = max_success + ' Mb ...';
                memory_test(last_mem - 1);
            } else {
                document.getElementById('memory_limit').innerHTML = '&gt;256 Mb';
                session_test();
            }
        } else if (memory_errors > 0) {
            absolute_max = last_mem;
            last_mem = parseInt((max_success + last_mem)/2);
            memory_test(last_mem - 1);
            memory_errors--;
        } else {
            link = " <a href='<?php echo $_SERVER['PHP_SELF']; ?>?memory_test=y&debug=y&max=" + last_mem + "' target=_blank title='<?php echo __('OPEN_RESULT')?>'>&gt;&gt;</a>";
            if (max_success== 0) {
                res = '<span class="status_red">N/A</span>' + link;
            } else {
                res = max_success + link;
            }
            document.getElementById('memory_limit').innerHTML = res;
            session_test();
        }
    }
    AjaxSend(xml, {memory_test: 'y', debug: 'y', max: max_mem, sid: '<?php echo $sid; ?>'}, callback);
}

function session_test() {
    // session test
    xml = NewXML();
    callback = function(a) {
        if (a == 'SUCCESS') {
            res = '<span class="status_green"><?php echo __('YES');?></span>';
        } else {
            res = '<span class="status_red"><?php echo __('NO');?></span>';
        }
        document.getElementById('session').innerHTML = res;
        time_test();
    }
    AjaxSend(xml, {session_test: 'y', debug: 'y', sid: '<?php echo $sid; ?>'},callback);
}

function time_test() {
    // time test
    xml = NewXML();
    callback = function(a)  {
        if (a == 'SUCCESS') {
            res = '<span class="status_green"><?php echo __('YES');?></span>';
        } else {
            res = '<span class="status_red"><?php echo __('NO');?></span> (<?php echo __('LIMIT');?> ' + tmr1 + ")  <a href='javascript:alert(\"" + escape(xml.responseText.substr(0,100)) + "\")' title='<?php echo __('SERVER_ANS');?>'>&gt;&gt;</a>";
        }
        document.getElementById('time_test').innerHTML = res;
        clearInterval(my_interval);
        time_cpu_test();
    }
    secund_test = 0;
    document.getElementById('time_test').innerHTML = secund_test + ' <?php _e('SEC'); ?>';
    AjaxSend(xml, {time_test: 'y', debug: 'y', sid: '<?php echo $sid; ?>'}, callback);
    my_interval = setInterval(time_testsecund, 1000);
}

function time_testsecund() {
    secund_test++;
    document.getElementById('time_test').innerHTML = secund_test + ' <?php _e('SEC'); ?>';
}

function time_cpu_test() {
    // time test
    xml = NewXML();
    callback = function(a)  {
        if (a == 'SUCCESS') {
            res = '<span class="status_green"><?php echo __('YES');?></span>';
        } else {
            res = '<span class="status_red"><?php echo __('NO');?></span> ' + "<a href='javascript:alert(\"" + escape(a.substr(0,100))  + "\")' title='<?php echo __('SERVER_ANS');?>'>&gt;&gt;</a>";
        }
        document.getElementById('time_test_cpu').innerHTML = res;
        clearInterval(my_interval_cpu);
    }
    AjaxSend(xml, {time_test: 'y', max_cpu: 'y', debug: 'y', sid: '<?php echo $sid; ?>'}, callback);
    secund_test1 = 0;
    document.getElementById('time_test_cpu').innerHTML = secund_test1 + ' <?php _e('SEC'); ?>';
    my_interval_cpu = setInterval(time_testcpusecund, 1000);
}

function time_testcpusecund() {
    secund_test1++;
    document.getElementById('time_test_cpu').innerHTML = secund_test1 + ' <?php _e('SEC'); ?>';
}

function run_test() {
    memory_test();
}
</script>
</head>
<body>
<?php
if (isset($_POST['test_run'])) {
    debug(__LINE__, '---------- '.__('TITLE').' ----------');
    $__v = defined('LAST_MODIFIED') ? LAST_MODIFIED: date('d.m.Y H:i:s');
    debug(__LINE__, __('SELF_VERSION').': '.$__v);
    unset($__v);
}
?>
    <div class="container">
        <div class="block" style="text-align: center;">
            <div class="head"><?php _e('TITLE'); ?></div>
            <div class="body">
                <?php if (!$debug) { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=<?php echo $lang; ?>" class="link_md"><?php _e('SETTINGS_TEST'); ?></a>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?debug=1&lang=<?php echo $lang; ?>" class="link_md"><?php _e('ON_LOG'); ?></a>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?phpinfo=y&lang=<?php echo $lang; ?>" class="link_md">phpinfo()</a>
                    <span><?php _e('LANGUAGES'); ?>:</span>
                    <?php if ($lang != 'ru') { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=ru" class="link_md">ru</a>
                    <?php } else { ?>
                    <span>ru</span>
                    <?php } ?>
                    <span>/</span>
                    <?php if ($lang != 'en') { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=en" class="link_md">en</a>
                    <?php } else { ?>
                    <span>en</span>
                    <?php } ?>
                <?php } else { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?debug=y&lang=<?php echo $lang; ?>" class="link_md"><?php _e('SETTINGS_TEST'); ?></a>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=<?php echo $lang; ?>" class="link_md"><?php _e('OFF_LOG'); ?></a>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?phpinfo=y&debug=y&lang=<?php echo $lang; ?>" class="link_md">phpinfo()</a>
                    <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>mle_server_test.log" target="_blank" class="link_md"><?php _e('LOG_TEST'); ?></a>
                    <span><?php _e('LANGUAGES'); ?>:</span>
                    <?php if ($lang != 'ru') { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?&debug=y&lang=ru" class="link_md">ru</a>
                    <?php } else { ?>
                    <span>ru</span>
                    <?php } ?>
                    <span>/</span>
                    <?php if ($lang != 'en') { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?&debug=y&lang=en" class="link_md">en</a>
                    <?php } else { ?>
                    <span>en</span>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
<?php if (!isset($_POST['test_run'])) { ?>
        <div class="block">
            <div class="body">
                <p><b><?php _e('SELECTS_TESTS'); ?>:</b></p>
                <form enctype="multipart/form-data" method="post">
                    <label class="col_md" style="font-weight:400;">
                        <input type="checkbox" name="conf_general" value="1" checked />
                        <span><?php _e('GLOBAL_CONFIG'); ?></span>
                    </label>
                    <label class="col_md">
                        <input type="checkbox" name="conf_cpu" value="1" checked />
                        <span><?php _e('GLOBAL_CPU'); ?></span>
                    </label>
                    <label class="col_md">
                        <input type="checkbox" name="conf_file" value="1" checked />
                        <span><?php _e('GLOBAL_FILES'); ?></span>
                    </label>
                    <label class="col_md">
                        <input type="checkbox" name="conf_mysql" value="1" checked />
                        <span><?php _e('GLOBAL_MYSQLI'); ?></span>
                    </label>
                    <label class="col_md">
                        <input type="checkbox" name="conf_php" value="1" checked />
                        <span><?php _e('GLOBAL_PHP'); ?></span>
                    </label>
                    <label class="col_md">
                        <input type="checkbox" name="conf_add" value="1" checked />
                        <span><?php _e('GLOBAL_ADD'); ?></span>
                    </label>
                    <p><b><?php _e('GLOBAL_CONF_MYSQLI'); ?>:</b></p>
                    <label>
                        <span class="col_md"><?php _e('HOSTING_DB'); ?>:</span>
                        <input type="text" name="db_host" class="col_md" placeholder="<?php _e('HOSTING_DB'); ?>" value="localhost" />
                    </label><br /><br />
                    <label>
                        <span class="col_md"><?php _e('USERS_DB'); ?>:</span>
                        <input type="text" name="db_user" class="col_md" placeholder="<?php _e('USERS_DB'); ?>" />
                    </label><br /><br />
                    <label>
                        <span class="col_md"><?php _e('PASS_DB'); ?>:</span>
                        <input type="text" name="db_pass" class="col_md" placeholder="<?php _e('PASS_DB'); ?>" />
                    </label><br /><br />
                    <label>
                        <span class="col_md"><?php _e('NAME_DB'); ?>:</span>
                        <input type="text" name="db_name" class="col_md" placeholder="<?php _e('NAME_DB'); ?>" />
                    </label><br /><br />
                    <p><b><?php _e('UPLOAD_IMAGE'); ?>:</b></p>
                    <label>
                        <span class="col_md"><?php _e('SELECT_IMAGE'); ?>:</span>
                        <input type="file" name="test_file" class="col_md" accept="image/*" />
                    </label><br /><br />
                    <input type="submit" name="test_run" class="fl_r" value="<?php _e('START_TESTING'); ?>" />
                    <div class="clear"></div>
                </form>
            </div>
        </div>
<?php } else { ?>
            <div class="block">
                <div class="head"><?php _e('GLOBAL_CONFIG'); ?></div>
                <div class="body">
<?php
if (isset($_POST['conf_general'])) {
    debug(__LINE__, '===== '.__('GLOBAL_CONFIG').' =====');
    // Вывод адреса сервера
    $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
    debug(__LINE__, __('URL_SITE').': '.$url);
    show(__('URL_SITE'), '', $url);
    unset($url);

    // Версия веб-сервера
    $str_server_software = $_SERVER['SERVER_SOFTWARE'];
    if (strlen($str_server_software) <= 0) {
        $str_server_software = $_SERVER['SERVER_SIGNATURE'];
    }
    $str_server_software = trim($str_server_software);
    if (@preg_match('#^([a-zA-Z-]+).*?([\d]+\.[\d]+(\.[\d]+)?)#i', $str_server_software, $ar_server_software)) {
        unset($str_server_software);
        $str_web_server = isset($ar_server_software[1]) ? $ar_server_software[1]: '';
        $str_web_server_version = isset($ar_server_software[2]) ? $ar_server_software[2]: '';
        unset($ar_server_software);
        $version_server = $str_web_server.' '.$str_web_server_version;
    } else {
        $version_server = __('NA');
    }
    debug(__LINE__, __('WEB_SERVER').': '.$version_server);
    show(__('WEB_SERVER'), __('WEB_SERVER_DESC'), $version_server);
    unset($version_server);
    //########### Версия веб-сервера #############

    // Интерфейс php
    $sapi = strtolower(php_sapi_name());
    debug(__LINE__, __('SAPI').': '.$sapi);
    show(__('SAPI'), __('SAPI_DESC'), $sapi, $sapi != 'cgi');
    unset($sapi);

    // Версия PHP
    debug(__LINE__, __('PHP_VER').': '.phpversion());
    show(__('PHP_VER'), __('PHP_VER_DESC'), phpversion(), !version_compare(phpversion(), PHP_MIN, '<'));

    // Safe mode
    $val = intval(ini_get('safe_mode'));
    $txt = $val ? __('YES'): __('NO');
    $vs = $val ? false: true;
    debug(__LINE__, 'Safe mode: '.$txt);
    show('Safe mode', __('SAFE_DESC'), $txt, $vs);
    unset($val, $txt, $vs);

    // short_open_tag
    $val = ini_get("short_open_tag") == 1 || strtoupper(ini_get("short_open_tag")) == 'ON';
    $txt = $val ? __('YES'): __('NO');
    debug(__LINE__, __('SHORT_TAG').': '.$txt);
    show(__('SHORT_TAG'), __('SHORT_TAG_DESC'), $txt, $val);
    unset($txt, $val);

    // Memory limit
    $val = ini_get('memory_limit') ? ini_get('memory_limit'): get_cfg_var('memory_limit');
    debug(__LINE__, __('MEM_LIMIT').': '.$val);
    show(__('MEM_LIMIT'), __('MEM_LIMIT_DESC'), $val);
    
    // Test memory limit
    debug(__LINE__, __('MEM_FACT'));
    show(__('MEM_FACT'), __('MEM_FACT_DESC'), '<span id="memory_limit">'.__('NOT_TESTED').'</span>');
    
    // Mail()
    $t = time();
	$val = mail('hosting_test@mle-news.ru', 'MediaLife server test', 'This is test message. Delete it.');
	$tt = time() - $t;
    debug(__LINE__, __('SENDMAIL').': '.($val ? __('YES'): __('NO')).($tt ? ' ('.__('TIME').': '.$tt.' '.__('SEC').')': ''));
    show(__('SENDMAIL'), __('SENDMAIL_DESC'), ($val ? __('YES'): __('NO')).($tt ? ' ('.__('TIME').': '.$tt.' '.__('SEC').')': ''), $val || $tt < 1);
    unset($t, $val, $tt);
    
    // socket
    $val = $socket = function_exists('fsockopen');
    $txt = $val ? __('YES'): __('NO');
    debug(__LINE__, __('SOCK_TEST').': '.$txt);
    show(__('SOCK_TEST'), __('SOCK_TEST_DESC'), $txt, $val);
    unset($txt, $val);
    
    // Session data
    debug(__LINE__, __('TEST_SESS'));
    $_SESSION['session_test'] = 'ok';
    show(__('TEST_SESS'), __('TEST_SESS_DESC'), '<div id="session">'.__('NOT_TESTED').'</div>');
    session_write_close();
    
    // Session without UserAgent test: for upload applet
    $ok = false;
    $str_res = http_get_contents($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?debug=y&session_test=y&sid='.$sid);
    if($str_res === false)  {
        $val = __('NO_CONNECT');
    } elseif (trim($str_res) == 'SUCCESS') {
        $val = __('YES');
        $ok = true;
    } else {
        $val = __('NO');
    }
    debug(__LINE__, __('TEST_SESS_UA').': '.$val);
    show(__('TEST_SESS_UA'), __('TEST_SESS_UA_DESC'), $val, $ok);
    unset($ok, $str_res, $val);
    
    
    // Update system
    $ok = false;
    $str_res = http_get_contents('https://api.mle-news.ru/mle_server_test');
    if ($str_res === false) {
        $val = __('NO_CONNECT');
    } elseif (trim($str_res) == 'Server available') {
        $val = __('YES');
        $ok = true;
    } else {
        $val = __('NO');
    }
    debug(__LINE__, __('SYSUPDATE').': '.$val);
    show(__('SYSUPDATE'), __('SYSUPDATE_DESC'), $val, $ok);
    unset($val, $ok, $str_res);
    
    // HTTP Auth
    $ok = false;
    $host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
    $port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 80;
    if ($socket) {
		$res = @fsockopen(($port == 443 ? 'ssl://' : '').$host, $port, $errno, $errstr, 3);
	} else {
		$res = false;
    }
    if($res)  {
		$url = parse_url($_SERVER['REQUEST_URI']);
		$str_request = 'GET '.$url['path']."?debug=y&auth_test=Y HTTP/1.1\r\n";
		$str_request.= 'Host: '.$host."\r\n";
		$str_request.= "Authorization: Basic dGVzdF91c2VyOnRlc3RfcGFzc3dvcmQ=\r\n";
		$str_request.= "\r\n";

		$str_res = get_http_response($res, $str_request);
		fclose($res);

		if (trim($str_res) == 'SUCCESS')
		{
            $ok = true;
			$val = __('YES');
			if (isset($_SERVER['REMOTE_USER'])) {
				$val .= ' ($_SERVER["REMOTE_USER"])';
			} elseif (isset($_SERVER['REDIRECT_REMOTE_USER'])) {
				$val .= ' ($_SERVER["REDIRECT_REMOTE_USER"])';
            }
		} else {
			$val = __('NO');
        }
	}  else {
		$val = __('NO_CONNECT');
    }
    debug(__LINE__, __('HTTP_AUTH').': '.$val);
    show(__('HTTP_AUTH'), __('HTTP_AUTH_DESC'), $val , $ok);
    unset($ok, $val, $host, $port, $socket, $res, $errno, $errstr, $url, $str_request, $str_res);
    
    // Set time limit
    debug(__LINE__, __('TIME_TEST'));
    show(__('TIME_TEST'), __('TIME_TEST_DESC'), '<div id="time_test">'.__('NOT_TESTED').'</div>');
    
    // Set time limit CPU
    debug(__LINE__, __('TIME_TEST_CPU'));
    show(__('TIME_TEST_CPU'), __('TIME_TEST_CPU_DESC'), '<div id="time_test_cpu">'.__('NOT_TESTED').'</div>');
    
    // Accelerator
    $res = '';
    if ($val = function_exists('eaccelerator_info'))  {
        $res = 'EAccelerator';
        $val = false;
    } elseif($val = function_exists('accelerator_reset')) {
        $res = 'Zend Accelerator';
        $val = false;
    } elseif($val = function_exists('apc_fetch')) {
        $res = 'APC';
    } elseif($val = function_exists('xcache_get')) {
        $res = 'XCache';
    } elseif(($val = function_exists('opcache_reset')) && ini_get('opcache.enable')) {
        $res = 'OPcache';
    }
    debug(__LINE__, __('PHP_ACC').': '.$res ? __('YES').' ('.$res.')': __('NOT_FOUND'));
    show(__('PHP_ACC'), __('PHP_ACC_DESC'), $res ? __('YES').' ('.$res.')': __('NOT_FOUND'), $val);
    unset($res, $val);
    
    // max_input_vars
    if ($m = ini_get('max_input_vars')) {
        debug(__LINE__, 'max_input_vars: '.$m);
        show('max_input_vars', __('MAX_INPUT_VARS'), $m, $m >= 10000);
    }
    unset($m);
    
    // Timezone
    $val = @ini_get('date.timezone');
    $val2 = @date_default_timezone_get();
    debug(__LINE__, 'data.timezone: '.$val2);
    show('data.timezone', __('DATA_TIMEZONE_DESC'), (empty($val) && empty($val2)) ? __('NO'): $val2, (empty($val) && empty($val2)) ? false: true);
    unset($val, $val2);
} else {
    echo '<p>'.__('TEST_NO').'</p>';
}
?>
            </div>
        </div>
        <div class="block">
            <div class="head"><?php _e('GLOBAL_PHP'); ?></div>
            <div class="body">
<?php
if (isset($_POST['conf_php'])) {
    debug(__LINE__, '===== '.__('GLOBAL_PHP').' =====');
    // Regex functions
    $val = function_exists('preg_match');
    debug(__LINE__, __('EREGS').': '.$val);
    show(__('EREGS'), '', $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // Zlib
    $val = extension_loaded('zlib') && function_exists('gzcompress');
    debug(__LINE__, 'Zlib extension: '.$val);
    show('Zlib extension', __('ZLIB_D'), $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // GD lib
    $val = function_exists('imagecreate');
    debug(__LINE__, 'GD lib extension: '.$val);
    show('GD lib extension', __('GDLIB'), $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // Free type
    $val = function_exists('imagettftext');
    debug(__LINE__, 'Free Type extension: '.$val);
    show('Free Type extension', __('GDLIB_D'), $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // Mcrypt
    $val = function_exists('mcrypt_encrypt') ? 'mcrypt' : (function_exists('openssl_encrypt') ? 'openssl' : '');
    debug(__LINE__, __('MCRYPT_TEST').': '.$val);
    show(__('MCRYPT_TEST'), __('MCRYPT_TEST_DESC'), $val, $val ? true: false);
    unset($val);
    
    // Hash
    $val = function_exists('hash');
    debug(__LINE__, __('HASH_TEST').': '.$val);
    show(__('HASH_TEST'), __('MCRYPT_TEST_DESC'), $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // XML
    $val = function_exists('xml_parser_create');
    debug(__LINE__, 'XML: '. $val);
    show('XML', '', $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // JSON
    $val = function_exists('json_encode');
    debug(__LINE__, 'JSON: '. $val);
    show('JSON', '', $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // curl
    $val = function_exists('curl_init');
    debug(__LINE__, 'cURL: '. $val);
    show('cURL', __('CURL_DESC'), $val ? __('YES'): __('NO'), $val);
    unset($val);
    
    // class Mysqli
    $val = class_exists('mysqli');
    debug(__LINE__, 'Class MySQLi: '. $val);
    show('Class MySQLi', __('MYSQLI_CLASS_DESC'), $val ? __('YES'): __('NO'), $val);
    unset($val);
} else {
    echo '<p>'.__('TEST_NO').'</p>';
}
?>
            </div>
        </div>
        <div class="block">
            <div class="head"><?php _e('GLOBAL_CPU'); ?></div>
            <div class="body">
<?php
if (isset($_POST['conf_cpu'])) {
    debug(__LINE__, '===== '.__('GLOBAL_CPU').' =====');
    $a = $b = $c = null;
    timer();
    // Test Sunus
    for ($i = 1; $i < 1000000; $i++) {
        $a = sin($i);
    }
    $str = timer(1);
    debug(__LINE__, __('MLN_SIN').': '.$str.' '.__('SEC'));
    show(__('MLN_SIN'), __('MLN_SIN_DESC'), $str.' '.__('SEC'));
    
    // Test млн. слияний строк через точку
    for ($i = 0; $i < 1000000; $i++) {
        $a = $a + $i;
        $c = $a.$i;
    }
    $str = timer(1);
    debug(__LINE__, __('MLN_SCIN_TK').': '.$str.' '.__('SEC'));
    show(__('MLN_SCIN_TK'), __('MLN_SCIN_TK_DESC'), $str.' '.__('SEC'));
    
    // Test млн. слияний строк в кавычках
    for ($i = 0; $i < 1000000; $i++) {
        $a = $a + $i;
        $c = "$a$i";
    }
    $str = timer(1);
    debug(__LINE__, __('MLN_SCIN_TKKV').': '.$str.' '.__('SEC'));
    show(__('MLN_SCIN_TKKV'), __('MLN_SCIN_TKKV_DESC'), $str.' '.__('SEC'));
    
    // Test млн. слияний строк через массив
    for ($i = 0; $i < 1000000; $i++) {
        $a = $a + $i;
        implode('', array($a, $i));
    }
    $str = timer(1);
    debug(__LINE__, __('MLN_SCIN_ARRAY').': '.$str.' '.__('SEC'));
    show(__('MLN_SCIN_ARRAY'), __('MLN_SCIN_ARRAY_DESC'), $str.' '.__('SEC'));
} else {
    echo '<p>'.__('TEST_NO').'</p>';
}
?>
            </div>
        </div>
        <div class="block">
            <div class="head"><?php _e('GLOBAL_MYSQLI'); ?></div>
            <div class="body">
<?php
if (isset($_POST['conf_mysql'])) {
    debug(__LINE__, '===== '.__('GLOBAL_MYSQLI').' =====');
    $db_host = isset($_POST['db_host']) ? $_POST['db_host']: null;
    $db_user = isset($_POST['db_user']) ? $_POST['db_user']: null;
    $db_pass = isset($_POST['db_pass']) ? $_POST['db_pass']: '';
    $db_name = isset($_POST['db_name']) ? $_POST['db_name']: null;
    $db = null;
    if (class_exists('mysqli') && $db_host && $db_user && $db_name) {
        timer();
        $db = @new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($db->connect_errno) {
            echo '<p>'.__('DATABASE_NO_CONECT').'</p>';
        } else {
            $db->set_charset('utf-8');
            
            $str = timer(1);
            debug(__LINE__, __('DB_CONECT').': '.$str.' '.__('SEC'));
            show(__('DB_CONECT'), '', $str.' '.__('SEC'));
            
            // DB version_compare
            $db_version = preg_replace( '/[^0-9.].*/', '', $db->get_server_info());
            debug(__LINE__, __('MYSQL_VER').': '.$db_version);
            show(__('MYSQL_VER'), __('MYSQL_REQ'), $db_version, version_compare($db_version, MYSQL_MIN, '>'));
            
            // sql_mode
            $res = $db->query("SHOW VARIABLES LIKE 'sql_mode'");
            while ($f = $res->fetch_row()) {
                debug(__LINE__, $f[0].': '.$f[1]);
                show($f[0], __('SQL_MODE_DESC'), '<div style="    overflow: auto;">'.$f[1].'</div>', @preg_match('#strict#i', $f[1]) ? false: true);
            }
            
            // Charset
            $res = $db->query("SHOW VARIABLES LIKE 'character\_set\_%'");
            while ($f = $res->fetch_row()) {
                debug(__LINE__, $f[0].': '.$f[1]);
                show($f[0], '', $f[1]);
            }

            // BENCHMARK
            timer();
            $db->query("SELECT BENCHMARK(1000000, (select sin(100)))");
            $str = timer(1);
            debug(__LINE__, __('DB_BENCHMARK_TEST').': '.$str.' '.__('SEC'));
            show(__('DB_BENCHMARK_TEST'), '', $str.' '.__('SEC'));
            
            // Create table MyISAM
            timer();
            $db->query("DROP TABLE IF EXISTS `mle_server_test`");
            $db->query("CREATE TABLE `mle_server_test`(`a` INT(11) NOT NULL DEFAULT '0', `b` VARCHAR(255) NOT NULL DEFAULT '', `c` VARCHAR(255) NOT NULL DEFAULT '', `d` VARCHAR(255) NOT NULL DEFAULT '',`e` VARCHAR(255) NOT NULL DEFAULT '') COLLATE='utf8_general_ci' ENGINE=MyISAM;");
            $time_create_myisam = timer(1);
            debug(__LINE__, __('CREATE_TMP_TABLE').' (MyISAM): '.$time_create_myisam.' '.__('SEC'));
            
            // Insetr data MyISAM
            timer();
            for ($i = 1; $i <= 10000; $i++) {
                $db->query("INSERT INTO `mle_server_test` (`a`, `b`, `c`, `d`, `e`) VALUES ('".$i."', 'test1', 'test2', 'test3', 'test4')");
            }
            $time_insert_myisam = timer(1);
            debug(__LINE__, __('INSERT_TMP_TABLE').' (MyISAM): '.$time_insert_myisam.' '.__('SEC'));
            
            // Select data MyISAM
            timer();
            $db->query('SELECT * FROM `mle_server_test`');
            $time_select_myisam = timer(1);
            debug(__LINE__, __('SELECT_TMP_TABLE').' (MyISAM): '.$time_select_myisam.' '.__('SEC'));
            
            // Drop table MyISAM
            timer();
            $db->query('DROP TABLE IF EXISTS `mle_server_test`');
            $time_drop_myisam = timer(1);
            debug(__LINE__, __('DROP_TMP_TABLE').' (MyISAM): '.$time_drop_myisam.' '.__('SEC'));
            
            // Create table InnoDB
            timer();
            $db->query("DROP TABLE IF EXISTS `mle_server_test`");
            $db->query("CREATE TABLE `mle_server_test`(`a` INT(11) NOT NULL DEFAULT '0', `b` VARCHAR(255) NOT NULL DEFAULT '', `c` VARCHAR(255) NOT NULL DEFAULT '', `d` VARCHAR(255) NOT NULL DEFAULT '',`e` VARCHAR(255) NOT NULL DEFAULT '') COLLATE='utf8_general_ci' ENGINE=InnoDB;");
            $time_create_innodb = timer(1);
            debug(__LINE__, __('CREATE_TMP_TABLE').' (InnoDB): '.$time_create_innodb.' '.__('SEC'));
            
            // Insetr data InnoDB
            timer();
            for ($i = 1; $i <= 10000; $i++) {
                $db->query("INSERT INTO `mle_server_test` (`a`, `b`, `c`, `d`, `e`) VALUES ('".$i."', 'test1', 'test2', 'test3', 'test4')");
            }
            $time_insert_innodb = timer(1);
            debug(__LINE__, __('INSERT_TMP_TABLE').' (InnoDB): '.$time_insert_innodb.' '.__('SEC'));
            
            // Select data InnoDB
            timer();
            $db->query('SELECT * FROM `mle_server_test`');
            $time_select_innodb = timer(1);
            debug(__LINE__, __('SELECT_TMP_TABLE').' (InnoDB): '.$time_select_innodb.' '.__('SEC'));
            
            // Drop table InnoDB
            timer();
            $db->query('DROP TABLE IF EXISTS `mle_server_test`');
            $time_drop_innodb = timer(1);
            debug(__LINE__, __('DROP_TMP_TABLE').' (InnoDB): '.$time_drop_innodb.' '.__('SEC'));
            ?>
<br />
<table style="width: 100%;">
    <thead>
        <tr>
            <th><?php _e('TABLE_TEST'); ?></th>
            <th>InnoDB</th>
            <th>MyISAM</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php _e('CREATE_TMP_TABLE'); ?>:</td>
            <td class="ta_c"><?php echo $time_create_innodb; ?> <?php _e('SEC'); ?></td>
            <td class="ta_c"><?php echo $time_create_myisam; ?> <?php _e('SEC'); ?></td>
        </tr>
        <tr>
            <td><?php _e('INSERT_TMP_TABLE'); ?>:<br /><span class="text_desc"><?php _e('INSERT_TMP_TABLE_DESC'); ?></span></td>
            <td class="ta_c"><?php echo $time_insert_innodb; ?> <?php _e('SEC'); ?></td>
            <td class="ta_c"><?php echo $time_insert_myisam; ?> <?php _e('SEC'); ?></td>
        </tr>
        <tr>
            <td><?php _e('SELECT_TMP_TABLE'); ?>:<br /><span class="text_desc"><?php _e('SELECT_TMP_TABLE_DESC'); ?></span></td>
            <td class="ta_c"><?php echo $time_select_innodb; ?> <?php _e('SEC'); ?></td>
            <td class="ta_c"><?php echo $time_select_myisam; ?> <?php _e('SEC'); ?></td>
        </tr>
        <tr>
            <td><?php _e('DROP_TMP_TABLE'); ?>:</td>
            <td class="ta_c"><?php echo $time_drop_innodb; ?> <?php _e('SEC'); ?></td>
            <td class="ta_c"><?php echo $time_drop_myisam; ?> <?php _e('SEC'); ?></td>
        </tr>
    </tbody>
</table>
            <?php
        }
    } else {
        echo '<p>'.__('DB_INVALID_DATA').'</p>';
    }
} else {
    echo '<p>'.__('TEST_NO').'</p>';
}
?>
            </div>
        </div>
        <div class="block">
            <div class="head"><?php _e('GLOBAL_FILES'); ?></div>
            <div class="body">
<?php
if (isset($_POST['conf_file'])) {
    debug(__LINE__, '===== '.__('GLOBAL_FILES').' =====');
    // Free space
    $val = @disk_free_space($_SERVER['DOCUMENT_ROOT']);
    $_min_space = 500 * 1024 * 1024;
    debug(__LINE__, __('D_SPACE').': '.formatsize($val));
    show(__('D_SPACE'), __('D_SPACE_DESC'), formatsize($val), $val >= $_min_space);
    
    // dirinfo
    debug(__LINE__, __('F_PERM').': '.dirinfo('.'));
    show(__('F_PERM'), '', dirinfo('.'));
    
    // Folder create
    $dir_name = uniqid();
    $dir_name = ROOT_DIR.DS.$dir_name.'_mle_server_test';
    if (!file_exists($dir_name)) {
        $dir = mkdir($dir_name);
    }
    debug(__LINE__, __('F_CREATE').': '.$dir);
    show(__('F_CREATE'), __('F_CREATE_DESC'), $dir ? __('YES'): __('ERROR'), $dir);
    
    if ($dir) {
        // dirinfo
        debug(__LINE__, __('F_NEW_PERM').': '.dirinfo($dir_name));
        show(__('F_NEW_PERM'), '', dirinfo($dir_name));
        
        // Folder delete
        $val = rmdir($dir_name);
        debug(__LINE__, __('F_DELETE').': '.$val);
        show(__('F_DELETE'), '', $val ? __('YES'): __('ERROR'), $val);
        unset($val, $dir);
    }
    
    // File create
    $filename = ROOT_DIR.DS;
    $filename .= uniqid().'mle_server_test.txt';
    if (!fopen($filename, 'w')) {
        debug(__LINE__, __('FL_CREATE').': '.__('ERROR'));
        show(__('FL_CREATE'), __('FL_CREATE_D'), __('ERROR'), false);
    } else {
        debug(__LINE__, __('FL_CREATE').': '.__('YES'));
        show(__('FL_CREATE'), __('FL_CREATE_D'), __('YES'), true);
        // dirinfo
        debug(__LINE__, __('FL_PERM').': '.dirinfo($filename));
        show(__('FL_PERM'), '', dirinfo($filename));
        
        // File delete
        $del = @unlink($filename);
        debug(__LINE__, __('FL_DEL').': '.$del);
        show(__('FL_DEL'), '', $del ? __('YES'): __('ERROR'), $del);
        unset($del);
    }
    unset($filename);
    
    // File exec
    $dir = ROOT_DIR.DS;
    $filename = uniqid().'mle_server_test_exex.php';
    if (!is_file($dir.$filename)) {
        $f = fopen($dir.$filename, 'wb');
        $data = "<?php\n"; 
        $data .= "echo \"SUCCESS\";\n";
        fputs($f, $data);
        fclose($f);
        @chmod($dir.$filename, 0777);
    }
    $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])).$filename;
    $data = http_get_contents($url);
    if ($data === false) {
        debug(__LINE__, __('FL_EXEC').': '.__('NO_CONNECT'));
        show(__('FL_EXEC'), __('FL_EXEC_D'), __('NO_CONNECT'), false);
    } elseif ($data == 'SUCCESS') {
        debug(__LINE__, __('FL_EXEC').': '.__('YES'));
        show(__('FL_EXEC'), __('FL_EXEC_D'), __('YES'), true);
    } else {
        debug(__LINE__, __('FL_EXEC').': '.__('NO'));
        show(__('FL_EXEC'), __('FL_EXEC_D'), __('NO'), false);
    }
    @unlink($dir.$filename);
    unset($dir, $filename, $f, $data, $url);
    
    // .htaccess
    $dir = prepare_htaccess_test();
    $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])).$dir.'/test_file.php';
    $data = http_get_contents($url);
    if ($data === false) {
        debug(__LINE__, __('HTACCESS').': '.__('NO_CONNECT'));
        show(__('HTACCESS'), __('HTACCESS_D'), __('NO_CONNECT'), false);
    } elseif ($data == 'SUCCESS') {
        debug(__LINE__, __('HTACCESS').': '.__('YES'));
        show(__('HTACCESS'), __('HTACCESS_D'), __('YES'), true);
    } else {
        debug(__LINE__, __('HTACCESS').': '.__('NO'));
        show(__('HTACCESS'), __('HTACCESS_D'), __('NO'), false);
    }
    @unlink(ROOT_DIR.DS.$dir.DS.'.htaccess');
    @unlink(ROOT_DIR.DS.$dir.DS.'404.php');
    @rmdir(ROOT_DIR.DS.$dir.DS);
    unset($dir, $data, $url);

    // Тест скорость записи, чтения
    $filename = ROOT_DIR.DS;
    $filename .= uniqid().'mle_server_test.txt';
    if (!$handle = fopen($filename, 'w')) {
        echo '<p>'.str_replace('%file%', $filename, __('NF1')).'</p>';
    } else {
        // File write
        timer();
        for ($i = 1; $i <= 1000000; $i++) {
            if (fwrite($handle, '1') === false) {
                echo '<p>'.str_replace('%file%', $filename, __('NF2')).'</p>';
            }
        }  
        fclose($handle);
        @chmod($filename, 0777);
        $str = timer(1);
        debug(__LINE__, __('WRITE_TIME_FILE').': '.$str.' '.__('SEC'));
        show(__('WRITE_TIME_FILE'), '', $str.' '.__('SEC'));
        
        // File read
        timer();
        if (!$handle = fopen($filename, 'r'))  {
            echo '<p>'.str_replace('%file%', $filename, __('NF3')).'</p>';
        }
        while (!feof($handle)) {
            fread($handle, 1); // читаем по 1 байту
        }  
        fclose($handle);
        @unlink($filename);
        $str = timer(1);
        debug(__LINE__, __('READ_TIME_FILE').': '.$str.' '.__('SEC'));
        show(__('READ_TIME_FILE'), '', $str.' '.__('SEC'));
    }
    //############## Тест скорость записи, чтения ######
    
    // File uploads
    $val = ini_get('file_uploads');
    debug(__LINE__, __('FILE_UPL').': '.$val);
    show(__('FILE_UPL'), '', $val ? __('YES'): __('NO'), $val ? true: false);
    
    // File uploads and view
    if (
        isset($_FILES['test_file']) &&
        is_uploaded_file($_FILES['test_file']['tmp_name']) &&
        is_security_file($_FILES['test_file'])
    ) {
        $type = substr($_FILES['test_file']['type'], strlen('image/'));
        $name = uniqid();
        $var = @move_uploaded_file($_FILES['test_file']['tmp_name'], ROOT_DIR.DS.$name.'.'.$type);
        if ($var) {
            debug(__LINE__, __('IMG').': '.__('YES'));
            echo '<div class="pb_10"><div class="col_md">'.__('IMG').'<br /><span class="text_desc">'.__('IMG_D').'</span></div><div class="col_md"><img src="'.str_replace('\\', '/', $_SERVER['PHP_SELF']).'?image=y&name='.$name.'.'.$type.'&type='.$type.'" width="200px" /></div></div>';
        }
    }
} else {
    echo '<p>'.__('TEST_NO').'</p>';
}
?>
            </div>
        </div>
        <div class="block">
            <div class="head"><?php _e('GLOBAL_ADD'); ?></div>
            <div class="body">
<?php
if (isset($_POST['conf_add'])) {
    debug(__LINE__, '===== '.__('GLOBAL_ADD').' =====');
    // Umask
    debug(__LINE__, 'umask: '.umask());
    show('umask', '', umask() ? __('YES'): __('NO'));

    //post_max_size
    debug(__LINE__, __('POST_MS').': '.ini_get('post_max_size'));
    show(__('POST_MS'), '', ini_get('post_max_size'));

    // Display errors
    debug(__LINE__, 'Display errors: '.ini_get('display_errors'));
    show('Display errors', '', ini_get('display_errors') ? __('YES'): __('NO')); 

    // Server time
    debug(__LINE__, 'Server time: '.date('d.m.Y H:i:s'));
    show('Server time', '', date('d.m.Y H:i:s'));
} else {
    echo '<p>'.__('TEST_NO').'</p>';
}
?>
            </div>
        </div>
<?php } ?>
        <div class="block pb_10" style="margin-bottom: 10px;">
            <?php if ($debug) { ?>
                <?php
                if (isset($_POST['test_run'])) {
                    $__t = microtime(true) - $_SERVER['MLE_START_TIME'];
                    debug(__LINE__, __('TIMER_SCRIPTS').': '.$__t.' '.__('SEC')."\n");
                    unset($__t);
                }
                ?>
                <p style="text-align: left;"><b><?php _e('TIMER_SCRIPTS'); ?>:</b> <?php echo microtime(true) - $_SERVER['MLE_START_TIME']; ?> <?php _e('SEC'); ?></p>
                    <?php if (function_exists('memory_get_peak_usage')) { ?>
                    <p style="text-align: left;"><b><?php _e('START_PZU'); ?>:</b> <?php echo formatsize($_SERVER['MLE_START_MEN']); ?></p>
                    <p style="text-align: left;"><b><?php _e('END_PZU'); ?>:</b> <?php echo formatsize(memory_get_peak_usage()); ?></p>
                <?php } ?>
                <p style="text-align: left;"><b><?php _e('GET_VARS'); ?>:</b> <pre style="height: 300px;text-align: left;"><?php print_r(get_defined_vars()); ?></pre></p>
            <?php } ?>
            <p class="fl_l">2019 - <?php echo date('Y'); ?> &copy; <a href="https://mle-news.ru/" target="_blank">MediaLife</a></p>
            <p class="fl_r"><b><?php _e('SELF_VERSION'); ?>:</b>
            <?php echo defined('LAST_MODIFIED') ? LAST_MODIFIED: date('d.m.Y H:i:s'); ?></p>
            <div class="clear"></div>
        </div>
    </div>
    <?php if (isset($_POST['conf_general'])) { ?>
    <script>run_test();</script>
    <?php } ?>
</body>
</html>
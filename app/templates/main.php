<?php

use Reagordi\Framework\Web\Asset;

if ( !Reagordi::$app->context->request->isAjaxRequest() ):
?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <?= Reagordi::$app->context->getHead() ?>
</head>
<body>
<?php endif ?>
<?php if ( isset($conteiner) ): ?>
    <?= $conteiner ?>
<?php else: ?>
    <br />
    <p style="color: red">Данная страница удаленна или ещё не созданна</p>
<?php endif ?>
<?php if ( !Reagordi::$app->context->request->isAjaxRequest() ): ?>
</body>
</html>
<?php endif ?>
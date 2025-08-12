<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\web\View;
use Idleberg\ViteManifest\Manifest;

/** @var string $content */
/** @var View $this */

if (!YII_ENV_PROD) {
    $this->registerJs(<<<'EOT'
        window.addEventListener("message", (event) => {
            if (event.data?.action === 'pageRefresh') {
                window.location.reload(true);
            }
        })
    EOT, View::POS_HEAD);
}
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title><?= Html::encode($this->title); ?></title>
    <?php if (YII_ENV_DEV): ?>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/resources/main.js"></script>
    <?php else: 
        // Use basePath to construct the correct path to web directory
        $manifestPath = Yii::getAlias('@app/web/resources/dist/manifest.json');
        $vm = new Manifest($manifestPath, Yii::getAlias('@web/resources/dist/'));
        $entrypoint = $vm->getEntrypoint("resources/main.js", false);
        
        if ($entrypoint) {
            ["url" => $url, "hash" => $hash] = $entrypoint;
            if ($hash) {
                echo "<script type='module' src='$url' crossorigin integrity='$hash'></script>" . PHP_EOL;
            } else {
                echo "<script type='module' src='$url' crossorigin></script>" . PHP_EOL;
            }
        }
        
        foreach ($vm->getImports("resources/main.js", false) as $import) {
            ["url" => $url] = $import;
            echo "<link rel='modulepreload' href='$url' />" . PHP_EOL;
        }
        
        foreach ($vm->getStyles("resources/main.js", false) as $style) {
            ["url" => $url, "hash" => $hash] = $style;
            if ($hash) {
                echo "<link rel='stylesheet' href='$url' crossorigin integrity='$hash' />" . PHP_EOL;
            } else {
                echo "<link rel='stylesheet' href='$url' crossorigin />" . PHP_EOL;
            }
        }
    endif;
    ?>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<header class="bg-gray-200 p-5">
  
</header>

<main role="main">
    <div class="container mx-auto p-5 my-5">
        <?= $content; ?>
    </div>
</main>

<footer class="border bg-gray-200 p-5">
    <div class="container">
        <div>&copy; My Company <?= date('Y'); ?> | <a href="/sitemap">Sitemap</a> | <a href="/search">Search</a></div>
    </div>
</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

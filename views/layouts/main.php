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
        $uri = Url::base(true) . '/resources/dist/';
        $vm = new Manifest($manifestPath, $uri, ':manifest:');
        $entrypoint = $vm->getEntrypoint('main.js');
        if ($entrypoint) {
            ['url' => $url, 'hash' => $hash] = $entrypoint;
            echo "<script type=\"module\" src=\"$url\" crossorigin integrity=\"$hash\"></script>" . PHP_EOL;
        }
        foreach ($vm->getImports('main.js') as $import) {
            ['url' => $url, 'hash' => $hash] = $import;
            echo "<link rel=\"modulepreload\" href=\"$url\" integrity=\"$hash\"  />" . PHP_EOL;
        }
        foreach ($vm->getStyles('main.css') as $style) {
            ['url' => $url, 'hash' => $hash] = $style;
            echo "<link rel=\"stylesheet\" href=\"$url\" crossorigin integrity=\"$hash\" />" . PHP_EOL;
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

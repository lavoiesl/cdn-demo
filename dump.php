<?php

require 'vendor/autoload.php';
require 'vendor/leafo/lessphp/lessc.inc.php';

use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Asset\AssetReference;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\Yui;
use Assetic\Filter\LessphpFilter;
use Assetic\Asset\AssetCache;
use Assetic\Cache\FilesystemCache;


$am = new AssetManager;

$less = new LessphpFilter;
$css = new Yui\CssCompressorFilter(__DIR__ . '/vendor/yui/yuicompressor/build/yuicompressor-2.4.7.jar');
$js = new Yui\JsCompressorFilter(__DIR__ . '/vendor/yui/yuicompressor/build/yuicompressor-2.4.7.jar');


$am->set('jqueryjs', new FileAsset(__DIR__ . '/vendor/jquery/jquery-compiled/jquery-1.8.2.min.js'));

$dir = __DIR__ . '/vendor/jquery/jquery-ui/ui';
$am->set('uicorejs', new AssetCollection(array(
    new FileAsset("$dir/jquery.ui.core.js"),
    new FileAsset("$dir/jquery.ui.widget.js"),
    new FileAsset("$dir/jquery.ui.mouse.js"),
    new FileAsset("$dir/jquery.ui.position.js"),
), array($js)));

$am->set('uihalfjs', new AssetCollection(array(
    new FileAsset("$dir/jquery.ui.draggable.js"),
    new FileAsset("$dir/jquery.ui.resizable.js"),
    new FileAsset("$dir/jquery.ui.dialog.js"),
    new FileAsset("$dir/jquery.ui.datepicker.js"),
), array($js)));

$am->set('uiextrajs', new AssetCollection(array(
    new FileAsset("$dir/jquery.ui.effect.js"),
    new GlobAsset("$dir/jquery.ui.effect-*.js"),
    new FileAsset("$dir/jquery.ui.button.js"),
    new FileAsset("$dir/jquery.ui.droppable.js"),
    new FileAsset("$dir/jquery.ui.accordion.js"),
    new FileAsset("$dir/jquery.ui.autocomplete.js"),
    new FileAsset("$dir/jquery.ui.menu.js"),
    new FileAsset("$dir/jquery.ui.progressbar.js"),
    new FileAsset("$dir/jquery.ui.selectable.js"),
    new FileAsset("$dir/jquery.ui.sortable.js"),
    new FileAsset("$dir/jquery.ui.slider.js"),
    new FileAsset("$dir/jquery.ui.spinner.js"),
    new FileAsset("$dir/jquery.ui.tabs.js"),
    new FileAsset("$dir/jquery.ui.tooltip.js"),
), array($js)));

$am->set('uii18njs', new AssetCollection(array(
    new GlobAsset("$dir/i18n/*.js"),
), array($js)));

$dir = __DIR__ . '/vendor/jquery/jquery-ui/themes/base';
$am->set('uicorecss', new AssetCollection(array(
    new FileAsset("$dir/jquery.ui.core.css"),
    new FileAsset("$dir/jquery.ui.theme.css"),
), array($css)));

$am->set('uihalfcss', new AssetCollection(array(
    new FileAsset("$dir/jquery.ui.resizable.css"),
    new FileAsset("$dir/jquery.ui.dialog.css"),
    new FileAsset("$dir/jquery.ui.datepicker.css"),
), array($css)));

$am->set('uiextracss', new AssetCollection(array(
    new FileAsset("$dir/jquery.ui.accordion.css"),
    new FileAsset("$dir/jquery.ui.autocomplete.css"),
    new FileAsset("$dir/jquery.ui.button.css"),
    new FileAsset("$dir/jquery.ui.menu.css"),
    new FileAsset("$dir/jquery.ui.progressbar.css"),
    new FileAsset("$dir/jquery.ui.selectable.css"),
    new FileAsset("$dir/jquery.ui.slider.css"),
    new FileAsset("$dir/jquery.ui.spinner.css"),
    new FileAsset("$dir/jquery.ui.tabs.css"),
    new FileAsset("$dir/jquery.ui.tooltip.css"),
), array($css)));

$dir = __DIR__ . '/vendor/twitter/bootstrap/js';
$am->set('bootstraphalfjs', new AssetCollection(array(
    new FileAsset("$dir/bootstrap-alert.js"),
    new FileAsset("$dir/bootstrap-button.js"),
    new FileAsset("$dir/bootstrap-modal.js"),
    new FileAsset("$dir/bootstrap-tooltip.js"),
    new FileAsset("$dir/bootstrap-tab.js"),
), array($js)));

$am->set('bootstrapextrajs', new AssetCollection(array(
    new FileAsset("$dir/bootstrap-carousel.js"),
    new FileAsset("$dir/bootstrap-collapse.js"),
    new FileAsset("$dir/bootstrap-dropdown.js"),
    new FileAsset("$dir/bootstrap-popover.js"),
    new FileAsset("$dir/bootstrap-scrollspy.js"),
    new FileAsset("$dir/bootstrap-transition.js"),
    new FileAsset("$dir/bootstrap-typeahead.js"),
), array($js)));


$am->set('bootstrapcss', new AssetCollection(array(
    new FileAsset(__DIR__ . '/vendor/twitter/bootstrap/less/bootstrap.less'),
), array($less, $css)));

$am->set('halfjs', new AssetCollection(array(
    new AssetReference($am, 'jqueryjs'),
    new AssetReference($am, 'uicorejs'),
    new AssetReference($am, 'uihalfjs'),
    new AssetReference($am, 'bootstraphalfjs'),
)));

$am->set('fulljs', new AssetCollection(array(
    new AssetReference($am, 'jqueryjs'),
    new AssetReference($am, 'uicorejs'),
    new AssetReference($am, 'uihalfjs'),
    new AssetReference($am, 'uiextrajs'),
    new AssetReference($am, 'uii18njs'),
    new AssetReference($am, 'bootstraphalfjs'),
    new AssetReference($am, 'bootstrapextrajs'),
)));

$am->set('halfcss', new AssetCollection(array(
    new AssetReference($am, 'uicorecss'),
    new AssetReference($am, 'uihalfcss'),
    new AssetReference($am, 'bootstrapcss'),
)));

$am->set('fullcss', new AssetCollection(array(
    new AssetReference($am, 'uicorecss'),
    new AssetReference($am, 'uihalfcss'),
    new AssetReference($am, 'uiextracss'),
    new AssetReference($am, 'bootstrapcss'),
)));

$cache = new FilesystemCache(__DIR__ . '/compiled/cache');
foreach ($am->getNames() as $name) {
    $filename = $name;
    if (preg_match('/^(.+)(js|css)$/', $name, $matches)) {
        $filename = $matches[1] . '.' . $matches[2];
    }
    $asset = $am->get($name);
    $asset = new AssetCache($asset, $cache);
    $asset->setTargetPath($filename);
    $am->set($name, $asset);
}

$writer = new AssetWriter(__DIR__ . '/compiled');
$writer->writeManagerAssets($am);

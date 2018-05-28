<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class ChartAsset extends AssetBundle
{
	public $sourcePath = '@bower/highcharts-release';
	public $js = [
		'highcharts.js',
		'modules/data.js',
		'modules/exporting.js',
	];

	public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        
    ];
 public $publishOptions = [
        'only' => [
			'highcharts.js',
			'modules/data.js',
			'modules/exporting.js',
        ],
        'forceCopy' => true,
    ];
}
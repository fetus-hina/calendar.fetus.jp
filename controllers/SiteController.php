<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}

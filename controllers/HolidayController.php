<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\controllers;

use Yii;
use app\models\Holiday;
use yii\web\Controller;
use yii\web\Response;

class HolidayController extends Controller
{
    public function actionJson()
    {
        $resp = Yii::$app->response;
        $resp->format = Response::FORMAT_JSON;
        return array_map(
            function ($o) {
                return $o->jsonStructure;
            },
            Holiday::find()->all()
        );
    }
}

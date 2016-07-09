<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

class SecretController extends Controller
{
    const COOKIE_SECRET_TEXT_LENGTH = 32;
    const BASE64_EXTENDS = 4 / 3;

    public function actionCookie()
    {
        $binary = \random_bytes(
            static::COOKIE_SECRET_TEXT_LENGTH / static::BASE64_EXTENDS
        );
        $key = substr(
            strtr(base64_encode($binary), '+/=', '_-.'),
            0,
            static::COOKIE_SECRET_TEXT_LENGTH
        );
        printf(
            "<?php\nreturn '%s';\n",
            $key // base64-based string. it's safe.
        );
    }
}

<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\models\incoming;

use Yii;
use app\models\Holiday as DbModel;
use app\models\HolidayName;

class Holiday extends \yii\base\Model
{
    public $date;
    public $name;

    public function rules()
    {
        return [
            [['date', 'name'], 'required'],
            [['date'], 'match', 'pattern' => '/^\d{8}$/'],
        ];
    }

    public function load($data, $unused = null)
    {
        $map = [
            'date' => 'DTSTART',
            'name' => 'SUMMARY',
        ];
        foreach ($map as $attr => $prop) {
            $value = $data[$prop] ?? null;
            if (!is_string($value)) {
                return false;
            }
            $this->$attr = $value;
        }
        return true;
    }

    public function getNormalizedName() : string
    {
        $value = mb_convert_encoding($this->name, 'UTF-8', 'UTF-8');
        $value = trim($value);
        if (strpos($value, '振替休日') !== false) {
            return '振替休日';
        }
        return $value;
    }

    public function save() : DbModel
    {
        if (!$this->validate()) {
            throw new \Exception(array_shift($this->getFirstErrors()));
        }

        $ret = Yii::createObject([
            'class' => DbModel::class,
            'date' => $this->date,
            'name_id' => HolidayName::findOrCreateByName($this->normalizedName)->id,
        ]);
        if (!$ret->save()) {
            throw new \Exception(array_shift($ret->getFirstErrors()));
        }
        return $ret;
    }
}

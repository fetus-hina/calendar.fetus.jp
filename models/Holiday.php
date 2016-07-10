<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "holiday".
 *
 * @property integer $date
 * @property integer $name_id
 *
 * @property HolidayName $name
 */
class Holiday extends \yii\db\ActiveRecord
{
    public static function find()
    {
        $t = static::tableName();
        return parent::find()
            ->with('name')
            ->orderBy("{{{$t}}}.[[date]] ASC");
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'holiday';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'name_id'], 'required'],
            [['date', 'name_id'], 'integer'],
            [['date'], 'unique'],
            [['date'], 'match', 'pattern' => '/^\d{8}$/'],
            [['name_id'], 'exist', 'skipOnError' => true,
                'targetClass' => HolidayName::className(),
                'targetAttribute' => ['name_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'name_id' => 'Name ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getName()
    {
        return $this->hasOne(HolidayName::className(), ['id' => 'name_id']);
    }

    public function getJsonStructure()
    {
        $date = (string)$this->date;
        $formatted = sprintf(
            '%04d-%02d-%02d',
            (int)substr($date, 0, 4),
            (int)ltrim(substr($date, 4, 2), '0'),
            (int)ltrim(substr($date, 6, 2), '0')
        );
        return [
            'date' => $formatted,
            'date_int' => strtotime($formatted . '+09:00') * 1000,
            'name' => $this->name->name,
        ];
    }
}

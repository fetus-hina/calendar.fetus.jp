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
}

<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://opensource.org/licenses/mit-license.php MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "holiday_name".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Holiday[] $holidays
 */
class HolidayName extends \yii\db\ActiveRecord
{
    public static function findOrCreateByName($name) : self
    {
        printf("%s(%s)\n", __METHOD__, $name);
        return static::findOne(['name' => $name]) ?? static::create($name);
    }

    protected static function create($name) : self
    {
        printf("%s(%s)\n", __METHOD__, $name);
        $ret = Yii::createObject([
            'class' => static::class,
            'name' => $name,
        ]);
        if (!$ret->save()) {
            throw new \Exception(array_shift($ret->getFirstErrors()));
        }
        return $ret;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'holiday_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidays()
    {
        return $this->hasMany(Holiday::className(), ['name_id' => 'id']);
    }
}

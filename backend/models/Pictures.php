<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pictures".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $name
 */
class Pictures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pictures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'name'], 'required'],
            [['uid'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
        ];
    }
}

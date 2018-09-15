<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ideas".
 *
 * @property int $id
 * @property string $content
 * @property int $impact
 * @property int $ease
 * @property int $confidence
 * @property string $created_at
 * @property int $created_by
 */
class Idea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ideas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['impact', 'ease', 'confidence'], 'integer', 'min' => 1, 'max' => 10],
            [['created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string', 'length' => [1, 255]],
            [['impact', 'ease', 'confidence', 'content'], 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'impact' => 'Impact',
            'ease' => 'Ease',
            'confidence' => 'Confidence',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = \Yii::$app->user->id;
            $this->created_at = date("Y-m-d H:i:s");
        }
        $this->average_score = ($this->ease + $this->impact + $this->confidence) / 3;
        return true;
    }
}
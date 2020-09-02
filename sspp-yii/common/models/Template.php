<?php

namespace common\models;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string $name
 * @property int $type 1=temp, 2=word
 * @property string $content
 * @property int $status
 * @property string $remark
 * @property int $created_at
 * @property int $updated_at
 */
class Template extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'content' => 'Content',
            'status' => 'Status',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

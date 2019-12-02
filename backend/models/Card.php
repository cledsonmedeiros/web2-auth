<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property string $todo
 * @property int $order
 * @property int $archived
 * @property int $column_id
 *
 * @property Columns $column
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['todo', 'order', 'column_id'], 'required'],
            [['order', 'archived', 'column_id'], 'integer'],
            [['todo'], 'string', 'max' => 100],
            [['column_id'], 'exist', 'skipOnError' => true, 'targetClass' => Columns::className(), 'targetAttribute' => ['column_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'todo' => 'Todo',
            'order' => 'Order',
            'archived' => 'Archived',
            'column_id' => 'Column ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(Columns::className(), ['id' => 'column_id']);
    }
}

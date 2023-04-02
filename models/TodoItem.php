<?php

namespace app\models;

use yii\db\ActiveRecord;

class TodoItem extends ActiveRecord
{

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->version = 1;
            }
            return true;
        }
        return false;
    }

    public static function tableName(): string
    {
        return '{{%todo_item}}';
    }

    public function optimisticLock(): string
    {
        return 'version';
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
            [['priority'], 'integer', 'min' => 0],
            [['done'], 'boolean'],
            [['version'], 'integer'],
        ];
    }
}

<?php

namespace app\models;

use Yii;
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

    public function optimisticLock(): ?string
    {
        // Disable optimistic locking for the 'done' action
        if (Yii::$app->controller->action->id === 'done') {
            return null;
        }
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

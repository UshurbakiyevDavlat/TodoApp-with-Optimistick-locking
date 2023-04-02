<?php

namespace unit\services;

use app\models\TodoItem;
use app\services\TodoItemService;
use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class TodoItemServiceTest extends Unit
{
    private TodoItemService $todoItemService;

    /**
     * @throws Exception
     */
    protected function _before()
    {
        // create a mock object for TodoItem model
        $todoItemModelMock = Stub::make(TodoItem::class, [
            'findOne' => function ($id) {
                // return a mock TodoItem model with the given ID
                return Stub::make(TodoItem::class, ['id' => $id]);
            },
            'save' => true,
        ]);

        // create a new instance of TodoItemService with the mock TodoItem model
        $this->todoItemService = new TodoItemService($todoItemModelMock);
    }

    /**
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function testOptimisticLocking(): void
    {
        // Create a new todo item and save it to the database
        $todoItem = new TodoItem([
            'title' => 'Test Todo Item',
            'priority' => 1,
        ]);
        $todoItem->save();

        // Clone the todo item to simulate another user updating the same record
        $clonedTodoItem = clone $todoItem;

        // Update the todo item
        $todoItem->priority = 2;
        $this->todoItemService->update($todoItem);

        // Try to update the cloned todo item, which should throw an exception
        $clonedTodoItem->priority = 3;
        $this->expectException(Exception::class);
        $this->todoItemService->update($clonedTodoItem);
    }
}

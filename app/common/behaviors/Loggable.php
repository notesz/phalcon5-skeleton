<?php

namespace Skeleton\Behaviors;

use Phalcon\Mvc\Model\BehaviorInterface;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Di\Di;

class Loggable implements BehaviorInterface
{
    protected $model;

    /**
     * @param ModelInterface $model
     * @param string $method
     * @param array $arguments
     * @return void
     */
    public function missingMethod(ModelInterface $model, string $method, array $arguments = [])
    {
    }

    /**
     * @param string $eventType
     * @param ModelInterface $model
     * @return false|void
     */
    public function notify(string $eventType, ModelInterface $model)
    {
        if (Di::getDefault()->get('config')->database_log->enable !== true) {
            return false;
        }

        $this->model = $model;

        switch ($eventType) {
            case 'afterCreate':
                $this->log([
                    'operation' => 'INSERT'
                ]);
                break;

            case 'afterDelete':
                $this->log([
                    'operation' => 'DELETE'
                ]);
                break;

            case 'afterUpdate':
                $from = $this->model->getOldSnapshotData();
                $to = $this->model->toArray();
                $diff = $this->model->getUpdatedFields();

                $updatedData = [];

                foreach($diff as $key) {
                    $updatedData[$key] = [
                        'from' => $from[$key],
                        'to' => $to[$key]
                    ];
                }

                $this->log([
                    'operation' => 'UPDATE',
                    'diff' => $updatedData
                ]);
                break;
        }
    }

    /**
     * @param array $messageData
     * @return void
     */
    protected function log(array $messageData)
    {
        $messageData['model'] = get_class($this->model);
        $messageData['model_id'] = $this->model->id;
        $messageData['model_data'] = $this->model->toArray();

        Di::getDefault()->get('log')->info(
            json_encode($messageData)
        );
    }
}

<?php

namespace Skeleton\Common\Models;

/**
 * Contents model.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class ModelBase extends \Phalcon\Mvc\Model
{
    /**
     * Initialize
     */
    public function initialize()
    {
        $this->setWriteConnectionService("database");
        $this->setReadConnectionService("database_slave");

        if ($this->isDatabaseLogEnable()) {
            $this->keepSnapshots(true);
        }
    }

    /**
     * @return bool
     */
    private function isDatabaseLogEnable()
    {
        if ($this->di->get('config')->database_log->enable === false) {
            return false;
        }

        if (in_array(
            get_class($this),
            $this->di->get('config')->database_log->classes->toArray()
        )) {
            return true;
        }

        return false;
    }

    public function beforeCreate()
    {
        if ($this->isDatabaseLogEnable()) {
            $this->log([
                'operation' => 'INSERT'
            ]);
        }
    }

    public function beforeUpdate()
    {
        if ($this->isDatabaseLogEnable()) {
            $from = $this->getOldSnapshotData();
            $to = $this->toArray();
            $diff = $this->getChangedFields();

            $updatedData = [];

            foreach ($diff as $key) {
                $updatedData[$key] = [
                    'from' => $from[$key],
                    'to' => $to[$key]
                ];
            }

            $this->log([
                'operation' => 'UPDATE',
                'diff' => $updatedData
            ]);
        }
    }

    public function beforeDelete()
    {
        if ($this->isDatabaseLogEnable()) {
            $this->log([
                'operation' => 'DELETE'
            ]);
        }
    }

    private function log(array $messageData)
    {
        $messageData['model'] = get_class($this);
        $messageData['model_id'] = $this->id;
        $messageData['model_data'] = $this->toArray();

        $this->di->get('log')->info(
            \json_encode($messageData)
        );
    }
}

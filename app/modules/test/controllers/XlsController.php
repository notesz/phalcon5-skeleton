<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * XLS controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class XlsController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
    }

    public function generateAction()
    {
        /** @var \Skeleton\Library\Xls $xls */
        $xls = $this->di->get('xls');

        // Set title
        $title = 'XLS example';
        $xls->setTitle($title);

        // Header
        $xls->addRow([
            'Title',
            'Email',
            'Author',
            'Publication date'
        ]);

        // Data
        $xls->addRow([
            'Lorem ipsum',
            'john@example.com',
            'John Smith',
            '2024-01-10 12:30:00'
        ]);
        $xls->addRow([
            'Dolor sit amet',
            'john@example.com',
            'John Smith',
            '2024-04-06 23:23:00'
        ]);
        $xls->addRow([
            'Maecenas aliquam lectus massa',
            'john@example.com',
            'John Smith',
            '2024-07-07 00:59:00'
        ]);

        // Generate and save cache file
        $cacheFilePath = $this->di->get('config')->application->cacheDir . \str_replace('-', '', \date('YmdHis')) . '.xlsx';
        $xls->save($cacheFilePath);


        // Save to filestorage
        $filestorage = $this->di->get('filestorage');

        if ($filestorage->add($title, $cacheFilePath) === true) {

            // Delete cache file
            \unlink($cacheFilePath);

            $result = $filestorage->getResult();
            $this->flash->success('Success: ' . $result['code']);

            return $this->response->redirect(
                $this->url->get([
                    'for' => 'test-filestorage-list'
                ])
            );
        } else {
            $this->flash->error($filestorage->getMessage());
        }

        return $this->response->redirect(
            $this->url->get([
                'for' => 'test-xls-index'
            ])
        );
    }
}

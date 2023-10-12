<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * Image controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class ImageController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function listAction()
    {
        $result = $this->di->get('image')->list(1);

        $this->view->setVar('items', $result['items']);
    }

    public function uploadAction()
    {
        if (
            $this->request->isPost() &&
            $this->request->hasFiles() === true
        ) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $resultUpload = $this->di->get('image')->add(
                    $file->getTempName(),
                    $this->request->getPost('title'),
                    $this->request->getPost('parent_id'),
                    $this->request->getPost('type')
                );

                if ($resultUpload['status'] == 'success') {
                    $this->flash->success('Success');
                }

                if ($resultUpload['status'] == 'error') {
                    $this->flash->error('Error: ' . $resultUpload['message']);
                }

                return $this->response->redirect(
                    $this->url->get([
                        'for'      => 'test-image-list'
                    ])
                );
            }
        }
    }

    public function editAction()
    {
        $code = $this->dispatcher->getParam('code');

        $result = $this->di->get('image')->getByCode($code);
        $this->view->setVar('result', $result);
    }

    public function deleteAction()
    {
        $code = $this->dispatcher->getParam('code');

        $result = $this->di->get('image')->delete($code);

        if ($result === true) {
            $this->flash->success('Success');
        } else {
            $this->flash->error($result);
        }

        return $this->response->redirect(
            $this->url->get([
                'for'      => 'test-image-list'
            ])
        );
    }
}

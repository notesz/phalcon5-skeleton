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
        $result = $this->di->get('image')->list();

        $pagination = $this->di->get('pagination')->pager(
            $result,
            (
                empty($this->request->get($this->di->get('config')->pagination->key)) ?
                    1 :
                    $this->request->get($this->di->get('config')->pagination->key)
            )
        );

        $this->view->setVar('items', $pagination['items']);
        $this->view->setVar('pager', $pagination['pager']);
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

    public function saveAction()
    {
        $code = $this->dispatcher->getParam('code');

        try {
            /** @var \Skeleton\Common\Models\Images $image */
            $image = \Skeleton\Common\Models\Images::findFirst([
                'conditions' => 'code = :code:',
                'bind' => [
                    'code' => $code
                ]
            ]);

            if (!$image) {
                throw new \Exception('Image not found');
            }

            $image->setTitle($this->request->getPost('title'));

            if ($image->save() === false) {
                $errorMessage = [];
                foreach ($image->getMessages() as $message) {
                    $errorMessage[] = $message;
                }

                throw new \Exception(\implode(', ', $errorMessage));
            }

            $this->flash->success('Success');
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        return $this->response->redirect(
            $this->url->get([
                'for' => 'test-image-list'
            ])
        );
    }
}

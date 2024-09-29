<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * Filestorage controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class FilestorageController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function listAction()
    {
        $result = $this->getDI()->getFilestorage()->list();

        $pagination = $this->getDI()->getPagination()->pager(
            $result,
            (
            empty($this->request->get($this->getDI()->getConfig()->pagination->key)) ?
                1 :
                $this->request->get($this->getDI()->getConfig()->pagination->key)
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

                if ($this->getDI()->getFilestorage()->add(
                    $this->request->getPost('title'),
                    $file->getTempName()
                ) === true) {
                    $result = $this->getDI()->getFilestorage()->getResult();
                    $this->flash->success('Success: ' . $result['code']);
                } else {
                    $this->flash->error($this->getDI()->getFilestorage()->getMessage());
                }

                return $this->response->redirect(
                    $this->url->get([
                        'for' => 'test-filestorage-list'
                    ])
                );
            }
        }
    }

    public function editAction()
    {
        $code = $this->dispatcher->getParam('code');

        $result = $this->getDI()->getFilestorage()->info($code);
        $this->view->setVar('result', $result);
    }

    public function deleteAction()
    {
        $code = $this->dispatcher->getParam('code');

        if ($this->getDI()->getFilestorage()->delete($code) === true) {
            $this->flash->success('Success');
        } else {
            $this->flash->error($this->getDI()->getFilestorage()->getMessage());
        }

        return $this->response->redirect(
            $this->url->get([
                'for' => 'test-filestorage-list'
            ])
        );
    }

    public function downloadAction()
    {
        $code = $this->dispatcher->getParam('code');

        $result = $this->getDI()->getFilestorage()->get($code);

        \header('Content-Description: File Transfer');
        \header('Content-Type: ' . $result['mimetype']);
        \header('Content-Disposition: attachment; filename="' . \basename($result['filepath']) . '"');
        \header('Expires: 0');
        \header('Cache-Control: must-revalidate');
        \header('Pragma: public');
        \header('Content-Length: ' . \filesize($result['filepath']));
        \flush();

        \readfile($result['filepath']);

        return false;
    }
}

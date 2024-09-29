<?php

namespace Skeleton\Library;

use SoftCreatR\MimeDetector\MimeDetector;
use SoftCreatR\MimeDetector\MimeDetectorException;
use Phalcon\Di\Di;
use Skeleton\Common\Models\Files;

/**
 * Filestorage library.
 */
class Filestorage
{
    protected $config;

    /** @var \Skeleton\Library\Helper $helper */
    protected $helper;

    protected $result;

    protected $message;

    /**
     * Construct
     */
    function __construct()
    {
        $this->config = Di::getDefault()->get('config');
        $this->helper = Di::getDefault()->get('helper');
        $this->setResult([]);
        $this->setMessage('');
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array $result
     */
    protected function setResult(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    protected function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param string $title
     * @param string $filePath
     * @return bool
     */
    public function add(string $title, string $filePath)
    {
        try {
            // Check file
            if (!is_file($filePath)) {
                throw new \Exception('File not found: ' . $filePath);
            }

            // Generate code and folder name
            $code = \date('Ym')
                . $this->helper->getRandomString(10);

            $dirname = '';
            for ($i = 0; $i < \strlen($code); $i++) {
                $dirname = $dirname . '/' . \substr($code, $i, 1);
            }


            // Read extension and mime type
            $mimeDetector = new MimeDetector();
            $mimeDetector->setFile($filePath);
            $fileType = $mimeDetector->getFileType();

            $extension = !empty($fileType['ext']) ? $fileType['ext'] : 'unkown';
            $mimetype = !empty($fileType['mime']) ? $fileType['mime'] : 'unkown';


            // Generate filename
            $filename = $this->helper->getFriendlyName($title) . '.' . $extension;


            // Save to database
            $files = new Files();

            $files->setCode($code);
            $files->setTitle($title);
            $files->setFilename($filename);
            $files->setDirname($dirname);
            $files->setExtension($extension);
            $files->setMimetype($mimetype);
            $files->setFilesize(
                \filesize($filePath)
            );
            $files->setCreatedDate(\date('Y-m-d H:i:s'));

            if ($files->save() === false) {
                $errorMessage = [];
                foreach ($files->getMessages() as $message) {
                    $errorMessage[] = $message;
                }

                throw new \Exception('Database save error: ' . \implode(', ', $errorMessage));
            }


            // Create folder and copy file
            \mkdir($this->config->filestorage->path . $dirname, 0777, true);
            \copy($filePath, $this->config->filestorage->path . $dirname . '/' . $filename);


            $this->setResult([
                'code' => $code
            ]);


            return true;
        } catch (MimeDetectorException $e) {
            $this->setMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->setMessage($e->getMessage());
        }

        return false;
    }

    /**
     * @param string $code
     * @return array
     */
    public function info(string $code)
    {
        $file = $this->getFileData($code);

        if (!empty($file)) {
            unset($file['filepath']);
        }

        return $file;
    }

    /**
     * @param string $code
     * @return array
     */
    public function get(string $code)
    {
        $file = $this->getFileData($code);

        if (!empty($file)) {
            $file['base64'] = \base64_encode(\file_get_contents($file['filepath']));
        }

        return $file;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function delete(string $code)
    {
        try {
            /** @var Files $file */
            $file = Files::findFirst([
                'conditions' => 'code = :code:',
                'bind' => [
                    'code' => $code
                ]
            ]);

            if (!$file) {
                throw new \Exception('File not found [1]');
            }

            if (!is_file($this->config->filestorage->path . $file->getDirname() . '/' . $file->getFilename())) {
                throw new \Exception('File not found [2]');
            }

            \unlink($this->config->filestorage->path . $file->getDirname() . '/' . $file->getFilename());

            $file->delete();

            return true;

        } catch (\Exception $e) {
            $this->setMessage($e->getMessage());
        }

        return false;
    }

    /**
     * @param string $order
     * @param string $orderBy
     * @return array
     */
    public function list(string $order = 'created_date', string $orderBy = 'ASC')
    {
        $files = [];

        if (!in_array($order, [
            'title', 'filename', 'extension', 'mimetype', 'filesize', 'created_date'
        ])) {
            $order = 'created_date';
        }

        if (!in_array($orderBy, [
            'ASC', 'DESC'
        ])) {
            $orderBy = 'ASC';
        }

        /** @var Files $item */
        foreach (Files::find([
            'order' => $order . ' ' . $orderBy
        ]) as $item) {
            $files[] = [
                'code'         => $item->getCode(),
                'title'        => $item->getTitle(),
                'filename'     => $item->getFilename(),
                'filesize'     => $this->helper->getFileSizeFormat($item->getFilesize()),
                'extension'    => $item->getExtension(),
                'mimetype'     => $item->getMimetype(),
                'created_date' => $item->getCreatedDate(),
            ];
        }

        return $files;
    }

    /**
     * @param string $code
     * @return array
     */
    private function getFileData(string $code)
    {
        /** @var Files $file */
        $file = Files::findFirst([
            'conditions' => 'code = :code:',
            'bind'       => [
                'code' => $code
            ]
        ]);

        if ($file) {
            return [
                'code'         => $file->getCode(),
                'title'        => $file->getTitle(),
                'filename'     => $file->getFilename(),
                'filesize'     => $this->helper->getFileSizeFormat($file->getFilesize()),
                'extension'    => $file->getExtension(),
                'mimetype'     => $file->getMimetype(),
                'created_date' => $file->getCreatedDate(),
                'filepath'     => $this->config->filestorage->path . $file->getDirname() . '/' . $file->getFilename()
            ];
        }

        return [];
    }
}

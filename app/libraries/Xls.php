<?php

namespace Skeleton\Library;

use Phalcon\Di\Di;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * XLS library.
 */
class Xls
{
    const DEFAULT_TITLE = 'Document';

    protected $config;
    protected $xls;
    protected $sheet;
    protected $title;
    protected $rows;

    public function __construct()
    {
        $this->config = Di::getDefault()->get('config');

        $this->xls = new Spreadsheet();
        $this->xls->setActiveSheetIndex(0);
        $this->sheet = $this->xls->getActiveSheet();
        $this->rows = [];
        $this->setTitle(self::DEFAULT_TITLE);
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $key
     * @param array $row
     * @return array
     *
     * Array(
     *     '1', 'Lorem ipsum', '10990'
     * )
     */
    public function addRow($row)
    {
        $rows = $this->rows;
        $rows[] = $row;
        $this->rows = $rows;

        return $rows;
    }

    /**
     * @param string $filepath
     * @return void
     */
    public function save($filepath)
    {
        $this->sheet->setTitle($this->title);

        $alphas = $this->getAlphas();
        $rows   = $this->rows;

        $rowNumber = 1;
        foreach ($rows as $row) {
            $columnNumber = 0;
            foreach ($row as $column) {
                $this->sheet->setCellValue($alphas[$columnNumber] . $rowNumber, $column);
                $this->sheet->getColumnDimension($alphas[$columnNumber])->setAutoSize(true);
                $columnNumber++;
            }
            $rowNumber++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->xls);
        $writer->save($filepath);
    }

    /**
     * Generate A-ZZ
     *
     * @return array
     */
    private function getAlphas()
    {
        // A-Z
        $alphas = \range('A', 'Z');

        // AA-ZZ
        foreach (\range('A', 'Z') as $firstLetter) {
            foreach (\range('A', 'Z') as $secondLetter) {
                $alphas = \array_merge($alphas, [$firstLetter . $secondLetter]);
            }
        }

        return $alphas;
    }
}

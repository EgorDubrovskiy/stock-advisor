<?php

namespace App\Interfaces\Documents;

use App\Services\Documents\PDFService;

/**
 * Interface PDFInterface
 * @package App\Interfaces\Documents
 */
interface PDFInterface
{
    public function addPage() : void;

    /**
     * @param string $html
     */
    public function writeHTML(string $html) : void;

    /**
     * @param string $name
     * @param string $dest
     * @return string
     */
    public function output($name = 'doc.pdf', $dest = 'I') : string;

    /**
     * @param string $fileName
     */
    public function importPages(string $fileName) : void;

    /**
     * @param int $number
     */
    public function deletePage(int $number) : void;

    /**
     * @param string $fileName
     */
    public function saveWithoutFirstPage(string $fileName) : void;

    /**
     * @return PDFService
     */
    public function newInstance() : PDFService;
}

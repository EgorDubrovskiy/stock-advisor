<?php

namespace App\Services\Documents;

use App\Interfaces\Documents\PDFInterface;
use Illuminate\Foundation\Application;
use setasign\Fpdi\Tcpdf\Fpdi;

/**
 * Class PDFService
 * @package App\Services\Documents
 */
class PDFService implements PDFInterface
{
    /** @var Fpdi $pdf */
    protected $pdf;

    /**
     * @var Application
     */
    protected $app;

    /**
     * PDFService constructor.
     * @param FPDI $pdf
     */
    public function __construct(Fpdi $pdf, Application $app)
    {
        $this->pdf = $pdf;
        $this->app = $app;
    }

    public function addPage() : void
    {
        $this->pdf->AddPage();
    }

    /**
     * @param string $html
     */
    public function writeHTML(string $html) : void
    {
        $this->pdf->writeHTML($html);
    }

    /**
     * @param string $name
     * @param string $dest
     * @return string
     */
    public function output($name = 'doc.pdf', $dest = 'I') : string
    {
        return $this->pdf->Output($name, $dest);
    }

    /**
     * @param string $fileName
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function importPages(string $fileName) : void
    {
        $countPages = $this->pdf->setSourceFile($fileName);
        for ($i = 1; $i <= $countPages; $i++) {
            $this->pdf->AddPage();
            $tpl = $this->pdf->importPage($i);
            $this->pdf->useTemplate($tpl);
        }
    }

    /**
     * @param int $number
     */
    public function deletePage(int $number) : void
    {
        $this->pdf->deletePage($number);
    }

    /**
     * @param string $fileName
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function saveWithoutFirstPage(string $fileName) : void
    {
        $this->pdf = $this->newInstance()->pdf;
        $this->importPages($fileName);
        $this->deletePage(1);
        $this->output($fileName, 'F');
    }

    /**
     * @return PDFService
     */
    public function newInstance() : PDFService
    {
        return $this->app->make(PDFService::class);
    }
}

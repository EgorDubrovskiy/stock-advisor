<?php

namespace Tests\Unit;

use App\Services\Documents\PDFService;
use Illuminate\Foundation\Application;
use setasign\Fpdi\Tcpdf\Fpdi;
use Tests\TestCase;
use Mockery;

/**
 * Class PDFServiceTest
 * @package Tests\Unit
 */
class PDFServiceTest extends TestCase
{

    public function testDeletePageSuccess()
    {
        $number = 3;
        $mockFPDI = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockFPDI, $mockApp);

        $mockFPDI->shouldReceive('deletePage')
             ->with($number)
             ->once()
             ->andReturn();

        $service->deletePage($number);
    }

    public function testAddPageSuccess()
    {
        $mockFPDI = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockFPDI, $mockApp);

        $mockFPDI->shouldReceive('addPage')
            ->withNoArgs()
            ->once()
            ->andReturn();

        $service->addPage();
    }

    public function testWriteHTMLSuccess()
    {
        $html = '<br>';
        $mockFPDI = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockFPDI, $mockApp);

        $mockFPDI->shouldReceive('writeHTML')
            ->with($html)
            ->once()
            ->andReturn();

        $service->writeHTML($html);
    }

    public function testOutputSuccess()
    {
        $fileName = 'testname.pdf';
        $destination = 'I';
        $mockFPDI = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockFPDI, $mockApp);

        $mockFPDI->shouldReceive('Output')
             ->with($fileName, $destination)
             ->once()
             ->andReturn('');

        $service->output($fileName, $destination);
    }

    /**
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public function testImportPagesSuccess()
    {
        $mockFPDI = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockFPDI, $mockApp);
        $filename = 'test.pdf';

        $mockFPDI->shouldReceive('setSourceFile')
             ->with($filename)
             ->once()
             ->andReturn();
        $mockFPDI->shouldReceive('AddPage')
            ->withNoArgs()
            ->zeroOrMoreTimes()
            ->andReturn();
        $mockFPDI->shouldReceive('importPage')
             ->withAnyArgs()
            ->zeroOrMoreTimes()
            ->andReturn();
        $mockFPDI->shouldReceive('useTemplate')
             ->withAnyArgs()
            ->zeroOrMoreTimes()
            ->andReturn();

        $service->importPages($filename);
    }

    /**
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\Filter\FilterException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    public  function  testSaveWithoutFirstPageSuccess()
    {
        $fileName = 'testname.pdf';
        $destination = 'F';
        $mockPDF = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockPDF, $mockApp);

        $mockApp->shouldReceive('make')
            ->with(PDFService::class)
            ->once()
            ->andReturn($service);
        $mockPDF->shouldReceive('setSourceFile')
            ->with($fileName)
            ->once()
            ->andReturn();
        $mockPDF->shouldReceive('deletePage')
            ->with(1)
            ->once()
            ->andReturn();
        $mockPDF->shouldReceive('Output')
            ->with($fileName, $destination)
            ->once()
            ->andReturn('');

        $service->saveWithoutFirstPage($fileName);
    }

    public function testNewInstanceSuccess()
    {
        $mockFPDI = Mockery::mock(Fpdi::class);
        $mockApp = Mockery::mock(Application::class);
        $service = new PDFService($mockFPDI, $mockApp);

        $mockApp->shouldReceive('make')
            ->with(PDFService::class)
            ->once()
            ->andReturn($service);

        $service->newInstance();
    }
}

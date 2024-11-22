<?php

declare(strict_types=1);

namespace App\Services\web;

use Dompdf\Dompdf;
use ZipArchive;

class PDFService
{

    static function download($clients)
    {
        // Create a temporary directory to store the generated PDF files
        $tempDir = tempnam(sys_get_temp_dir(), 'pdf');
        unlink($tempDir);
        mkdir($tempDir);

        // Generate the PDF files
        /*foreach ($pdfs as $fileName => $content) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents($tempDir . '/' . $fileName, $output);
        }

        // Create a temporary zip file
        $zipFile = tempnam(sys_get_temp_dir(), 'download');
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Add the PDF files to the zip
        foreach (glob($tempDir . '/*.pdf') as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        // Clean up the temporary directory
        $this->removeDirectory($tempDir);

        // Set the zip file name
        $zipFileName = 'downloaded_files.zip';

        // Create a response with the zip file and headers
        $response = response()->download($zipFile, $zipFileName, [
            'Content-Type' => 'application/zip',
        ]);

        // Delete the temporary zip file
        $this->removeFile($zipFile);

        return $response;*/
    }

    static function removeDirectory($path)
    {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? self::removeDirectory($file) : self::removeFile($file);
        }
        rmdir($path);
    }

    static function removeFile($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }

}

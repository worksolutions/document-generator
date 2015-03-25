<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Tests\Units;


use PhpOffice\PhpWord\Shared\ZipArchive;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class WordDocumentsMatcher {
    public function isMatch($document1, $document2) {
        return $this->_countSum($document1) == $this->_countSum($document2);
    }

    private function _unzip($documentPath, $extractToPath) {
        $zip = new ZipArchive();
        $zip->open($documentPath);

        $zip->extractTo($extractToPath);
    }

    private function _rmdir($path) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $pathInfo) {
            /** @var \SplFileInfo $pathInfo */
            if ($pathInfo->isFile()) {
                unlink($pathInfo->getPathname());
                continue;
            }

            rmdir($pathInfo->getPathname());
        }
    }

    private function _countSum($document) {
        $extractPath = tempnam(sys_get_temp_dir(), '');
        unlink($extractPath);
        mkdir($extractPath);

        $this->_unzip($document, $extractPath);
        $sum = md5(file_get_contents($extractPath . '/word/document.xml'));

        $this->_rmdir($extractPath);

        return $sum;
    }
}
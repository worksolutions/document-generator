<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Tests\Units;


use PHPUnit_Framework_TestCase;
use WS\DocumentGenerator\WordTemplateProcessor;

class WordTemplateProcessorTest extends PHPUnit_Framework_TestCase {
    public function testGenerate(){
        $processor = new WordTemplateProcessor();

        $outputPath = tempnam(sys_get_temp_dir(), '');

        $processor->useTemplate(__DIR__ . "/../data/WordTemplateProcessorTest/testGenerate/template.docx")
            ->setField('COMPANY_NAME', 'WorkSolutions')
            ->process()
            ->saveAs($outputPath);

        $matcher = new WordDocumentsMatcher();
        $isMatch = $matcher->isMatch($outputPath, __DIR__ . '/../data/WordTemplateProcessorTest/testGenerate/result.docx');

        unlink($outputPath);

        $this->assertTrue($isMatch);
    }
}
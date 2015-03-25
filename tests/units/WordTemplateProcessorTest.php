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

        $processor
            ->setValue('company_name', 'WorkSolutions')
            ->setValue('name', 'Smotrov Dmitriy')
            ->setValue('address', 'Lenina 13')
            ->setValue('city', 'Rostov-on-Don')
            ->setValue('state', 'Rostovskaya oblast')
            ->setValue('zip', '344000')
            ->setValue('date', (new \DateTime())->format('Y-m-d'))
            ->setValue('project_title', 'PhpWord project')
            ->setValue('project_description', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex illum inventore omnis sequi suscipit. Aspernatur aut doloribus earum molestias numquam, odio optio quibusdam reiciendis sed similique sint sunt ullam vero?')
            ->setValue('invoice_number', 21);

        $items = [
            [
                'product_title' => 'Test product #1',
                'product_quantity' => $quantity = 2,
                'product_price' => $price = 1000,
                'product_cost' => $quantity * $price
            ],
            [
                'product_title' => 'Test product #2',
                'product_quantity' => $quantity = 5,
                'product_price' => $price = 1500,
                'product_cost' => $quantity * $price
            ],
        ];

        $total = 0;
        foreach ($items as $item) {
            $total += $item['product_cost'];
            $processor->addTableRow('product_title', $item);
        }

        $processor->setValue('total', $total);

        $processor->useTemplate(__DIR__ . "/../data/WordTemplateProcessorTest/testGenerate/template.docx")
            ->process()
            ->saveAs($outputPath);


        $matcher = new WordDocumentsMatcher();
        $isMatch = $matcher->isMatch($outputPath, __DIR__ . '/../data/WordTemplateProcessorTest/testGenerate/result.docx');

        unlink($outputPath);

        $this->assertTrue($isMatch);
    }
}
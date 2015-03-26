<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Tests\Units;


use PHPUnit_Framework_TestCase;
use WS\DocumentGenerator\Document;

class DocumentGenerateTest extends PHPUnit_Framework_TestCase {
    public function testGenerateFromDocx(){
        $output = $this->_generateByTemplate(__DIR__ . "/../data/docx/template.docx");

        $matcher = new DocxDocumentsMatcher();
        $isMatch = $matcher->isMatch($output, __DIR__ . '/../data/docx/result.docx');

        unlink($output);

        $this->assertTrue($isMatch);
    }

    public function testGenerateFromDoc(){
        $output = $this->_generateByTemplate(__DIR__ . "/../data/doc/template.doc");

        $matcher = new DocxDocumentsMatcher();
        $isMatch = $matcher->isMatch($output, __DIR__ . '/../data/doc/result.docx');

        unlink($output);

        $this->assertTrue($isMatch);
    }

    private function _generateByTemplate($template) {
        $document = new Document($template);
        $document
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
            $document->addValueGroup('product', $item);
        }

        $document->setValue('total', $total);

        $output = tempnam(sys_get_temp_dir(), '');

        $document->saveTo($output);

        return $output;
    }
}
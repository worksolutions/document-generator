<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator;


use PhpOffice\PhpWord\TemplateProcessor as PhpOfficeTemplateProcessor;

class WordTemplateProcessor extends AbstractTemplateProcessor {

    private $_fields = [];
    /** @var PhpOfficeTemplateProcessor */
    private $_processor;

    public function process() {
        $processor = new PhpOfficeTemplateProcessor($this->getTemplate());

        foreach ($this->_fields as $name => $value) {
            $processor->setValue($name, $value);
        }

        $this->_processor = $processor;

        return $this;
    }

    public function setField($name, $value) {
        $this->_fields[$name] = $value;

        return $this;
    }

    public function saveAs($outputPath) {
        $this->_processor->saveAs($outputPath);

        return $this;
    }
}
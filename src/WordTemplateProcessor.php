<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator;


use PhpOffice\PhpWord\TemplateProcessor as PhpOfficeTemplateProcessor;

class WordTemplateProcessor extends AbstractTemplateProcessor {

    private $_values = [];
    private $_rows = [];
    /** @var PhpOfficeTemplateProcessor */
    private $_processor;

    public function process() {
        $this->_setProcessor(new PhpOfficeTemplateProcessor($this->getTemplate()));
        $this->_processValues();
        $this->_processTableRows();

        return $this;
    }

    public function setValue($name, $value) {
        $this->_values[$name] = $value;

        return $this;
    }

    public function saveAs($outputPath) {
        $this->_processor->saveAs($outputPath);

        return $this;
    }

    public function addTableRow($blockWithClonedRow, $item) {
        $this->_rows[$blockWithClonedRow][] = $item;
    }

    private function _getProcessor() {
        return $this->_processor;
    }

    private function _processValues() {
        foreach ($this->_values as $name => $value) {
            $this->_getProcessor()->setValue($name, $value);
        }
    }

    private function _processTableRows() {
        foreach ($this->_rows as $rowName => $rows) {
            $this->_getProcessor()->cloneRow($rowName, count($rows));

            foreach ($rows as $cnt => $row) {
                foreach ($row as $name => $value) {
                    $this->_getProcessor()->setValue($name . '#' . ($cnt + 1), $value);
                }
            }
        }
    }

    private function _setProcessor($processor) {
        $this->_processor = $processor;
    }
}
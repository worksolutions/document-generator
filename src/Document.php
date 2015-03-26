<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator;


use WS\DocumentGenerator\Templates\AbstractTemplate;
use WS\DocumentGenerator\Templates\DocTemplate;
use WS\DocumentGenerator\Templates\DocxTemplate;
use WS\DocumentGenerator\Templates\XlsTemplate;
use WS\DocumentGenerator\Templates\XlsxTemplate;

class Document {
    const TEMPLATE_EXTENSION_DOC = 'doc';
    const TEMPLATE_EXTENSION_DOCX = 'docx';
    const TEMPLATE_EXTENSION_XLS = 'xls';
    const TEMPLATE_EXTENSION_XLSX = 'xlsx';

    private $_generator;
    private $_values = [];
    private $_valueGroups = [];

    public function __construct($template) {
        if (!$template instanceof AbstractTemplate) {
            $template = $this->_createTemplate($template);
        }

        $this->_generator = $template->createDocumentGenerator($this);
    }

    public function saveTo($path) {

        return $this->_generator->generate($path);
    }

    public function setValue($name, $value) {
        $this->_values[$name] = $value;

        return $this;
    }

    public function getValues() {
        return $this->_values;
    }

    public function addValueGroup($groupName, $values) {
        $this->_valueGroups[$groupName][] = $values;

        return $this;
    }

    public function getValueGroups() {
        return $this->_valueGroups;
    }

    /**
     * @param $template
     * @return AbstractTemplate
     * @throws Exception
     */
    private function _createTemplate($template) {
        $extension = pathinfo($template, PATHINFO_EXTENSION);

        switch ($extension) {
            case self::TEMPLATE_EXTENSION_DOC:
                return new DocTemplate($template);

                break;

            case self::TEMPLATE_EXTENSION_DOCX:
                return new DocxTemplate($template);

                break;

            case self::TEMPLATE_EXTENSION_XLS:
                return new XlsTemplate($template);

                break;

            case self::TEMPLATE_EXTENSION_XLSX:
                return new XlsxTemplate($template);

                break;
        }

        throw new Exception(sprintf('Unknown template extension: %s', $extension));
    }
}
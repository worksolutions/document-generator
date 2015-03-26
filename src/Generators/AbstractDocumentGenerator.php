<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Generators;


use WS\DocumentGenerator\Document;
use WS\DocumentGenerator\Templates\AbstractTemplate;

abstract class AbstractDocumentGenerator {

    private $_template;
    private $_document;

    public function __construct(Document $document, AbstractTemplate $template) {
        $this->_document = $document;
        $this->_template = $template;
    }

    abstract public function generate($path);

    protected function getDocument() {
        return $this->_document;
    }

    protected function getTemplate() {
        return $this->_template;
    }
}
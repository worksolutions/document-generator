<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Templates;


use WS\DocumentGenerator\Document;
use WS\DocumentGenerator\Generators\AbstractDocumentGenerator;

abstract class AbstractTemplate {

    private $_path;

    public function __construct($path) {
        $this->_path = $path;
    }

    /**
     * @param Document $document
     * @return AbstractDocumentGenerator
     */
    abstract public function createDocumentGenerator(Document $document);

    public function getPath() {
        return $this->_path;
    }
}
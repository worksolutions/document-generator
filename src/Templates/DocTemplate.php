<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Templates;


use WS\DocumentGenerator\Document;
use WS\DocumentGenerator\Generators\AbstractDocumentGenerator;
use WS\DocumentGenerator\Generators\DocDocumentGenerator;

class DocTemplate extends AbstractTemplate {

    /**
     * @param Document $document
     * @return AbstractDocumentGenerator
     */
    public function createDocumentGenerator(Document $document) {
        return new DocDocumentGenerator($document, $this);
    }
}
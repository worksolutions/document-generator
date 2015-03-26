<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Templates;


use WS\DocumentGenerator\Document;
use WS\DocumentGenerator\Generators\AbstractDocumentGenerator;
use WS\DocumentGenerator\Generators\DocxDocumentGenerator;

class DocxTemplate extends AbstractTemplate {

    /**
     * @param Document $document
     * @return AbstractDocumentGenerator
     */
    public function createDocumentGenerator(Document $document) {
        return new DocxDocumentGenerator($document, $this);
    }
}
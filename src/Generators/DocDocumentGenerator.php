<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Generators;


use PhpOffice\PhpWord\IOFactory;
use WS\DocumentGenerator\Templates\DocTemplate;
use WS\DocumentGenerator\Templates\DocxTemplate;

class DocDocumentGenerator extends AbstractDocumentGenerator {
    const READER_MS_DOC = 'MsDoc';
    const WRITER_WORD_2007 = 'Word2007';

    public function generate($path) {
        $document = $this->getDocument();

        /** @var DocTemplate $template */
        $template = $this->getTemplate();
        $docxTemplatePath = tempnam(sys_get_temp_dir(), '');
        $docxTemplate = $this->_convertTemplateToDocx($template, $docxTemplatePath);

        $docxGenerator = new DocxDocumentGenerator($document, $docxTemplate);
        $docxGenerator->generate($path);

        unlink($docxTemplatePath);
    }

    /**
     * @param DocTemplate $docTemplate
     * @param $docxTemplatePath
     * @return DocxTemplate
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    private function _convertTemplateToDocx(DocTemplate $docTemplate, $docxTemplatePath) {
        $path = $docTemplate->getPath();

        $phpWord = IOFactory::load($path, self::READER_MS_DOC);
        $docxWriter = IOFactory::createWriter($phpWord, self::WRITER_WORD_2007);

        $docxWriter->save($docxTemplatePath);
    }
}
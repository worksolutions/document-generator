<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator\Generators;


use PhpOffice\PhpWord\TemplateProcessor;

class DocxDocumentGenerator extends AbstractDocumentGenerator {

    public function generate($path) {
        $document = $this->getDocument();
        $template = $this->getTemplate();

        $templateProcessor = new TemplateProcessor($template->getPath());

        foreach ($document->getValues() as $name => $value) {
            $templateProcessor->setValue($name, $value);
        }

        foreach ($document->getValueGroups() as $groupName => $groups) {
            $templateProcessor->cloneRow($groupName, count($groups));

            foreach ($groups as $groupCounter => $groupValues) {
                $templateProcessor->setValue($groupName . "#" . ($groupCounter + 1), '');

                foreach ($groupValues as $name => $value) {
                    $templateProcessor->setValue($name . "#" . ($groupCounter + 1), $value);
                }
            }
        }

        $templateProcessor->saveAs($path);
    }
}
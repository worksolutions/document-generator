<?php
/**
 * @author Smotrov Dmitriy <smotrov@worksolutions.ru>
 */

namespace WS\DocumentGenerator;


abstract class AbstractTemplateProcessor {
    private $_template;

    abstract public function saveAs($outputPath);

    public function useTemplate($template) {
        $this->_template = $template;

        return $this;
    }

    public function getTemplate() {
        return $this->_template;
    }
}
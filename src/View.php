<?php

namespace Core;

class View {

    /**
     * The render method.
     * 
     * TThis method displays the template and site's content.
     */
    static function render(string $view, array $params): void {

        // Extract controller variables
        extract($params, EXTR_SKIP);

        // Page template path.
        $content = APPLICATION_PATH . "/App/Views/$view.php";
        require_once $content;

    }

}

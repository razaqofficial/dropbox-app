<?php

namespace Config;


class Application {

    /**
     * Show or hide error messages on screen
     * 
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * The default route
     * 
     * @var boolean
     */
    const DEFAULT_ROUTE = "/home";

    const DOWNLOAD_FOLDER = __DIR__ . "/../download";

    function redirectTo()
    {
        return "redirec_to";
    }
}

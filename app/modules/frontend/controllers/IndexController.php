<?php

namespace ZPhal\Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        /**
         * HTML 头部资源
         */
        $headerCollection = $this->assets->collection("header");
        $headerCollection->addCss("themes/default/public/library/bootstrap/css/bootstrap.min.css", false,  false); // Bootstrap
        $headerCollection->addCss("themes/default/public/css/cover.css", false,  false); // Bootstrap

        /**
         * HTML尾部资源
         */
        $footerCollection = $this->assets->collection("footer");
        $footerCollection->addJs("themes/default/public/js/vendor/jquery-slim.min.js", false,  false);; // jQuery 3
        $footerCollection->addJs("themes/default/public/js/vendor/popper.min.js", false,  false);;
        $footerCollection->addJs("themes/default/public/library/bootstrap/js/bootstrap.min.js", false,  false);;
        $footerCollection->addJs("themes/default/public/js/ie10-viewport-bug-workaround.js", false,  true);;
    }

}


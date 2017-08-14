<?php

namespace ZPhal\Modules\Admin\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        /**
         * HTML 头部资源
         */
        $headerCollection = $this->assets->collection("header");
        $headerCollection->addCss("public/library/bootstrap/css/bootstrap.min.css", false,  false); // Bootstrap
        $headerCollection->addCss("public/library/font-awesome/css/font-awesome.min.css", false,  false); // Font Awesome
        $headerCollection->addCss("public/library/Ionicons/css/ionicons.min.css", false,  false);  // Ionicons
        $headerCollection->addCss("public/library/AdminLTE/css/AdminLTE.min.css", false,  false); // Theme style
        $headerCollection->addCss("public/library/AdminLTE/css/skins/_all-skins.min.css", false,  false); // AdminLTE Skins

        /**
         * HTML尾部资源
         */
        $footerCollection = $this->assets->collection("footer");
        $footerCollection->addJs("public/library/jquery/jquery.min.js", false,  false);; // jQuery 3
        $footerCollection->addJs("public/library/bootstrap/js/bootstrap.min.js", false,  false); // Bootstrap 3.3.7
        $footerCollection->addJs("public/library/jquery-slimscroll/jquery.slimscroll.min.js", false,  false); // SlimScroll
        $footerCollection->addJs("public/library/fastclick/lib/fastclick.js", false,  false); // FastClick
        $footerCollection->addJs("public/library/AdminLTE/js/adminlte.min.js", false,  false); // AdminLTE App
        $footerCollection->addJs("public/library/AdminLTE/js/demo.js", false,  false); // AdminLTE for demo purposes
    }
}


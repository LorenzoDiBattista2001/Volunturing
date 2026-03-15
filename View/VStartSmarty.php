<?php

class VStartSmarty {
    
    public static function configuration() {
        $smarty = new \Smarty\Smarty();

        $smarty->setTemplateDir(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR);
        $smarty->setCompileDir(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'templates_c' . DIRECTORY_SEPARATOR);
        $smarty->setConfigDir(__DIR__ . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR);
        $smarty->setCacheDir(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR);

        $smarty->assign('css_path', CSS_PATH);
        $smarty->assign('js_path', JS_PATH);

        return $smarty;
    }
}

?>
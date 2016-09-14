<?php
/**
 * Created by PhpStorm.
 * User: Tuane
 * Date: 2016/09/14
 * Time: 8:49 PM
 */

class Template {


    /**
     * Include our page class, and build a page object
     * to manage the content and structure of the page
     * Template constructor.
     * @param Registry object our registry object
     */
    public function __construct( Registry $registry) {

        $this->registry = $registry;
        include (FRAMEWORK_PATH . '/Registry/page.class.php'); // Framework not defined yet
        $this->page = new Page($this->registry);
    }


    /**
     * Set the content of the pages based on number of templates
     * pass template file locations as individual arguments
     */
    public function buildFromTemplates() {

        $bits = func_get_args();
        $content = "";
        foreach ( $bits as $bit ) {

            if (strpos( $bit, 'views/' )=== false){
                $bit = 'views/' .$this->registry->getSetting('view') .'/template/' .$bit;
            }
            if (file_exists($bit) == true ){
                $content .= file_get_contents( $bit );
            }
        }
        $this->page->setContent($content);
    }

    /**
     * Add a template bit from a view to our page
     *
     * @param $tag String tag where we insert the template e.g {hello}
     * @param $bit String template bit (path to file, or just the filename)
     */
    public function addTemplateBit( $tag, $bit ) {

        if (strpos( $bit, 'views/' ) === false ) {

            $bit = 'views/' .$this->registry->getSetting('view') .'/templates/' .$bit;
        }
        $this->page->addTemplateBit( $tag, $bit );
    }


    /**
     * Take the template bits from the view and insert them into our page content
     * Updates the page content
     */
    private function replaceBits() {

        $bits = $this->page->getBits();
        // loop through template bits
        foreach ( $bits as $tag => $template) {

            $templateContent = file_get_contents( $template );
            $newContent = str_replace(
                '{' .$tag . '}', $templateContent, $this->page->getContent()
            );
            $this->page->setContent( $newContent);
        }
    }

    /**
     * Replace tags in our page with content
     * @param bool $pp check for pptags
     */
    private function replaceTags( $pp = false) {

        // get the tags in the page
        if ($pp == false) {
            $tags = $this->page->getTags();
        }else{

            $tags = $this->page->getPPTags();
        }

        // go through them all
        foreach ( $tags as $tag => $data ) {

            // if the tag is an array, then we need to do more than a simple find and replace!
            if ( is_array( $data )) {

                if ( $data[0] == 'SQL') {

                    // It is a cached query...replace tags from the database
                    $this->replaceDBTAgs( $tag, $data[1]);
                }elseif ($data[0] == 'DATA'){

                    // it it some cached data... replace tags from cached data
                    $this->replaceDataTags( $tag, $data[1]);
                }
            }else {
                // replace the content
                $newContent = str_replace('{' .$tag .'}', $data, $this->page->getContent());

            }
        }
    }
}
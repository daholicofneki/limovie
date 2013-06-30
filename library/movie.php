<?php
/**
 * Movie Class
 */

class Movie {

    private $content;
    private $text = '';


    /**
     * Set content from imdb
     */
    private function setContent($url)
    {
        // EXEC CURL
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_USERAGENT, '0123');
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_REFERER, $url);

        // set content variabel
        $this->content = curl_exec($process);

        // close curl connection
        curl_close($process);
    }


    /**
     * Find string position in given content
     */
    protected function getPosition($content, $search, $offset = false)
    {
        if ($post = strpos($content, $search, $offset)) {
            return $post;
        } else {
            return false;
        }
    }


    /**
     * To knowing does the movie already has synopsis or not
     */
    public function isSynopsys($id) {

        $is_synopsys = false;
        $url = 'http://www.imdb.com/title/'. $id .'/synopsis';

        // Retrieve 
        $this->setContent($url);
        $scopeStart = '<div id="swiki_body">';
        $scopeEnd = '<div class="display" style="margin-top: 8px">';

        if ($start = $this->getPosition($this->content, $scopeStart)) {
            if ($end = $this->getPosition($this->content, $scopeEnd, $start)) {
                $this->text = substr($this->content, $start, ($end - $start));
                $is_synopsys = strpos($this->text, 'Add a Synopsis');
            }
        }

        return !$is_synopsys;
    }


    /**
     * Get synopsis content
     */
    public function getSynopsis($id) {
        $this->isSynopsys($id);

        $string = new Translate();
        $this->text = $string->convert($this->text);

        return $this->text;
    }


    /**
     * Remove html tag
     */
    private function clean($text)
    {
        $text = preg_replace(
        array(
            // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',

            // Add line breaks before & after blocks
            '@<((br)|(hr))@iu',
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );

        // Remove all remaining tags and comments and return.
        return strip_tags( $text );
    }

}
<?php
/**
 * Movie Class
 */

class Movie {


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

        $is_synopsis = false;
        $string = '';
        $url = 'http://www.imdb.com/title/'. $id .'/synopsis';

        // Retrieve 
        $this->setContent($url);

        $scopeStart = '<div id="swiki_body">';
        $scopeEnd = '</div>






</div>


</div>';

        if ($start = $this->getPosition($this->content, $scopeStart)) {
            if ($end = $this->getPosition($this->content, $scopeEnd, $start)) {
                $string = substr($this->content, $start, ($end - $start));
            }
        }

        return var_dump($this->setContent($url));

    }

}
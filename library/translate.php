<?php
/**
 * Translate Class
 * http://rupeshpatel.wordpress.com/2012/06/23/usage-of-google-translator-api-for-free/
 */

class Translate extends Movie {

    function convert($word, $lang_from = 'en', $lang_to =' in')
    {
        $text = '';
        $word = explode('. ', $word);

        for($i = 0; $i < count($word); $i++)
        {
            $text .= $this->convert_word($word[$i], $lang_from, $lang_to);
        }
        return $text;
    }

    private function convert_word($word, $lang_from = 'en', $lang_to =' in') 
    {
        $word = urlencode($word) .'.';
        $url = 'http://translate.google.com/translate_a/t?client=t&text='. $word .'&hl='.$lang_from.'&sl='.$lang_from.'&tl='.$lang_to.'&ie=UTF-8&oe=UTF-8&multires=1&otf=1&ssel=3&tsel=3&sc=1';
        $name_en = $this->curl($url);
        $name_en = explode('"',$name_en);
        return $name_en[1];
    }

    function curl($url, $params = array(), $is_coockie_set = false)
    {

        if(!$is_coockie_set){
            /* STEP 1. let’s create a cookie file */
            $ckfile = tempnam ("/tmp", "CURLCOOKIE");

            /* STEP 2. visit the homepage to set the cookie properly */
            $ch = curl_init ($url);
            curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec ($ch);
        }

        $str = ''; $str_arr= array();
        foreach($params as $key => $value)
        {
            $str_arr[] = urlencode($key)."=".urlencode($value);
        }
        if(!empty($str_arr)) {
            $str = '?'.implode('&',$str_arr);
        }

        /* STEP 3. visit cookiepage.php */
        $Url = $url.$str;
        $ch = curl_init ($Url);
        curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);

        return $output;
    }

    /*
     * str_replace
     */
    function replace($text, $option = 'dot_to_char') {
        if($option == 'dot_to_char')
        {
            $text = str_replace('.', ' @#$', $text);
        } 
        else 
        {
            $text = str_replace(' @#$', '.', $text);
        }
        return $text;
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
<?php

require_once ('library/config.php');


# Get FILM record
$data = $DB->get("SELECT kode_imdb, rating_rt, rating_imdb FROM tbl_film WHERE kode_imdb != '' AND cek = 0 ORDER BY grab_time DESC", 'all');


if($data)
{
    foreach($data as $item) 
    {
        $imdb_idx =  $item->kode_imdb;

        echo $movie->isSynopsys($imdb_idx);
        exit;
# http://www.imdb.com/title/tt1480656/synopsis?ref_=tt_stry_pl
    }
}

/*
echo "<pre>";
var_dump($data);
echo "</pre>";


$a = new Translate;
$word = "
For a company that is so technologically smart with their algorithms, the reason why the Translate API came so late, and is now becoming a paid API, is because Google licenses technology for their Translate product for other companies. 
The link you showed has a quote saying about how Google did that for abuse reasons. 
People abuse Google Search and Youtube every day in mass quantities.";
echo $a->convert($word, 'en','in');
*/
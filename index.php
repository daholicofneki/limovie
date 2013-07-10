<?php

require_once ('library/config.php');

# Get FILM record
$data = $DB->get("SELECT id_film, kode_imdb, rating_rt, rating_imdb, nama_film FROM tbl_film WHERE kode_imdb != '' AND cek = 0 ORDER BY grab_time DESC", 'all');

if($data)
{
    foreach($data as $item) 
    {
        $imdb_idx =  $item->kode_imdb;

        // CEK apakah di dalam imdb id terdapt synospsy
        if($movie->isSynopsys($imdb_idx)) 
        {
        	// jika ada, maka kita perlu melakukan pengambilan data konten sinopsis
            $synopsis = $movie->getSynopsis($imdb_idx);

            $DB->query("INSERT INTO wp_posts (post_author, post_date, post_date_gmt, post_title, post_content, post_status) VALUES (1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '".mysql_real_escape_string($item->nama_film)."', '".mysql_real_escape_string($synopsis)."', 'publish')");
            $DB->query("UPDATE tbl_film SET cek = 1 WHERE id_film = '". $item->id_film ."'");
            exit;
        }
    }
}

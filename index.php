<?php

require_once ('library/config.php');

$a = new Translate;
$word = "
For a company that is so technologically smart with their algorithms, the reason why the Translate API came so late, and is now becoming a paid API, is because Google licenses technology for their Translate product for other companies. 
The link you showed has a quote saying about how Google did that for abuse reasons. 
People abuse Google Search and Youtube every day in mass quantities.";
echo $a->convert($word, 'en','in');

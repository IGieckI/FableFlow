<?php

require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/server/utilities/DbHelper.php';

function howMuchTimeLeft($date_r) {
    $date = date_create_from_format('Y-m-d H:i:s',$date_r);
    $difference = date_diff(date_create(date("Y-m-d H:i:s")), $date, FALSE);
    if ($difference->invert==1) {
        return 'expired';
    } else {
        return $difference->d . ' days';
    }

    return $difference;
}

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$html = '<div class="main-container">
        <ul>';

/* the r stands for record */
$pools_r = $db->findBy(['chapter_id'=>$_GET['chapter_id']], null, null, Tables::Pools);

$db->disconnect();

foreach($pools_r as $pool) {
    error_log($pool['title']);
    $html .=
            '<li>
                <a href="/FableFlow/src/client/post/content/pool/Pool.php?chapter_id='.$_GET['chapter_id'].'&pool_id='.$pool['pool_id'].'">
                    <article>
                    <span class="pool-title">'.$pool['title'].'
                    </span>
                    <span class="pool-expiration">'.howMuchTimeLeft($pool['expire_datetime']).'</span>
                    </article>
                </a>
            </li>';
} 

$html.= '</ul></div>';

echo $html;

?>
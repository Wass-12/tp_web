<?php

afficheLesLogs();

function afficheLesLogs(): void
{
    $logs = kiAffiche();
    if (sizeof($logs) == 0) {
        echo 'Pas de logs !';
        return;
    }
    $str = '<table border="1"><tr><td>User</td><td>Url</td><td>Date</td></tr>';
    foreach ($logs as $log){
        $user = getUserById($log['id_user'])['login'];
        $str .= '<tr>';
        $str .= '<td>';
        $str .= $user;
        $str .= '</td>';
        $str .= '<td>';
        $str .= $log['url'];
        $str .= '</td>';
        $str .= '<td>';
        $str .= date('Y:M:d H:i:s', $log['date']);
        $str .= '</td>';
        $str .= '<tr>';
    }
    $str.= '</table>';
    echo $str;
}
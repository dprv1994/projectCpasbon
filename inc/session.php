<?php
session_start();
if (isset($_SESSION['user'])) {
    switch ($_SESSION['user']['role']) {
        case '1':
            $is_logged = 'admin';
            break;

        case '2':
            $is_logged = 'editeur';
            break;
    }
}

<?php

/**
 * 改行しながら出力する
 * @param  string $str
 * @return null
 */
function eh($str) {
    echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 改行しながら出力する
 * @param  string $str
 * @return null
 */
function ehbr($str) {
    echo nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
}

?>
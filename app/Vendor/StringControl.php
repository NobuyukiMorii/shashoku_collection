<?php
/**
 * 文字操作に関する関数群
 * 以下、呼び出し方法
 * StringControl::method_name(xx, yy);
 */	
class StringControl {

	/*
	 * 前方一致
	 * StringUtils::startsWith();
	 * StringUtils::startsWithIgnoreCase();
	 * StringUtils::startsWithAny();
	 */
	public function startsWith($haystack, $needle, $ignorecase = false) {

	    $func = ($ignorecase ? 'stripos' : 'strpos');

	    foreach ((array)$needle as $value) {

	        if ($func($haystack, $value) === 0) {

	            return true;
	        }

	    }

	    return false;
	}

	/* 
	 * 後方一致
	 * StringUtils::endsWith();
	 * StringUtils::endsWithIgnoreCase();
	 * StringUtils::endsWithAny();
	 */
	public function endsWith($haystack, $needle, $ignorecase = false) {
	    $func = ($ignorecase ? 'stripos' : 'strpos');

	    $length = strlen($haystack);

	    foreach ((array)$needle as $value) {

	        $offset = $length - strlen($value);

	        if ((0 <= $offset) && ($func($haystack, $value, $offset) !== false)) {
	            return true;
	        }
	    }
	    return false;
	}

	/*
	 * 部分一致
	 */
	public function contains($haystack, $needle, $ignorecase = false) {

	    $func = ($ignorecase ? 'stripos' : 'strpos');

	    foreach ((array)$needle as $value) {

	        if ($func($haystack, $value) !== false) {

	            return true;

	        }
	    }
	    
	    return false;
	}

}
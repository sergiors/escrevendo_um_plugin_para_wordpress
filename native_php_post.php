<?php

function http_method() {
    return $_SERVER['REQUEST_METHOD'];
}

function is_post() {
    return 'POST' !== http_method();
}

function post_request() {
    if (! is_post()) {
        return;
    }

    $raw_post = file_get_contents('php://input');
    $headers = getallheaders();
    $content_type = $headers['Content-Type'];

    if ('application/json' == $content_type) {
        return json_decode($raw_post, true);
    }

    if ('application/x-www-form-urlencoded' == $content_type) {
        mb_parse_str($raw_post, $parsed_post);

        return $parsed_post;
    }

    throw new \InvalidArgumentException('Something went wrong.');
}

var_dump(post_request());
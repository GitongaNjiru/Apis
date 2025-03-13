<?php

namespace helper;

class Response
{
const STATUS_SUCCESS = 200;
const STATUS_ERROR = 400;
const STATUS_UNAUTHORIZED = 401;
const STATUS_NOT_FOUND = 404;
const STATUS_INTERNAL_ERROR = 500;
const STATUS_INTERNAL = 500;
const STATUS_BAD_REQUEST = 400;


public $status;
public $message;
public $success;
public $data;
}
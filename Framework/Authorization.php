<?php

namespace Framework;

use Framework\Session;

class Authorization
{
    public static function isOwner($resoruceId)
    {
        return Session::get('user')['id'] === $resoruceId;
    }
}

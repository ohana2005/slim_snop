<?php

/**
 * Created by PhpStorm.
 * User: alexradyuk
 * Date: 6/26/18
 * Time: 23:05
 */
interface SessionStorageInterface
{
     function _session_persist();
     function _read_session();


}
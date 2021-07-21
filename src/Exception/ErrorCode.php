<?php

namespace IotSpace\Exception;


class ErrorCode
{
    /**
     * 未知错误
     */
    const FAILED = '1001';
    /**
     * 参数错误
     */
    const OPTIONS = '1002';
    /**
     * 云接口HTTP错误
     */
    const HTTP = '1003';
    /**
     * 云接口数据错误
     */
    const DATA = '1004';
}
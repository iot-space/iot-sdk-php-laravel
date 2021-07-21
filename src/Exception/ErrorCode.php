<?php

namespace IotSpace\Exception;


class ErrorCode
{
    /**
     * 成功
     */
    const SUCCESS = 1000;
    /**
     * 系统错误
     */
    const FAILED = 1001;
    /**
     * 参数错误
     */
    const OPTIONS = 1002;
    /**
     * 云接口HTTP错误
     */
    const CLOUD_HTTP = 1003;
    /**
     * 云接口数据错误
     */
    const CLOUD_DATA = 1004;
}
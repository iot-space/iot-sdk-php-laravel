<?php


namespace IotSpace\Support;

/**
 * 萤石云门禁 远程控门指令
 * @package IotSpace\Support
 */
class DoorCmd
{
    /**
     * 开门
     */
    const OPEN = 'open';
    /**
     * 关门
     */
    const CLOSE = 'close';
    /**
     * 常开(自由)
     */
    const ALWAYS_OPEN = 'alwaysOpen';
    /**
     * 常关(禁用)
     */
    const ALWAYS_CLOSE = 'alwaysClose';
}
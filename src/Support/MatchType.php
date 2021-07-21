<?php


namespace IotSpace\Support;

/**
 * 涂鸦场景自动化 匹配类型
 * @package IotSpace\Support
 */
class MatchType
{
    /**
     * 任意条件满足触发
     */
    const ANY_CONDITION = 1;
    /**
     * 全部条件满足触发
     */
    const FULL_CONDITION = 2;
    /**
     * 自定义条件触发，需设定相关逻辑运算参数condition_rule
     */
    const CUSTOM_CONDITION = 3;
}
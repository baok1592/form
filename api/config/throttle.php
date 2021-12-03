<?php

// 中间件配置
return [
    // 缓存的键，true 表示使用来源ip
    'key' => "__CONTROLLER__/__ACTION__/__IP__",
    // 设置访问频率，此处指的是允许每分钟请求10次。默认值 null 表示不限制
    'visit_rate' => '50/m',
    // 访问受限时返回的http状态码
    'visit_fail_code' => 429,
    // 访问受限时访问的文本信息
    'visit_fail_text' => '访问频率受到限制，请稍等__WAIT__秒再试',
];
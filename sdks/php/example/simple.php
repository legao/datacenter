<?php
include '../LegaoSDK.php';
echo '<meta charset="utf-8">';

// 初始化SDK
$LgSDK = LegaoSDK::client('Haofang');
$LgSDK->setRemoteUrl('localhost/datacenter');
$LgSDK->setAppKey('JGHS897SDK78');
$LgSDK->setAppSecret('OPUO67KHH2349KHFDLFU234YSDKJ78DSA');

// 原始调用函数
$ret = $LgSDK->call('hf/users/show');

if (isset($ret['failure']))
{
    echo '数据调用失败' . '<br>';
    echo '错误信息为：' . $ret['failure']['message'];
}
else
{
    print_r($ret);
}

echo '<p>==============================</p>';

// 原始调用函数传递正确的参数
$params = array('id' => 1);
$ret = $LgSDK->call('hf/users/show', $params);

if (isset($ret['failure']))
{
    echo '数据调用失败' . '<br>';
    echo '错误信息为：' . $ret['failure']['message'];
}
else
{
    print_r($ret);
}

echo '<p>==============================</p>';

// 调用客户端函数
$ret = $LgSDK->getUsersShowByIds('1,2,3');

if (isset($ret['failure']))
{
    echo '数据调用失败' . '<br>';
    echo '错误信息为：' . $ret['failure']['message'];
}
else
{
    print_r($ret);
}

echo '<p>==============================</p>';

// 调用commands
$ret = $LgSDK->deleteUserById('1');

if (isset($ret['failure']))
{
    echo '数据调用失败' . '<br>';
    echo '错误信息为：' . $ret['failure']['message'];
}
else
{
    print_r($ret);
}


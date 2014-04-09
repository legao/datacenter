# LEGAO

乐高 - 数据中心开源框架

## 所需环境
* PHP 5.4 或更高版本

## 基本命名规范

* 类名与文件名相同，均采用大驼峰式。
* 类属性和类方法均采用小驼峰式，类常量全部大写加下划线，内部变量名不做限制（建议小写下划线）。
* 当类采用命名空间时，命名空间名采用大驼峰且应与其所在的目录名相同。
* 普通的函数名与文件名均采用全小写加下划线方式。
* 关联数组键名等，与类无关的字符串字面量建议采用全小写加下划线方式。
* 所有操作符两边均要有空格。例如 if ( ! isset($arr['key'])) 三元符：$a = $b == $c ? 1 : 2
* 代码缩进必须采用4个空格，如需使用TAB键的需要修改其TAB行为。
* 所有花括号均另起一行。
* 注释可参照现有的核心框架注释或相关DEMO，更详细的可参阅 PHP Documentor

## 应用层开发规范

* 应用层所有Facade类名均以Facade结尾，文件名与类名相同。（例如：UsersFacade.php）
* 应用层所有Query类名均以Query结尾，文件名与类名相同。（例如：UserQuery.php）
* 应用层所有Business类名均以Business结尾，文件名与类名相同。（例如：UserBusiness.php）
* Facade、Query、Buiness 的基类或超类始终应该继承自Legao\Facade、Legao\Query、Legao\Buiness 等
* URL访问建议采用下划线方式（大驼峰兼容），最终调用框架会统一转换成规范命名。

## 框架级开发规范

* 所有框架级类均应在Legao命名空间中
* 组件（生命周期流程控制类）应放置在 system/components 里
* 内核包放置在 system/core 里

以上规范是出于框架约定，为了提高系统可读性和稳定性并简化流程。未提到部分建议参考PSR编码规范。

## URL访问及路由调度

http://localhost/haofang/users/show\_batch （推荐）
或 http://localhost/haofang/Users/showBatch （不建议）

```php
class UsersFacade extends BaseFacade
{
	public function showBatch
	{

	}
}
```
与它对应的文件名为 `UsersFacade.php` 在 Facade 目录中。

## 开源协议
本项目基于 OSL3.0 协议发布
OSL: http://opensource.org/licenses/OSL-3.0
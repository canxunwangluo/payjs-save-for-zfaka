# payjs-save-for-zfaka

## 基于ZFAKA二次开发，添加PayJS支付渠道收银台模式（可保存到相册支付）

**假设你的t_config目前最大的ID为33，那么执行如下语句，否则把下面sql中的34.35改成你ID接下去的值**
1. 增加SQL
```sql
INSERT INTO `t_config` (`id`, `catid`, `name`, `value`, `tag`, `lock`, `updatetime`) VALUES
(34, 1, 'payjsredicurl', '', 'Payjs支付后跳转的页面', '1', '1546063186'),
(35, 1, 'payjspagelogo', '', 'Payjs支付时的上架logo', '1', '1546063186');
```

2. 替换application/modules/Product/controllers/Order.php
3. 替换application/library/Pay/payjswx/payjswx.php
### 关于ZFAKA，请移步：[ZFAKA](https://github.com/zlkbdotnet/zfaka)
免费、安全、稳定、高效的发卡系统，值得拥有!
演示地址：http://faka.zlkb.net/

### 关于Fork源，请移步：[payjs-for-zfaka](https://github.com/hiyouli/payjs-for-zfaka)
本库fork后自用，修改了源中的payjs对接方式，使用收银台模式支持相册支付[payjs文档](https://payjs.cn/dashboard/page/qrcode)

### 关于PayJS

+ PAYJS 旨在解决需要使用交易数据流的个人、创业者、个体户等小微支付需求，帮助开发者使想法快速转变为原型，PAYJS 自身不做收单和清算，只做微信支付个人接口对接的技术服务，具体详情请去官网了解
+ 注册链接：https://payjs.cn/ref/zmeemq

~~***【重要】通过此链接注册赠送10000豆豆***~~ **更新：活动已结束**


### 修改了哪些内容
1. 删除了其他所有支付方式接口
2. 增加了PayJS支付接口（收银台模式，支持保存到相册后扫码支付）
3. 修改了支付查询时间，由3秒变为1秒。由于原程序为了对接其他支付方式，暂时只能达到秒级，无法达到毫秒级

### 体验升级计划
由于自用，暂时没有升级计划，但有可提升空间。

1. 支付体验有待提升，可以实现支付后实时通信，但开发难度与服务器占用资源较大





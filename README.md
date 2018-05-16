# pospal
银豹收银系统 SDK

## 安装

```
composer require hanson/pospal:dev-master
```

## 文档

### 实例化

```php
$pospal = new \Hanson\Pospal\Pospal([
    'url' => 'your-url',
    'app_id' => 'your-app-id',
    'app_key' => 'your-app-key',
]);
```

### 销售单据 API

#### 单据实例

```php
$ticket = $pospal->ticket;
```

#### 查询支付方式代码

```php
$result = $ticket->allPayMethod();
```

#### 根据单据序列号查询

```php
$result = $ticket->query($sn);
```

#### 分页查询所有单据

```php
$result = $ticket->paginate([
   'startTime' => '2017-09-25 01:59:59',
   'endTime' => '2017-09-25 23:59:59',
]);
```

#### 查询所有单据

此 API 需要传入匿名函数

```php
// 默认查询昨天
$result = $ticket->all([], function ($tickets) {
    foreach($tickets as $ticket) {
        echo $ticket['sn'];
    }
});
```
# `laravel`业务框架
提供`web`框架的基础业务功能:
- 用户管理 使用[tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)认证
- 职员管理
- 菜单管理
- 权限管理
- 辅助功能
    - 通过url参数筛选列表

## 通过url参数筛选列表
基于 [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) 封装

### 自定义关键词
```php
'parameters' => [
    'include' => 'load',

    'filter' => 'search',

    'sort' => 'sort',

    'fields' => 'select',

    'append' => 'append',
],
```

### 用法
查看[基础用法](https://github.com/spatie/laravel-query-builder#usage)

#### between($><)

`test-query-builder?search[created_at$><]=2018-11-11,2018-11-16`

#### not between($!><)

`test-query-builder?search[created_at$!><]=2018-11-11,2018-11-16`

#### 数量比较
`=`需要`url`转义
- `>`:`test-query-builder?search[count$>]=1`
- `>=`:`test-query-builder?search[count$>%3d]=12`
- `<`:`test-query-builder?search[count$<]=1`
- `<=`:`test-query-builder?search[count$<%3d]=12`

#### 布尔

`test-query-builder?search[admin]=0`

`test-query-builder?search[admin]=1`

#### 数组

`test-query-builder?search[type]=one,two`

#### 排序

- 正序:`test-query-builder?sort=name`
- 倒序:`test-query-builder?sort=-name`

#### 分页

`test-query-builder?page=1&pageSize=15`

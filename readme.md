## 云麓谷后台管理

[![Join the chat at https://gitter.im/csuyy/Lobby](https://badges.gitter.im/Attendize/Attendize.svg)](https://gitter.im/csuyy/Lobby?utm_source=share-link&utm_medium=link&utm_campaign=share-link)

## 参与开发

本地搭建：
```
git clone https://github.com/yunlugu/newYlg newYlg
cd newYlg
cp .env.example .env # 请配置你的env
# 请先手动创建相应的空数据库再进行下一步
# then
composer install
php artisan ylg:install
```

弹幕使用node做后端，需单独启动,默认监听8002端口
```
cd chat
node danmaku.js
```

## Woking on

- 多语言支持
- 报名
- 角色分配
- 授权

## 功能

- 培训管理
- 与会管理
- 扫码签到
- 员工信息管理
- 弹幕

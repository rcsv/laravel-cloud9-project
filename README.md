# laravel-cloud9-project
Cloud9 のワークスペース作成が始まった後、Laravel を使用するには、ある程度の設定変更が必要になります。

## 1. PHP 7.0 へ変更する
Cloud9 で PHP を洗濯した場合の初期状態は、5.5.9 です。
下部分のコマンド領域でシェルを操作し、PHP を 7.0 に更新します。

```bash
$ php -v
PHP 5.5.9-1ubuntu4.22 (cli) (built: Aug  4 2017 19:40:28)  <- 2017-09-10 日現在の状態
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
    with Zend OPcache v7.0.3, Copyright (c) 1999-2014, by Zend Technologies
    with Xdebug v2.5.5, Copyright (c) 2002-2017, by Derick Rethans
$ sudo add-apt-repository ppa:ondrej/php
[この後 ENTER を求められるので ENTER を押す]
$ sudo apt-get update
$ sudo apt-get install libapache2-mod-php7.0
( apache 2 で php5 を使うのをやめる )
$ sudo a2dismod php5

( apache 2 で php7 を使う )
$ sudo a2enmod php7.0
$ sudo apt-get install php7.0-dom php7.0-mbstring php7.0-zip php7.0-mysql
$ php -v
PHP 7.0.23-1+ubuntu14.04.1+deb.sury.org+1 (cli) (built: Aug 31 2017 12:52:39) ( NTS )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2017 Zend Technologies
    with Zend OPcache v7.0.23-1+ubuntu14.04.1+deb.sury.org+1, Copyright (c) 1999-2017, by Zend Technologies

$ service apache2 restart
( 再起動して、有効化 )
```

## 2. Prepare Laravel 5.5 framework
すでに composer は入っているので、下記コマンドで Laravel Installer を準備する。

```bash
$ which composer
/usr/bin/composer   # すでに composer が入っている状態。
$ composer global require "laravel/installer"
```

このコマンドが実行された後は、`create-project` で構成を作成する。
PHP のバージョンに応じた最新バージョンを選択して導入が行われる。

```bash
$ composer create-project laravel/laravel <<project-name>>
// もし別のバージョンにしたかったら下記のようにする
$ composer create-project laravel/laravel <<project-name>> 5.4.* --prefer-dist
```

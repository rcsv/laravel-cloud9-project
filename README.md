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
$ composer create-project laravel/laravel [project-name]
// もし別のバージョンにしたかったら下記のようにする
$ composer create-project laravel/laravel [project-name] 5.4.* --prefer-dist
```

## 3. Run Project 
動作確認は、Run Project を押すと確認することができます。

## 4. Change DocumentRoot

Apache2 の設定ファイルを編集して、ドキュメントルートを変更します。
下記の [project-name] は前述のプロジェクト名と同じものを入力する。

```bash
/Open configure file/
$ sudo vim /etc/apache2/sites-enabled/001-cloud9.conf
<VirtualHost *:8080>
    DocumentRoot /home/ubuntu/workspace/[project-name]/public
    ...

$ service apache2 restart
$ cd [project-name]
$ composer update
```

## 5. mysql の設定
Cloud9 内部で mysql を構成することができるので、そのまま使用する。

### 5.1. .env
Laravel のディレクトリ直下にある .env の編集を編集して、mysqlと接続できるようにする。

> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=c9
> DB_USERNAME=<account name>
> DB_PASSWORD=

### 5.2. データベースとテーブル
```bash
mysql への接続
$ mysql-ctl cli
mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| c9                 | <- 目的のデータベース
| mysql              |
| performance_schema |
| phpmyadmin         |
+--------------------+
5 rows in set (0.01 sec)
mysql> use c9
Empty set (0.00 sec)

mysql> exit;
```

### 5.3. utf8mb4

Laravel 5.4 から文字列の設定に難あり。mysql では、utf8mb4 を使っていくようだが。

```bash
$ sudo vi /etc/mysql/my.cnf
[mysqld]
character-set-server=utf8mb4
[client]
default-character-set=utf8mb4
```

```mysql
mysql> show variables like 'char%' ;
+--------------------------+----------------------------+
| Variable_name            | Value                      |
+--------------------------+----------------------------+
| character_set_client     | utf8mb4                    |
| character_set_connection | utf8mb4                    |
| character_set_database   | utf8                       |
| character_set_filesystem | binary                     |
| character_set_results    | utf8mb4                    |
| character_set_server     | utf8mb4                    |
| character_set_system     | utf8                       |
| character_sets_dir       | /usr/share/mysql/charsets/ |
+--------------------------+----------------------------+
8 rows in set (0.00 sec)

mysql> ALTER DATABASE c9 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;
```
最初からある users テーブルの migration を通すため、AppServiceProvider に細工を施します。
varchar(191) にすると、通るようになります。

```php
<?php

// app/Providers/AppServiceProvider.php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema ;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191) ;
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```

## ex. git での管理
Cloud 9 の IDE から git 連携することはできませんが、terminal がそもそもあるので、
ここから gitコマンドを入力することでリポジトリに保存することができます。

```
git add . 
git commit -m "First commit"
git push -u origin master
```




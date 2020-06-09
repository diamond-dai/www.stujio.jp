# docker-compose wordpress

## 設定ファイルを編集

```
vi .env
```



## 起動

```
docker-compose up -d
docker-compose logs -f
```

## 環境に合わせて書き換える

```
COMPOSE_PROJECT_NAME=dev <= コンテナにつくプレフィックス、一意になるように修正
```

## httpdコンテナに接続

```
docker-compose exec -u www-data httpd bash
```


## 関連volumeの削除

DBも消えるので注意

```
docker-compose down -v
```

## 新規インストールについて

インストールされる条件は下記の条件を満たした場合
* WPがインストールされいない(seed/sqlにsqlが入ってない)
* install/config.yml が存在する

### 手順

install/config-sample.yml を install/config.yml にリネーム

下記を変更 admin_passwordは生成される

```
admin_email: admin@example.com
title: title
admin_user: admin_user

plugins:
  - advanced-custom-fields
  - all-in-one-seo-pack
  - classic-editor
  - custom-post-type-permalinks
  - duplicate-post
  - intuitive-custom-post-order
  - regenerate-thumbnails
  - smart-custom-fields
  - tinymce-advanced
  - wp-multibyte-patch
  - wp-serverinfo
  - wp-sweep
```
-- phpMyAdmin SQL Dump
-- version 5.2.0

-- 生成日時:2022年 11月29日

-- phpのバージョン 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE friends (
  id INT(32) PRIMARY KEY comment 'ID',
  user_id INT(32) NOT NULL comment 'ユーザID',
  friend_id INT(32) NOT NULL comment 'フレンドユーザID',
  created_at DATETIME DEFAULT current_timestamp() comment '登録日時'
);

CREATE TABLE good (
  user_id INT(32) NOT NULL comment 'ユーザID',
  post_id INT(32) NOT NULL comment 'ポストID',
  created_at DATETIME DEFAULT current_timestamp comment '登録日時'
);

CREATE TABLE post (
  id INT(32) PRIMARY KEY comment 'ID',
  user_id INT(32) NOT NULL comment 'ユーザID',
  hownice INT(32) DEFAULT 0 comment 'いいね数',
  post_image VARCHAR(255) comment 'イメージ画像',
  title VARCHAR(255) comment 'タイトル',
  text VARCHAR(512) comment 'テキスト',
  created_at DATETIME DEFAULT current_timestamp comment '登録日時',
  updated_at DATETIME DEFAULT current_timestamp on update current_timestamp comment '更新日時'
);

CREATE TABLE users (
  id INT(32) PRIMARY KEY comment 'ID',
  name VARCHAR(255) NOT NULL comment 'ユーザネーム',
  email VARCHAR(255) NOT NULL comment 'メールアドレス',
  password VARCHAR(255) NOT NULL comment 'パスワード',
  image VARCHAR(255) comment 'ユーザイメージ',
  male VARCHAR(255) DEFAULT 0 comment '男の子の数',
  female VARCHAR(255) DEFAULT 0 comment '女の子の数',
  created_at DATETIME DEFAULT current_timestamp comment '登録日時',
  updated_at DATETIME DEFAULT current_timestamp on update current_timestamp comment '更新日時',
  role INT(32) DEFAULT 1 comment '管理権限'
);

INSERT INTO users (id,name,email,password,image,role)
VALUES (1,'admin','admin@Admin123.jp','adminAdmin123','no_image',0);

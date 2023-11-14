# 使い方

## 前提

exchange_webp.phpとpackage.jsonをpublicに入れてください
その後cd で頑張ってpublic階層まで降りてください。

## PHPをインストール

install　できるPHPを探します
- brew search php 

installします
brew install php@8.0

installが完了したらパスを通します多分zch使ってると思うので

- echo 'export PATH="/opt/homebrew/opt/php@8.0/bin:$PATH"' >> ~/.zshrc
- echo 'export PATH="/opt/homebrew/opt/php@8.0/sbin:$PATH"' >> ~/.zshrc

コマンドをターミナル開いて叩いてください.終わったらターミナル再起動

- php --version
でバージョン確認して8.0が出たらさらにコマンド

- export LDFLAGS="-L/opt/homebrew/opt/php@8.0/lib"
- export CPPFLAGS="-I/opt/homebrew/opt/php@8.0/include"

これも終わったらターミナル再起動

- brew install php-gd

これがないとphpの内部関数が動かせないのでinstallしてください

## プログラムの使い方

yarnかnpmが入っていたら　good 

ターミナルを開いて
- yarn done
or
- npm done

もしくは php exchange_webp.php

お好きなやつをどうぞ

元のフォルダ名_webpが同じ階層にできてるはずです。
ログが出たら、変換したファイルサイズが大きくなってしまってるので、画像を確認してください

圧縮率品質について参考
https://1-notes.com/php-gd-compare-file-sizes-when-converting-to-webp/


## 　Node.jsの入れ方 for Mac

  Macの場合はhomebrewを使ってinstallします
  ターミナルを開いて
  - brew -v
  としたときにバージョンが出なければ入ってません入れましょう

  - /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

  そのまま貼り付けましょう貼り付けてEnterで勝手に入ります

  その後
  - brew install node 
  とすると最新node.jsが入ります。入れるとnpmはデフォルトで入ってます。
  yarnの方がnpmより実行速度が速いのでyarnも入れましょう

  - npm install -g yarn

  -gはグローバルにinstallするという意味です
  終わったら
  - yarn -v 
  とかするとyarnのバージョン1.29あたりが出力されたら完了です。お好きなパッケージなりを入れてください。

  # Node.jsの入れ方 for Windows
    Node.js公式
    - https://nodejs.org/ja/

  公式からインストーラーを落としてきます。LTSを落としましょう。
  落としてきて.minファイルがあると思うので実行したらウィザードが立ち上がるので
  デフォルトのまま実行していくと完了です。
  バージョン確認とyarn のインストールはMacと同じです。
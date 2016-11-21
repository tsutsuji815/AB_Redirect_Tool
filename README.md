# AB_Redirect_Tool
ABテスト用ツール

# 使い方
## 記事ABテスト機能
1.abredirectフォルダをwp-content/plugins/にアップロード  
2.プラグインを有効化  
3.投稿に｢AB test group｣というタクソノミーが出来ているので、
テストしたい記事同士に同じグループを追加  
4.アクセス時URLにabgroup={グループのスラッグ}を付けてアクセス  
5.同じグループの記事がランダムで表示される  

## リンクリダイレクト機能
1.リダイレクトさせたいaタグにabredirectというクラスをつける  
2.aタグのリンクがredirect.phpに置き換えられる  
3.一度redirect.phpを経由してリンク先へ飛ぶようになる  
4.記事アクセス時にcreativeというパラメータを持っていた場合、
redirect.phpまでパラメータを引き継ぐ  

## 例
http://example.com/archives/10?abgroup=a&creative=001  
上記URLにアクセスした場合  
1.AB test groupに｢a｣というスラッグものを持っているものがランダム表示  
2.記事中のabredirectクラスを持つaタグが下記のように置き換えられる  
http://example.com/wp-content/abredirect/redirect.php?url={リンク先URL}&creative=001  
3.リンク先でのリファラは上記のURLになる(はず)  

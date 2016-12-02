# AB_Redirect_Tool
ABテスト用ツール

# 更新履歴
### 1.0
リリース

### 1.0.1
redirect.phpにつくパラメータを入れ替えました

### 1.0.2
aタグ置換時末尾に記事IDを追加するようになりました  

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
http://example.com/wp-content/plugins/abredirect/redirect.php?creative=001p{記事ID}&url={リンク先URL}  
3.リンク先でのリファラは上記のURLになる(はず)  

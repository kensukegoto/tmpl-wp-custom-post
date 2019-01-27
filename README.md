# 0.目次
- 1.カスタム投稿の作成方法
- 2.カスタムタクソノミーの作成方法

# 1.カスタム投稿の作成方法

（参照）
- [[WordPress]カスタム投稿専用のカテゴリー/タグ -カスタム分類-](https://patakobo.com/2017/12/05/wordpress-12/)
- [WordPressのカスタムタクソノミー（カスタム分類）設定方法](https://liginc.co.jp/213377)
- [Codex | register post type](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_post_type)
- [Codex | register taxonomy](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_taxonomy)

---
## 使い方
```
register_post_type( $post_type, $args );
```
$post_type - 最大20文字（半角英数）<br>
$args - 引数の配列

※投稿タイプにタクソノミー（カスタム分類）を付ける場合は、必ず taxonomies 引数を使って登録してください。

---
### labels
管理画面での表示書式の設定。

- name - 投稿タイプの複数形
- singular_name - 投稿タイプの単数形

※しかし、日本語の場合は、複数形と単数形の区別が無いので同じ。

---
### exclude_from_search
カスタム投稿タイプの記事を検索結果に含める(false)、含めない場合がtrue
デフォルトでは、publicの反対の値がセットされるが、Codexでは（必須）とあるので、明示的に設定すべき？

---
### publicly_queryable
フロントエンドで post_type クエリが実行可能かどうか。例えば下記のようなクエリパラメーターの使用が可能かどうか
```
url?post_type={投稿タイプのキー}
```
※FALSE にセットすると、カスタム投稿をプレビューも表示もできなくなる

---
### show_ui
管理画面への表示。デフォルトは 'public'と同じ。**`public`が`true`ならば設定の必要は無い。**

---
### show_in_nav_menus
「外観」＞「メニュー」への表示の有無

---
### show_in_menu
「投稿」「メディア」などメニューの第一階層に置くか、どこかの第二階層に置くか。'edit.php'とすると投稿の第二階層、つまり、「投稿」＞「タグ」の次の項目として現れる。

---
### show_in_admin_bar
？？？<br>
※Codexには、「この投稿タイプを WordPress の管理バーから使えるようにするかどうか。」とあるが、trueにしてもfalseにしても使えている気がする…。

---
### menu_position
5 - 投稿の下。デフォルトは 25 - コメントの下。

---
### menu_icon
メニューに表示するアイコンのurl デフォルトは投稿と同じ。下記から選択可能。
https://developer.wordpress.org/resource/dashicons/#admin-customizer

---
### capability_type
デフォルトの post から変更することで、他のユーザーロールの編集者、作成者、寄稿者、購読者からアクセス出来なくなり、管理画面でのメニュー表示も行われない。次項の `capabilities` で詳細な権限を設定する。

---
### capabilities
どの権限を有するユーザーに編集権を与えるかなど指定。<br>
> 「詳細 WordPress」P.134

---
### map_meta_cap　
cap = capability(権限)。`meta_cap` という権限がある。<br>
特定の投稿を編集する権限があるかどうか。map_meta_cap を true にした場合（デフォルトは false です）は上記capabilitiesで次の7つの権限が指定可能になる。
（read,delete_posts,delete_private_posts,delete_published_posts,delete_others_posts,edit_published_posts,edit_private_posts）<br>
https://2inc.org/blog/2013/05/15/3244/

※falseを指定すると、admin権限グループのユーザーは新規追加は出来ても既存記事の編集が出来なくなる。

---
### supports
[`add_post_type_suppor`](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_post_type_support) を直接呼び出すエイリアス。投稿の編集画面に表示させるフィールドを指定する。

---
### register_meta_box_cb
独自のメタボックスを作成したい場合に、作成するための関数を指定する。<br>
メタボックスとは、投稿画面などで表示される、折りたたみや移動が可能な枠のことです。「カテゴリー」や「タグ」、「公開」、「カスタムフィールド」などの枠がメタボックスです。

---
### taxonomies
この投稿タイプで使用する、登録されたタクソノミーの配列（category や post_tag など）。register_taxonomy_for_object_type() を直接呼び出す代わりに使用可能。

※register_taxonomy_for_object_type()<br>
この関数は登録済みのタクソノミー（カスタム分類）を登録済みの投稿タイプへ紐付けます。

---
### has_archive
 この投稿タイプのアーカイブを有効にする。デフォルトでは、アーカイブのスラッグとして $post_type が使われる。

---
### rewrite
この投稿タイプのパーマリンクのリライト方法を変更する。<br>
- true(初期値) - $post_typeをスラッグに使う
- $args
  - slug - 'slug' => 'my_blog' とすると、この投稿タイプのパーマリンクは、`サイト名/my_blog/記事のパーマリンク` となる。デフォルトは $post_type の値。
  - with_front - パーマリンク設定を通常の投稿と違うものにする。通常の投稿を 「設定」>「パーマリンク設定」などで、サイト名/pages/%post_id% のように設定しているとすると、カスタム投稿が サイト名/pages/カスタム投稿のスラッグ/ページのスラッグ というようになってしまう。これを防ぐには `false` に設定する必要がある。
  
※falseを指定するとパーマリンクの設定が無効になり下記のようなURLとなる。<br>
http://localhost/wordpress/?post_type=blog&p=37&preview=true

---
### query_var
wp_queryに認識させるかどうか。<br>
`publicly_queryable` が `true` の時のみ有効。`example.com/?投稿スラッグ=投稿記事のスラッグ` で投稿にアクセス出来る。<br>
`true` ではなく任意の文字列を記述することで、上記の投稿スラッグを任意の文字列に変える事も出来る。

---
### can_export
この投稿タイプをエクスポート可能かどうか。デフォルトはtrue。

---
 #### permalink_epmask
 #### _builtin
 #### _edit_link

 # 2.カスタムタクソノミーの作成方法

 カテゴリーとなるかタグとなるかは、`hierarchical` が `true` か `false` か。<br>
 以下、カスタム投稿と異なる部分のみ記述。

 (参照)
 - [WordPressのカスタムタクソノミー（カスタム分類）設定方法](https://liginc.co.jp/213377)

---
## 使い方
```
register_taxonomy( $taxonomy, $object_type, $args );
```
$taxonomy - 最大32文字（半角英数と_）<br>
$object_type - どの投稿タイプと紐づけるか。カスタム投稿タイプ「blog」と紐づけたいならば、`array('blog')` とする。<br>
$args - 引数の配列

---
 ### meta_box_cb
 メタボックスを表示するためのコールバック関数を指定。`false` を指定すると投稿編集画面で、このタクソノミーに関するメタボックスが現れない。<br>
 デフォルトは、`hierarchical` が `true` ならばカテゴリー用、`false` ならばタグ用のメタボックスが現れる。

---
### show_admin_column
管理画面の投稿一覧にタイトルなどの列同様にこの項目の列を表示させるか。デフォルトは、`false` 。

---
### update_count_callback
例えば、このタクソノミーがカスタム投稿「blog」に紐づけられている場合に、「blog」の記事が追加・削除されるたびに呼ばれる関数を指定する。<br>
タグタイプのタクソノミーを利用したい場合は、コールバック関数として `_update_post_term_count` を指定する。<br>
**➡ なぜ！？**

---
### rewrite
- hierarchical - trueにすると階層化したURLを使用可能にする。デフォルトはfalse。親カテゴリーを持つような場合に有効？

---
### query_var
wp_queryに認識させるかどうか。

---
### show_in_rest
### rest_base
WordPress で REST API を使いたい場合
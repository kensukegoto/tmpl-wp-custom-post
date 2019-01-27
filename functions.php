<?php

// __(翻訳したい言葉) 翻訳結果を返す
// _x(翻訳したい言葉,文脈,辞書名)　逆引きレシピ -> P.58

// カスタム投稿
add_action('init','custom_blog_init');

function custom_blog_init(){

  $labels = array(
    'name' => _x('ブログ','post type general name'),
    'singular_name' => _x('ブログ','post type singular name'),
    'all_items' => __('投稿一覧'),
  );

  $args = array(
    'public' => true,
    'hierarchical' => false,
    'has_archive' => true
    'labels' => $labels,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'menu_position' => 5,
    'capability_type' => 'post',
    'rewrite' => true,
    // 'rewire' => array('slug'=>'blog','with_front'=>false), // パーマリンクの設定を通常の投稿と変えたい場合
    'map_meta_cap' => true,
    'supports' => array('title','editor','thumbnail','custom-fields','excerpt','trackbacks','comments','revisions','page-attributes'),
    // 'taxonomies' => array('category','post_tag'), // 通常の投稿のカテゴリーやタグを使いたい場合は有効に
    
  );

  register_post_type('blog',$args);

}

// カスタムタクソノミ
add_action('init','custom_blog_taxonomies');

function custom_blog_taxonomies(){

  $labels = array(
    'name' => _x('BLOGカテゴリー','taxonomy general name'),
    'singular_name' => _x('BLOGカテゴリー','taxonomy singular name'),
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'hierarchical'=> true, // true の場合はカテゴリーとなる
    'query_var' => true,
    // 'rewrite' => array('slug'=>'blog_cat','with_front'=>true), // デフォルトの設定で良いならば不要
  );

  register_taxonomy("blog_cat",array("blog"),$args);

  $labels = array(
    "name" => _x("BLOGタグ","taxonomy general name"),
    "singular_name" => _x("BLOGタグ","taxonomy singular name"),
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'hierarchical'=> false, // false の場合はタグとなる
    'query_var' => true,
    // 'rewrite' => array('slug'=>'blog_cat','with_front'=>true), // デフォルトの設定で良いならば不要
  );

}
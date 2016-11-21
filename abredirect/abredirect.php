<?php
/*
Plugin Name: AB Redirect Tool
Description: 記事をランダムでアレします
Version: 1.0
Author: Satoshi Ookido
License: GPL

Copyright 2016 Satoshi Ookido (email : tsutsuji815@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//タクソノミー追加
function create_abtest_tax() {
    register_taxonomy(
        'abtestgroup',
        'post',
        array(
            'label' => __( 'AB test group' ),
            'singular_label' => __( 'AB test post' ),
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'hierarchical' => false,
        )
    );
}
add_action( 'init', 'create_abtest_tax');

//URLパラメータ定義
function add_meta_query_vars( $public_query_vars ) {
    $public_query_vars[] = 'abgroup';
    $public_query_vars[] = 'creative';
    return $public_query_vars;
}
add_filter( 'query_vars', 'add_meta_query_vars' );

//ABテストグループに含まれる記事を抽出
function set_abtest_group($abgroup) {
    $abgroup_url = array();
    $abgroup_num = 0;
    $abargs = array(
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'abtestgroup',
                'field' => 'slug',
                'terms' => $abgroup,
            ),
        ),
        'order' => 'ASC',
        'orderby' => 'ID',
    );
    $abquery = new WP_Query( $abargs );
    if($abquery->have_posts()) {
        while($abquery->have_posts()) {
            $abquery->the_post();
            $abgroup_url[] = post_permalink();
        }
        $random_count = mt_rand(0,count($abgroup_url)-1);
        $random_url = $abgroup_url[$random_count];
        return $random_url;
    } else {
        return false;
    }
}

//パラメータと記事が存在する場合リダイレクト
function redirect_abpost() {
    $group = get_query_var('abgroup',null);
    $creative = get_query_var('creative',null);
    $abpost_url = set_abtest_group($group);
    if(!$group==null&&!$abpost_url==false&&!is_admin()){
        if(!$creative==null){
            $creative = '?creative='.$creative;
        }
        header('Location:'.$abpost_url.$creative);
        exit;
    }
}
add_action('wp','redirect_abpost');

//パラメータをPHPからjavascriptへ
function abparamtojs() {
    $abredirect_path = plugins_url( '', __FILE__ );
    $creative_param = get_query_var('creative',null);
    echo '<script>var abredirect_path = "'.$abredirect_path.'",creative_param = "'.$creative_param.'";</script>';
}
add_action('wp_head','abparamtojs');

function load_abredirect_js() {
    $abredirect_path = plugins_url( '', __FILE__ );
    wp_enqueue_script('AB Redirect Tool',$abredirect_path.'/abredirect.js',array('jquery'),false,true);
}
add_action('wp_enqueue_scripts','load_abredirect_js');
?>

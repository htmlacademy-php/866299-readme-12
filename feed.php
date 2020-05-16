<?php

require_once('init.php');
require_once('validation.php');

if (!isset($_SESSION['user'])) {
  header("Location: /index.php");
}
$active_page = 'feed';
$user_data = $_SESSION['user'];

$page_parameters['type'] = $_GET['type'] ?? 'all';

$posts = get_posts_for_feed($link, $user_data['id']);

if (!empty($_GET) && $page_parameters['type'] !== 'all') {
  $posts = get_posts_for_feed_by_category($link, $user_data['id'], $page_parameters['type']);
} else {
  $posts = get_posts_for_feed($link, $user_data['id']);
}

$page_content = include_template('feed-content.php', [
  'types' => posts_categories($link),
  'page_parameters' => $page_parameters,
  'posts' => $posts
]);

$layout_content = include_template('layout.php', [
  'content' => $page_content,
  'title' => 'Readme: Моя лента',
  'user_data' => $user_data,
  'active_page' => $active_page
]);

print($layout_content);
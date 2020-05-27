<?php
class EatingDisordersHolder extends Page {
	private static $allowed_children = array ('EatingDisordersArticleCategory');
	private static $has_many = array(
     	'ArticleCategories' => 'EatingDisordersArticleCategory'
    );
}
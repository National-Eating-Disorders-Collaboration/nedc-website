<?php

global $project;
$project = 'mysite';

include_once dirname(__FILE__).'/local.conf.php';

HtmlEditorConfig::get('cms')->setOption('content_css', '/themes/' . SSViewer::current_theme() . '/css/editor.css');
// HtmlEditorConfig::get('cms')->insertButtonsBefore('formatselect', 'fontselect');
HtmlEditorConfig::get('cms')->insertButtonsBefore('formatselect', 'fontsizeselect');
HtmlEditorConfig::get('cms')->insertButtonsBefore('formatselect', 'forecolor');

// Set the site locale

FulltextSearchable::enable();
i18n::set_locale('en_US');

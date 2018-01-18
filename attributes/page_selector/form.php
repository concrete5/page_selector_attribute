<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form_selector = new \Concrete\Core\Form\Service\Widget\PageSelector();
print $form_selector->selectPage($this->field('value'), $value);

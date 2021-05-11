<?php

class Validator
{
	public static function checkEmptyAuthor($author)
	{
		if (empty($author)) {
			return true;
		} else {
			return false;
		}
	}

	public static function validateAuthor($author)
	{
		$author =  trim($_POST['author']);
		if (!preg_match('/^[a-z\d_\s]{2,100}$/i', $author)) {
			return true;
		} else {
			return false;
		}
	}

	public static function checkEmptyTitle($title)
	{
		if (empty($title)) {
			return true;
		} else {
			return false;
		}
	}

	public static function validateTitle($title)
	{
		$title =  trim($_POST['title']);
		if (!preg_match('/^[a-z\d_\s]{2,100}$/i', $title)) {
			return true;
		} else {
			return false;
		}
	}

	public static function checkEmptyContent($content)
	{
		if (empty($content)) {
			return true;
		} else {
			return false;
		}
	}

	public static function validateContent($content)
	{
		$content =  trim($_POST['title']);
		if (!preg_match('/^[a-z\d_\s]{2,3000}$/i', $content)) {
			return true;
		} else {
			return false;
		}
	}
}
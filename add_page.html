<?php

// This page is used by an administrator to create a specific page of HTML content.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');

// If the user isn't logged in as an administrator, redirect them:
redirect_invalid_user('user_admin');

// Include the header file:
$page_title = 'Add a Site Content Page';
include ('./includes/header.html');

// Require the database connection:
require(MYSQL);

// For storing errors:
$add_page_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	
	// Check for a title:
	if (!empty($_POST['title'])) {
		$t = mysqli_real_escape_string($dbc, strip_tags($_POST['title']));
	} else {
		$add_page_errors['title'] = 'Please enter the title!';
	}
	
	// Check for a category:
	if (filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$cat = $_POST['category'];
	} else { // No category selected.
		$add_page_errors['category'] = 'Please select a category!';
	}

	// Check for a description:
	if (!empty($_POST['description'])) {
		$d = mysqli_real_escape_string($dbc, strip_tags($_POST['description']));
	} else {
		$add_page_errors['description'] = 'Please enter the description!';
	}
		
	// Check for the content:
	if (!empty($_POST['content'])) {
		$allowed = '<div><p><span><br><a><img><h1><h2><h3><h4><ul><ol><li><blockquote>';
		$c = mysqli_real_escape_string($dbc, strip_tags($_POST['content'], $allowed));
	} else {
		$add_page_errors['content'] = 'Please enter the content!';
	}
		
	if (empty($add_page_errors)) { // If everything's OK.
	
		// Add the page to the database:
		$q = "INSERT INTO pages (category_id, title, description, content) VALUES ($cat, '$t', '$d', '$c')";
		$r = mysqli_query ($dbc, $q);

		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Print a message:
			echo '<h4>The page has been added!</h4>';
			
			// Clear $_POST:
			$_POST = array();
			
			// Send an email to the administrator to let them know new content was added?
			
		} else { // If it did not run OK.
			trigger_error('The page could not be added due to a system error. We apologize for any inconvenience.');
		}
		
	} // End of $add_page_errors IF.
	
} // End of the main form submission conditional.

// Need the form functions script, which defines create_form_input():
require ('includes/form_functions.inc.php');
?>
<h3>Add a Site Content Page</h3>
<form action="add_page.php" method="post" accept-charset="utf-8">

	<fieldset><legend>Fill out the form to add a page of content:</legend>
	
		<p><label for="title"><strong>Title</strong></label><br /><?php create_form_input('title', 'text', $add_page_errors); ?></p>
	
	<p><label for="category"><strong>Category</strong></label><br />
	<select name="category"<?php if (array_key_exists('category', $add_page_errors)) echo ' class="error"'; ?>>
	<option>Select One</option>
	<?php // Retrieve all the categories and add to the pull-down menu:
	$q = "SELECT id, category FROM categories ORDER BY category ASC";		
	$r = mysqli_query ($dbc, $q);
		while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\"";
			// Check for stickyness:
			if (isset($_POST['category']) && ($_POST['category'] == $row[0]) ) echo ' selected="selected"';
			echo ">$row[1]</option>\n";
		}
	?>
	</select><?php if (array_key_exists('category', $add_page_errors)) echo ' <span class="error">' . $add_page_errors['category'] . '</span>'; ?></p>
	
	<p><label for="description"><strong>Description</strong></label><br /><?php create_form_input('description', 'textarea', $add_page_errors); ?></p>
	
	<p><label for="content"><strong>Content</strong></label><br /><?php create_form_input('content', 'textarea', $add_page_errors); ?></p>
	
	<p><input type="submit" name="submit_button" value="Add This Page" id="submit_button" class="formbutton" /></p>
	
	</fieldset>

</form> 

<script type="text/javascript" src="/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "content",
		theme : "advanced",
		width : 800,
		height : 400,
		plugins : "advlink,advlist,autoresize,autosave,contextmenu,fullscreen,iespell,inlinepopups,media,paste,preview,safari,searchreplace,visualchars,wordcount,xhtmlxtras",

		// Theme options
		theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,removeformat,|,search,replace,|,cleanup,help,code,preview,visualaid,fullscreen",
		theme_advanced_buttons2 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|,bullist,numlist,|,outdent,indent,blockquote,|,sub,sup,cite,abbr",
		theme_advanced_buttons3 : "hr,|,link,unlink,anchor,image,|,charmap,emotions,iespell,media",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "/css/styles.css",

	});
</script>
<!-- /TinyMCE -->

<?php /* PAGE CONTENT ENDS HERE! */

// Include the footer file to complete the template:
include ('./includes/footer.html');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?= htmlentities($website) ?> | admin</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<link type="text/css" rel="stylesheet" href="<?= $HOME ?>css/admin.css" media="screen" />
	<script type="text/javascript" src="<?= $HOME ?>js/tinymce/tiny_mce.js"></script>
	<script type="text/javascript">
	function init() {
		tinyMCE.init({
			mode: "textareas",
			skin: "cirkuit",
			content_css: "<?= $HOME ?>css/page.css",
			popup_css_add: "<?= $HOME ?>css/admin.css",
			plugins: "safari, table, inlinepopups",
			theme: "advanced",
			theme_advanced_path: false,
			theme_advanced_statusbar_location: "",
			theme_advanced_toolbar_location: "top",
			theme_advanced_toolbar_align: "left",
			theme_advanced_buttons1: 
				"styleselect, formatselect, forecolor, !backcolor, separator," +
				"bold, italic, underline, strikethrough, separator," +
				"justifyleft, justifycenter, justifyright, justifyfull, separator," +
				"bullist, indent, outdent, separator," +
				"image, link, unlink, anchor, hr, separator," +
				"table, cell_props, row_after, delete_row, col_after, delete_col, merge_cells, split_cells, separator," +
				"code",
			theme_advanced_buttons2: "",
			theme_advanced_buttons3: "",
			theme_advanced_blockformats: "h1, h2, h3, p, pre",
			theme_advanced_styles: "big=big; code=code; smallcaps=smallcaps; tag=tag; border=border",
			theme_advanced_text_colors: "",
			theme_advanced_background_colors: "",
			valid_elements: "*[*]",
			extended_valid_elements: "embed[src|controller|width|height|loop|autoplay]",
			apply_source_formatting: true,
			onchange_callback: "on_changed",
		}); <?= 
		$script? "\n\t\t".$script."" : ""; ?><?= 
		$message? "\n\t\talert('".htmlentities($message)."');" : ""; // Error message as a popup.
		?> 
	}
	var changed = false;
	function on_changed(editor) {
		changed = true; document.getElementById("save").className = "hilite"; 
	}
	function on_select(page) {
		if (changed==false || confirm("Page has unsaved changes. Continue?") == true) {
			window.location.href = page!=""? "?edit="+page : "?new";
		}
	}
	function on_delete(page) {
		if (page != "" && confirm("Delete /"+page+" ?") == true) {
			window.location.href = "?delete="+page;
		}
	}
	function on_validate(form) {
		if (form.page.value == "") {
			form.page.focus(); alert("Choose a name for this page."); return false;
		}
		return true;
	}
	function on_rename() {
		document.forms[0].page.focus();
		document.getElementById("save").className = "hilite";
	}
	</script>
</head>
<body id="editor" class="admin" onload="javascript:init();">
	<form method="post" action="?save" onsubmit="javascript:return on_validate(this);">
		<textarea name="content"><?= htmlentities($content) ?></textarea>
		<div id="dock">
			<div>
				<?= $HOME ?>&nbsp;<input type="text" name="page" value="<?= htmlentities($page) ?>" />
				<input type="submit" accesskey="S" value="Save" id="save" />
				<input type="button" accesskey="D" value="Delete" onclick="javascript:on_delete('<?= htmlentities($page) ?>');" />
			</div>
			<div class="right">
				<a href="./<?= htmlentities($page) ?>" target="_blank">View page</a>:
				<select onchange="javascript:on_select(this.options[this.selectedIndex].value);">
					<option value=""></option><? 
					foreach (pages() as $p) {
						$s = $p==$page? " selected=\"selected\"" : "";
						echo "\n\t\t\t\t\t<option value=\"".htmlentities($p)."\"".$s.">".htmlentities($p)."</option>";
					} 
					echo "\n"; ?>
				</select>
				<input type="button" accesskey="N" value="New" onclick="javascript:on_select('');" />
			</div>
		</div>
	</form>
</body>
</html>
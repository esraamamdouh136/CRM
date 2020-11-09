/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'Ar';
	// config.uiColor = '#AADC6E';
	// %REMOVE_START%
	config.plugins =
		'colorbutton,' +
		'font,' +
		'format,' +
		'horizontalrule,' +
		'htmlwriter,' +
		'indentlist,' +
		'indentblock,' +
		'justify,' +
		'pagebreak,' +
		'pastefromgdocs,' +
		'pastefromword,' +
		'pastetext,' +
		'resize,' +
		'selectall,' +
		'showborders,' +
		// 'smiley,' +
		'stylescombo,' +
		'undo,' +
		'wysiwygarea';
	// %REMOVE_END%
};

// %LEAVE_UNMINIFIED% %REMOVE_LINE%

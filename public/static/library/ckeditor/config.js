/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		// { name: 'forms' },
		{ name: 'others' },
		'/',
		{ name: 'styles' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'colors' },
		{ name: 'tools' },
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.language = 'zh-cn';
	config.skin ='bootstrapck';


	// config.filebrowserImageUploadUrl = '?m=admin&c=account&a=upload&type=ckeditor&id=&model=';
	/*var pathName = location.pathname;
	var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
	var phpself = pathName.substring(pathName.substr(1).indexOf('/') + 1, pathName.substr(1).indexOf('.php') + 5);

	var domain = location.protocol + '//' + window.location.host + projectName + phpself + '/';*/

	var pathName = location.pathname;
	var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
	var phpself = pathName.substring(
	    pathName.substr(1).indexOf('/') + 1,
	    pathName.substr(1).indexOf('.php') + 5
	    ) + '/';
	if (window.location.host == 'localhost') {
	    var domain = location.protocol + '//' + window.location.host + projectName + phpself;
	} else {
	    var domain = location.protocol + '//' + window.location.host + '/';
	}

	config.filebrowserImageUploadUrl = domain + 'account/upload.shtml?type=ckeditor&id=&model=';
};

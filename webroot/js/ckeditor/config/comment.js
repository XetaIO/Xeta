/**
 * CKEditor config for comment on blog.
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'en';
	config.toolbar = [
		{ name : 'font', items: [ 'Format', 'FontSize' ] },
		{ name: 'styles', items: [ 'Bold', 'Italic', 'Underline' ] },
		{ name: 'color', items: [ 'Forecolor' ] },
		{ name : 'lists', items: [ 'NumberedList', 'BulletedList' ] },
		{ name : 'link', items: [ 'Link', 'Unlink' ] },
		{ name : 'media', items: [ 'Image' ] },
		{ name : 'others', items: [ 'Blockquote', 'pbckcode', 'Smiley' ] },
		{ name : 'editor', items: [ 'Preview', 'Source' ] }
	];

	config.extraPlugins = 'pbckcode';

	config.removePlugins = 'scayt,contextmenu,liststyle,tabletools,forms';

	config.removeDialogTabs = 'image:advanced;image:Link;link:advanced;link:target';

	config.smiley_descriptions = [
		'3D','arf','bibine','cafe','chef','claque',
		'clin-doeil','clopeur','clown','d','diable','facepalm',
		'finger','france','google','heureux','hihi','huh',
		'langue','love','love2','mechant','ninja','o_o','ok',
		'omg','panic','papy','pleure','police','prieer','rire','salut',
		'shock','siffle','smile','soldat','taureau','triste',
		'troll','tusors','unsure','voleur','x)','xd','yeah','youpi','zozor'
	];

	config.smiley_images = [
		'3D.png','arf.gif','bibine.png','cafe.gif','chef.gif','claque.gif',
		'clin-doeil.png','clopeur.gif','clown.gif','d.png','diable.gif','facepalm.gif',
		'finger.gif','france.png','google.png','heureux.png','hihi.png','huh.png',
		'langue.png','love.gif','love2.gif','mechant.png','ninja.gif','o_o.gif','ok.gif',
		'omg.gif','panic.gif','papy.gif','pleure.gif','police.png','prieer.gif','rire.gif','salut.gif',
		'shock.png','siffle.png','smile.png','soldat.gif','taureau.gif','triste.png',
		'troll.png','tusors.gif','unsure.gif','voleur.gif','x).gif','xd.gif','yeah.gif','youpi.gif','zozor.gif'
	];

	config.fontSize_sizes = '8/8px;10/10px;12/12px;14/14px;16/16px;18/18px;24/24px;36/36px;';

	config.format_tags = 'p;h1;h2;h3;h4;h5';

	config.pbckcode = {
		cls : '',
		highlighter : 'PRETTIFY',
		modes : [ ['HTML', 'html'], ['CSS', 'css'], ['PHP', 'php'], ['JavaScript', 'javascript'] ],
		theme : 'tomorrow',
		tab_size : '4'
	};
};

/**
 * CKEditor config for comment on blog.
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'en';

	config.toolbar = [
		{ name: 'styles', items: [ 'Bold', 'Italic', 'Underline' ] },
		{ name : 'link', items: [ 'Link', 'Unlink' ] },
		{ name : 'others', items: [ 'Smiley' ] },
		{ name : 'editor', items: [ 'Preview', 'Source' ] }
	];

	config.height = '60px';

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
};

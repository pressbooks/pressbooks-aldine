( function () {
	tinymce.create( 'tinymce.plugins.aldine_call_to_action', {
		init: function ( editor, url ) {
			editor.addButton( 'aldine_call_to_action', {
				title: aldine.call_to_action.title,
				icon: 'icon dashicons-flag',
				onclick: function () {
					editor.windowManager.open( {
						title: aldine.call_to_action.title,
						body: [
							{
								type: 'textbox',
								name: 'text',
								label: aldine.call_to_action.text,
								value: aldine.call_to_action.title,
							},
							{
								type: 'textbox',
								name: 'link',
								label: aldine.call_to_action.link,
								value: '#',
							},
						],
						onsubmit: function ( e ) {
							editor.insertContent(
								'[aldine_call_to_action text="' +
									e.data.text +
									'" link="' +
									e.data.link +
									'"]'
							);
						},
					} );
				},
			} );
		},
		createControl: function ( n, cm ) {
			return null;
		},
	} );
	tinymce.PluginManager.add(
		'aldine_call_to_action',
		tinymce.plugins.aldine_call_to_action
	);
} )();

/* eslint-disable no-unused-vars */
( function () {
	tinymce.create( 'tinymce.plugins.aldine_page_section', {
		/**
		 * @param editor
		 * @param url
		 */
		init: function ( editor, url ) {
			editor.addButton( 'aldine_page_section', {
				title: aldine.page_section.title,
				icon: 'icon dashicons-layout',
				/**
				 *
				 */
				onclick: function () {
					editor.windowManager.open( {
						title: aldine.page_section.title,
						body: [
							{
								type: 'textbox',
								name: 'title',
								label: aldine.page_section.title_label,
								value: aldine.page_section.title,
							},
							{
								type: 'listbox',
								name: 'variant',
								label: 'Variant',
								values: [
									{
										text: aldine.page_section.standard,
										value: '',
									},
									{
										text: aldine.page_section.accent,
										value: 'accent',
									},
									{
										text: aldine.page_section.bordered,
										value: 'bordered',
									},
									{
										text: aldine.page_section.borderless,
										value: 'borderless',
									},
								],
								value: '', // Sets the default
							},
						],
						/**
						 * @param e
						 */
						onsubmit: function ( e ) {
							editor.insertContent(
								'[aldine_page_section title="' +
									e.data.title +
									'" variant="' +
									e.data.variant +
									'"]<p>Insert your page section content here.</p>[/aldine_page_section]'
							);
						},
					} );
				},
			} );
		},
		/**
		 * @param n
		 * @param cm
		 */
		createControl: function ( n, cm ) {
			return null;
		},
	} );
	tinymce.PluginManager.add(
		'aldine_page_section',
		tinymce.plugins.aldine_page_section
	);
} )();

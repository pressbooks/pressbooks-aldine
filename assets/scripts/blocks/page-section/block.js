/* eslint-disable no-restricted-globals */
( function ( blocks, i18n, element, _ ) {
	let el = element.createElement;

	wp.blocks.registerBlockType( 'aldine/page-section', {
		title: i18n.__( 'Page Section', 'pressbooks-aldine' ),

		icon: 'flag',

		category: 'layout',

		attributes: {
			title: {
				type:     'array',
				source:   'children',
				selector: 'h2',
			},
			content: {
				type:     'array',
				source:   'children',
				selector: 'p',
			},
		},

		edit: function ( props ) {
			let focusedEditable = props.focus
				? props.focus.editable || 'title'
				: null;
			let attributes = props.attributes;

			return el(
				'div',
				{ className: props.className },
				el( blocks.Editable, {
					tagName:     'h2',
					className:   'page-section__title',
					inline:      false,
					placeholder: i18n.__(
						'About Pressbooks',
						'pressbooks-aldine'
					),
					value:    attributes.title,
					onChange: function ( value ) {
						props.setAttributes( { title: value } );
					},
					focus:   focusedEditable === 'title' ? focus : null,
					onFocus: function ( focus ) {
						props.setFocus(
							_.extend( {}, focus, { editable: 'title' } )
						);
					},
				} ),
				el( blocks.Editable, {
					tagName:     'p',
					className:   'page-section__content',
					inline:      false,
					placeholder: i18n.__(
						'Kogi ennui ugh plaid, hella neutra kitsch cloud bread next level twee taiyaki. Live-edge paleo fixie whatever farm-to-table snackwave, meditation fam man braid next level viral. Four loko waistcoat mustache cloud bread activated charcoal food truck pabst roof party ugh kitsch raw denim edison bulb man braid 8-bit try-hard. Activated charcoal put a bird on it tilde meggings farm-to-table coloring book. Before they sold out four dollar toast stumptown actually.',
						'pressbooks-gutenberg'
					),
					value:    attributes.content,
					onChange: function ( value ) {
						props.setAttributes( { content: value } );
					},
					focus:   focusedEditable === 'content' ? focus : null,
					onFocus: function ( focus ) {
						props.setFocus(
							_.extend( {}, focus, { editable: 'content' } )
						);
					},
				} ),
				el(
					'p',
					{ classname: 'page-section__cta' },
					el( blocks.Editable, {
						tagName:     'a',
						className:   'call-to-action',
						inline:      false,
						placeholder: i18n.__( 'Learn More', 'pressbooks-aldine' ),
						value:       attributes.cta,
						onChange:    function ( value ) {
							props.setAttributes( { cta: value } );
						},
						focus:   focusedEditable === 'cta' ? focus : null,
						onFocus: function ( focus ) {
							props.setFocus(
								_.extend( {}, focus, { editable: 'cta' } )
							);
						},
					} )
				)
			);
		},
		save: function ( props ) {
			let attributes = props.attributes;

			return el(
				'div',
				{ className: props.className },
				el(
					'h2',
					{ className: 'page-section__title' },
					attributes.title
				),
				el(
					'p',
					{ className: 'page-section__content' },
					attributes.content
				),
				el(
					'p',
					{ classname: 'page-section__cta' },
					el( 'a', { classname: 'call-to-action' }, attributes.cta )
				)
			);
		},
	} );
} )( window.wp.blocks, window.wp.i18n, window.wp.element, window._ );

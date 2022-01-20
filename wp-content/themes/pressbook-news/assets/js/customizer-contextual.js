wp.customize.bind( 'ready', function() {

	['header', 'footer'].forEach( function( context ) {
		// Contextual: Carousel Posts Source.
		wp.customize( ( 'set_' + context + '_carousel[source]' ), function( value ) {
			var setupControl = function( source ) {

				return function( control ) {
					var setActiveState, isDisplayed;

					isDisplayed = function() {
						return ( source === value.get() );
					};

					setActiveState = function() {
						control.active.set( isDisplayed() );
					};

					control.active.validate = isDisplayed;
					setActiveState();
					value.bind( setActiveState );
				};

			};

			wp.customize.control( ( 'set_' + context + '_carousel[categories]' ), setupControl( 'categories' ) );
			wp.customize.control( ( 'set_' + context + '_carousel[tags]' ), setupControl( 'tags' ) );
		} );
	} );

} );

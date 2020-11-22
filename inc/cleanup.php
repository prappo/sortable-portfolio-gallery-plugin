<?php

function spg_term_radio_checklist( $args ) {
	if ( ! empty( $args['taxonomy'] ) && $args['taxonomy'] === 'portfolio_categories' /* <== Change to your required taxonomy */ ) {
		if ( empty( $args['walker'] ) || is_a( $args['walker'], 'Walker' ) ) { // Don't override 3rd party walkers.
			if ( ! class_exists( 'WPSE_139269_Walker_Category_Radio_Checklist' ) ) {
				/**
				 * Custom walker for switching checkbox inputs to radio.
				 *
				 * @see Walker_Category_Checklist
				 */
				class SPG_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
					function walk( $elements, $max_depth, ...$args ) {
						$output = parent::walk( $elements, $max_depth, ...$args );
						$output = str_replace(
							array( 'type="checkbox"', "type='checkbox'" ),
							array( 'type="radio"', "type='radio'" ),
							$output
						);

						return $output;
					}
				}
			}

			$args['walker'] = new SPG_Walker_Category_Radio_Checklist;
		}
	}

	return $args;
}

add_filter( 'wp_terms_checklist_args', 'spg_term_radio_checklist' );
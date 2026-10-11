<?php
/**
 * c-fields.php
 * Render custom field sections on the single listing page.
 *
 * @var $form       Form
 * @var $listing_id int
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use Rtcl\Models\Form\Form;
use Rtcl\Services\FormBuilder\FBField;
use Rtcl\Services\FormBuilder\FBHelper;

if ( ! is_a( $form, Form::class ) ) {
	return;
}

$listing_id = get_the_ID();

// Section IDs to exclude.
$exclude_section_ids = [
	'food_menu',
	'doctor_chamber',
];

// -------------------------------------------------------------------------
// Build a UUID-indexed map of ONLY custom fields.
// Index by BOTH the key used in $this->fields (what sections columns store)
// AND the 'uuid' value inside the field data — so lookup works regardless
// of whether they match.
// -------------------------------------------------------------------------
$custom_fields_map = [];

// Primary: from getFieldAsGroup — correct single_view / archive_view data.
if ( method_exists( $form, 'getFieldAsGroup' ) ) {
	$raw_custom = $form->getFieldAsGroup( FBField::CUSTOM );
	if ( is_array( $raw_custom ) ) {
		foreach ( $raw_custom as $cf_data ) {
			if ( ! is_array( $cf_data ) ) {
				continue;
			}
			if ( ! empty( $cf_data['uuid'] ) ) {
				$custom_fields_map[ (string) $cf_data['uuid'] ] = $cf_data;
			}
		}
	}
}

// Secondary: also index by the raw key in $this->fields (used by getFieldByUuid).
// This covers cases where the key differs from the 'uuid' value in the data.
$all_raw_fields = method_exists( $form, 'getFields' ) ? (array) $form->getFields() : [];
foreach ( $all_raw_fields as $field_key => $field_data ) {
	if ( ! is_array( $field_data ) ) {
		continue;
	}
	// Skip preset (built-in) fields.
	if ( ! empty( $field_data['preset'] ) && $field_data['preset'] == 1 ) {
		continue;
	}
	$key_str = (string) $field_key;
	if ( ! isset( $custom_fields_map[ $key_str ] ) ) {
		$custom_fields_map[ $key_str ] = $field_data;
	}
}

if ( empty( $custom_fields_map ) ) {
	return;
}

// -------------------------------------------------------------------------
// Get sections for layout.
// -------------------------------------------------------------------------
$sections = [];
if ( method_exists( $form, 'getSections' ) ) {
	$sections = $form->getSections();
} elseif ( isset( $form->sections ) ) {
	$sections = $form->sections;
}
$sections = is_array( $sections ) ? $sections : [];

$fieldData      = '';
$rendered_uuids = [];

if ( ! empty( $sections ) ) {
	ob_start();

	foreach ( $sections as $section ) {

		// Normalise section id.
		$section_id = '';
		if ( is_array( $section ) && isset( $section['id'] ) ) {
			$section_id = (string) $section['id'];
		} elseif ( is_object( $section ) && isset( $section->id ) ) {
			$section_id = (string) $section->id;
		}

		// Skip excluded sections — but mark their fields as handled so the
		// fallback block doesn't render them either.
		if ( $section_id !== '' && in_array( $section_id, $exclude_section_ids, true ) ) {
			$excl_columns = [];
			if ( is_array( $section ) && isset( $section['containers'] ) ) {
				$excl_columns = $section['containers'];
			} elseif ( is_object( $section ) && isset( $section->containers ) ) {
				$excl_columns = (array) $section->containers;
			}
			if ( empty( $excl_columns ) ) {
				if ( is_array( $section ) && isset( $section['columns'] ) ) {
					$excl_columns = $section['columns'];
				} elseif ( is_object( $section ) && isset( $section->columns ) ) {
					$excl_columns = (array) $section->columns;
				}
			}
			foreach ( (array) $excl_columns as $excl_col ) {
				$excl_fields = [];
				if ( is_array( $excl_col ) && isset( $excl_col['fields'] ) ) {
					$excl_fields = (array) $excl_col['fields'];
				} elseif ( is_object( $excl_col ) && isset( $excl_col->fields ) ) {
					$excl_fields = (array) $excl_col->fields;
				}
				foreach ( $excl_fields as $excl_uuid ) {
					$rendered_uuids[] = (string) $excl_uuid;
				}
			}
			continue;
		}

		// Section title.
		$section_title = '';
		if ( is_array( $section ) && isset( $section['title'] ) ) {
			$section_title = (string) $section['title'];
		} elseif ( is_object( $section ) && isset( $section->title ) ) {
			$section_title = (string) $section->title;
		}

		// Section CSS class (stored as 'css_class' in section data).
		$section_container_class = '';
		if ( is_array( $section ) && isset( $section['css_class'] ) ) {
			$section_container_class = (string) $section['css_class'];
		} elseif ( is_object( $section ) && isset( $section->css_class ) ) {
			$section_container_class = (string) $section->css_class;
		}
		// Fallback for older data that used 'container_class'.
		if ( $section_container_class === '' ) {
			if ( is_array( $section ) && isset( $section['container_class'] ) ) {
				$section_container_class = (string) $section['container_class'];
			} elseif ( is_object( $section ) && isset( $section->container_class ) ) {
				$section_container_class = (string) $section->container_class;
			}
		}

		// Containers/columns (stored as 'containers' in new form builder).
		$columns = [];
		if ( is_array( $section ) && isset( $section['containers'] ) ) {
			$columns = $section['containers'];
		} elseif ( is_object( $section ) && isset( $section->containers ) ) {
			$columns = (array) $section->containers;
		}
		// Fallback for older data that used 'columns'.
		if ( empty( $columns ) ) {
			if ( is_array( $section ) && isset( $section['columns'] ) ) {
				$columns = $section['columns'];
			} elseif ( is_object( $section ) && isset( $section->columns ) ) {
				$columns = (array) $section->columns;
			}
		}

		if ( empty( $columns ) || ! is_array( $columns ) ) {
			continue;
		}

		$section_columns = count( $columns );
		$col_items_html  = array_fill( 0, $section_columns, '' );

		foreach ( $columns as $col_index => $col ) {
			$col_fields = [];
			if ( is_array( $col ) && isset( $col['fields'] ) ) {
				$col_fields = (array) $col['fields'];
			} elseif ( is_object( $col ) && isset( $col->fields ) ) {
				$col_fields = (array) $col->fields;
			}

			if ( empty( $col_fields ) ) {
				continue;
			}

			foreach ( $col_fields as $field_uuid ) {
				$field_uuid = (string) $field_uuid;
				if ( empty( $field_uuid ) ) {
					continue;
				}

				$field_def = $custom_fields_map[ $field_uuid ] ?? null;
				if ( empty( $field_def ) ) {
					continue;
				}

				$field = new FBField( $field_def );

				if ( ! $field->isSingleViewAble() ) {
					continue;
				}

				$value = $field->getFormattedCustomFieldValue( $listing_id );
				if ( empty( $value ) ) {
					continue;
				}

				$icon = $field->getIconData();

				ob_start();
				?>
                <div class="rtcl-cfp-item rtcl-cfp-<?php echo esc_attr( $field->getElement() ); ?>" data-name="<?php echo esc_attr( $field->getName() ); ?>"
                     data-uuid="<?php echo esc_attr( $field->getUuid() ); ?>">
					<?php
					if ( $field->getElement() === 'url' ) {
						$nofollow = ! empty( $field->getNofollow() ) ? ' rel="nofollow"' : '';
						?>
                        <a href="<?php echo esc_url( $value ); ?>"
                           target="<?php echo esc_attr( $field->getTarget() ); ?>"<?php echo esc_html( $nofollow ); ?>><?php echo esc_html( $field->getLabel() ); ?></a>
						<?php
					} else {
						if ( ( ! empty( $icon['type'] ) && 'class' === $icon['type'] && ! empty( $icon['class'] ) ) || ! empty( $field->getLabel() ) ) {
							?>
                            <div class="rtcl-cfp-label-wrap">
								<?php
								if ( ! empty( $icon['type'] ) && 'class' === $icon['type'] && ! empty( $icon['class'] ) ) {
									?>
                                    <div class="rtcl-field-icon"><i class="<?php echo esc_attr( $icon['class'] ); ?>"></i></div>
									<?php
								}
								if ( ! empty( $field->getLabel() ) ) {
									?>
                                    <div class='cfp-label'><?php echo esc_html( $field->getLabel() ); ?></div>
									<?php
								}
								?>
                            </div>
						<?php } ?>
                        <div class="cfp-value">
							<?php
							if ( 'repeater' === $field->getElement() ) {
								$repeaterFields = $field->getData( 'fields', [] );
								if ( ! empty( $repeaterFields ) && is_array( $value ) ) {
									$repeaterItemFields = $field->getField();
									$is_collapsable     = isset( $repeaterItemFields['collapsable'] ) && $repeaterItemFields['collapsable'] == 'yes' ? 'rtcl-is-collapsable' : 'rtcl-not-collapsable';
									$layout             = isset( $repeaterItemFields['layout'] ) ? 'layout_' . $repeaterItemFields['layout'] : '';
									?>
                                    <div class="rtcl-cfp-repeater-items <?php echo esc_attr( $is_collapsable . ' ' . $layout ); ?>">
										<?php
										foreach ( $value as $rValueIndex => $rValues ) {
											?>
                                            <div class="rtcl-cfp-repeater-item">
												<?php
												foreach ( $repeaterFields as $repeaterField ) {
													$rField = new FBField( $repeaterField );
													$rValue = 'file' === $rField->getElement() ? ( ! empty( $rValues[ $rField->getName() ] )
													                                               && is_array( $rValues[ $rField->getName() ] )
														? FBHelper::getFieldAttachmentFiles( $listing_id, $rField->getField(), $rValues[ $rField->getName() ], true )
														: [] ) : ( $rValues[ $rField->getName() ] ?? '' );
													?>
                                                    <div class="rtcl-cfp-repeater-field <?php echo esc_attr( $rField->getElement() ); ?>" data-name="<?php echo esc_attr( $field->getName() ); ?>"
                                                         data-uuid="<?php echo esc_attr( $field->getUuid() ); ?>">
														<?php
														$rIcon = $rField->getIconData();
														if ( ( ! empty( $rIcon['type'] ) && 'class' === $rIcon['type'] && ! empty( $rIcon['class'] ) )
														     || ! empty( $rField->getLabel() )
														) {
															?>
                                                            <div class="rtcl-cfp-label-wrap">
																<?php
																if ( ! empty( $rIcon['type'] ) && 'class' === $rIcon['type'] && ! empty( $rIcon['class'] ) ) {
																	?>
                                                                    <div class="rtcl-field-icon"><i
                                                                                class="<?php echo esc_attr( $rIcon['class'] ); ?>"></i>
                                                                    </div>
																	<?php
																}
																if ( ! empty( $rField->getLabel() ) ) {
																	?>
                                                                    <div
                                                                            class='cfp-label'><?php echo esc_html( $rField->getLabel() ); ?></div>
																	<?php
																}
																?>
                                                            </div>
														<?php } ?>
                                                        <div class="cfp-value">
															<?php Functions::print_html( FBHelper::getFormattedFieldHtml( $rValue, $rField ) ); ?>
                                                        </div>
                                                    </div>
													<?php
												}
												?>
                                            </div>
											<?php
										}
										?>
                                    </div>
									<?php
								}
							} else {
								Functions::print_html( FBHelper::getFormattedFieldHtml( $value, $field ) );
							}
							?>
                        </div>
					<?php } ?>
                </div>
				<?php
				$col_items_html[ $col_index ] .= ob_get_clean();
				$rendered_uuids[] = $field_uuid;

			} // end foreach field_uuid
		} // end foreach columns

		// Only output section if at least one column has content.
		$has_any = false;
		foreach ( $col_items_html as $chtml ) {
			if ( trim( $chtml ) !== '' ) {
				$has_any = true;
				break;
			}
		}

		if ( $has_any ) {
			$section_name_class    = sanitize_title( $section_title );
			$section_wrapper_class = trim( $section_container_class . ' ' . $section_name_class );
			?>
            <div class="form-section-box <?php echo esc_attr( $section_wrapper_class ); ?>">
				<?php if ( $section_title ) : ?>
                    <h3 class="cf-section-title"><?php echo esc_html( $section_title ); ?></h3>
				<?php endif; ?>
                <div class="section-columns section-columns-<?php echo esc_attr( $section_columns ); ?>">
					<?php
					foreach ( $col_items_html as $ci => $ci_html ) {
						$col_index_num = $ci + 1;
						$col_class     = 'section-column column-' . $col_index_num;
						?>
                        <div class="<?php echo esc_attr( $col_class ); ?>">
							<?php echo wp_kses_post( $ci_html ); ?>
                        </div>
						<?php
					}
					?>
                </div>
            </div>
			<?php
		}

	} // end foreach sections

	$fieldData = ob_get_clean();
}

// -------------------------------------------------------------------------
// Fallback: render any custom fields not yet covered by sections.
// Wrapped in form-section-box so theme CSS still applies.
// -------------------------------------------------------------------------
$remaining = array_diff_key( $custom_fields_map, array_flip( $rendered_uuids ) );

if ( ! empty( $remaining ) ) {
	ob_start();

	$col_items_html = '';
	foreach ( $remaining as $field_uuid => $field_def ) {
		$field = new FBField( $field_def );

		if ( ! $field->isSingleViewAble() ) {
			continue;
		}

		$value = $field->getFormattedCustomFieldValue( $listing_id );
		if ( empty( $value ) ) {
			continue;
		}

		$icon = $field->getIconData();
		ob_start();
		?>
        <div class="rtcl-cfp-item rtcl-cfp-<?php echo esc_attr( $field->getElement() ); ?>" data-name="<?php echo esc_attr( $field->getName() ); ?>"
             data-uuid="<?php echo esc_attr( $field->getUuid() ); ?>">
			<?php
			if ( $field->getElement() === 'url' ) {
				$nofollow = ! empty( $field->getNofollow() ) ? ' rel="nofollow"' : '';
				?>
                <a href="<?php echo esc_url( $value ); ?>"
                   target="<?php echo esc_attr( $field->getTarget() ); ?>"<?php echo esc_html( $nofollow ); ?>><?php echo esc_html( $field->getLabel() ); ?></a>
				<?php
			} else {
				if ( ( ! empty( $icon['type'] ) && 'class' === $icon['type'] && ! empty( $icon['class'] ) ) || ! empty( $field->getLabel() ) ) {
					?>
                    <div class="rtcl-cfp-label-wrap">
						<?php
						if ( ! empty( $icon['type'] ) && 'class' === $icon['type'] && ! empty( $icon['class'] ) ) {
							?>
                            <div class="rtcl-field-icon"><i class="<?php echo esc_attr( $icon['class'] ); ?>"></i></div>
							<?php
						}
						if ( ! empty( $field->getLabel() ) ) {
							?>
                            <div class='cfp-label'><?php echo esc_html( $field->getLabel() ); ?></div>
							<?php
						}
						?>
                    </div>
				<?php } ?>
                <div class="cfp-value">
					<?php
					if ( 'repeater' === $field->getElement() ) {
						$repeaterFields = $field->getData( 'fields', [] );
						if ( ! empty( $repeaterFields ) && is_array( $value ) ) {
							$repeaterItemFields = $field->getField();
							$is_collapsable     = isset( $repeaterItemFields['collapsable'] ) && $repeaterItemFields['collapsable'] == 'yes' ? 'rtcl-is-collapsable' : 'rtcl-not-collapsable';
							$layout             = isset( $repeaterItemFields['layout'] ) ? 'layout_' . $repeaterItemFields['layout'] : '';
							?>
                            <div class="rtcl-cfp-repeater-items <?php echo esc_attr( $is_collapsable . ' ' . $layout ); ?>">
								<?php
								foreach ( $value as $rValueIndex => $rValues ) {
									?>
                                    <div class="rtcl-cfp-repeater-item">
										<?php
										foreach ( $repeaterFields as $repeaterField ) {
											$rField = new FBField( $repeaterField );
											$rValue = 'file' === $rField->getElement() ? ( ! empty( $rValues[ $rField->getName() ] )
											                                               && is_array( $rValues[ $rField->getName() ] )
												? FBHelper::getFieldAttachmentFiles( $listing_id, $rField->getField(), $rValues[ $rField->getName() ], true )
												: [] ) : ( $rValues[ $rField->getName() ] ?? '' );
											?>
                                            <div class="rtcl-cfp-repeater-field <?php echo esc_attr( $rField->getElement() ); ?>" data-name="<?php echo esc_attr( $field->getName() ); ?>"
                                                 data-uuid="<?php echo esc_attr( $field->getUuid() ); ?>">
												<?php
												$rIcon = $rField->getIconData();
												if ( ( ! empty( $rIcon['type'] ) && 'class' === $rIcon['type'] && ! empty( $rIcon['class'] ) )
												     || ! empty( $rField->getLabel() )
												) {
													?>
                                                    <div class="rtcl-cfp-label-wrap">
														<?php
														if ( ! empty( $rIcon['type'] ) && 'class' === $rIcon['type'] && ! empty( $rIcon['class'] ) ) {
															?>
                                                            <div class="rtcl-field-icon"><i
                                                                        class="<?php echo esc_attr( $rIcon['class'] ); ?>"></i>
                                                            </div>
															<?php
														}
														if ( ! empty( $rField->getLabel() ) ) {
															?>
                                                            <div
                                                                    class='cfp-label'><?php echo esc_html( $rField->getLabel() ); ?></div>
															<?php
														}
														?>
                                                    </div>
												<?php } ?>
                                                <div class="cfp-value">
													<?php Functions::print_html( FBHelper::getFormattedFieldHtml( $rValue, $rField ) ); ?>
                                                </div>
                                            </div>
											<?php
										}
										?>
                                    </div>
									<?php
								}
								?>
                            </div>
							<?php
						}
					} else {
						Functions::print_html( FBHelper::getFormattedFieldHtml( $value, $field ) );
					}
					?>
                </div>
			<?php } ?>
        </div>
		<?php
		$col_items_html .= ob_get_clean();
	}

	if ( $col_items_html ) {
		?>
        <div class="form-section-box">
            <div class="section-columns section-columns-1">
                <div class="section-column column-1">
					<?php echo wp_kses_post( $col_items_html ); ?>
                </div>
            </div>
        </div>
		<?php
	}

	$fieldData .= ob_get_clean();
}

// -------------------------------------------------------------------------
// Final output.
// -------------------------------------------------------------------------
if ( $fieldData ) :
	?>
    <div class="rtcl-single-custom-fields">
        <div class="rtcl-cf-properties">
			<?php Functions::print_html( $fieldData, true ); ?>
        </div>
    </div>
<?php
endif;

<?php
/**
 * The template for displaying search forms.
 *
 * @package ClassiList
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="custom-search-input">
		<div class="input-group">
			<input type="text" class="search-query form-control" placeholder="<?php esc_attr_e( 'Search here ...', 'classilist' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<span class="input-group-btn">
				<button class="btn" type="submit">
					<span class="fa fa-search"></span>
				</button>
			</span>
		</div>
	</div>
</form>

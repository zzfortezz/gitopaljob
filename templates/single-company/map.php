<?php 

?>
<?php

$maps     = get_post_meta(  get_the_ID(), OPALJOB_COMPANY_PREFIX . 'map', true );
$address  = get_post_meta(  get_the_ID(), OPALJOB_COMPANY_PREFIX . 'address', true );

if( isset($maps) ): ?>
<div class="company-address-map">
	<h3><?php _e( 'Company Address' , 'opalesate' ); ?></h3>
 	<div class="company-google-map-content">
 		<?php if( $address ): ?>
 		<p>
 			<i class="fa fa-map-marker"></i> <strong><?php _e('Address:','opaljob'); ?></strong> <?php echo $address; ?>. 
 			<?php 
 				$terms = wp_get_post_terms( get_the_ID(), 'opaljob_location' );
				if( $terms && !is_wp_error($terms) ){
					
					echo '<strong>'.__('Location:','opaljob').'</strong>';

					$output = '<span class="property-locations">';
					foreach( $terms as $term  ){
						$output .= $term->name;
					}
					$output .= '</span>';
					echo $output;
				}

 			?>
 		</p>

 		<?php endif; ?>
 		<div id="company-map" style="height:400px" data-latitude="<?php echo (isset($maps['latitude']) ? $maps['latitude'] : ''); ?>" data-longitude="<?php echo (isset($maps['longitude']) ? $maps['longitude'] : ''); ?>" data-icon="<?php echo esc_url(OPALJOB_CLUSTER_ICON_URL);?>"></div>
 	</div>	
</div>	 	
<?php endif ?>
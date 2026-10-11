<?php
/**
 * Social profiles
 *
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var int   $post_id
 * @var array $social_profiles
 */

use Rtcl\Helpers\Functions;
use Rtcl\Resources\Options;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!Functions::is_enable_social_profiles() || empty($classilist_social_list = Options::get_social_profiles_list()))
    return;
?>
    <div class="rtcl-post-social-profiles-urls rtcl-post-section<?php echo esc_attr(is_admin() ? " rtcl-is-admin" : '') ?>">
        <div class="rtcl-post-section-title">
            <h3>
                <i class="rtcl-icon rtcl-icon-share"></i><?php esc_html_e("Social Profiles", "classilist"); ?>
            </h3>
        </div>
        <?php
        foreach ($classilist_social_list as $classilist_item_key => $classilist_item) {
            ?>
            <div class="row">
                <div class="col-12 <?php echo is_admin() ? 'col-sm-2' : 'col-sm-3'; ?>">
                    <label for="rtcl-social-<?php echo esc_attr($classilist_item_key) ?>"
                           class="control-label"><?php echo esc_html($classilist_item); ?></label>
                </div>
                <div class="col-12 <?php echo is_admin() ? 'col-sm-10' : 'col-sm-9'; ?>">
                    <div class="form-group">
                        <input type="url" class="form-control" id="rtcl-social-<?php echo esc_attr($classilist_item_key) ?>"
                               name="rtcl_social_profiles[<?php echo esc_attr($classilist_item_key) ?>]"
                               value="<?php echo !empty($social_profiles[$classilist_item_key]) ? esc_url($social_profiles[$classilist_item_key]) : '' ?>"
                        />
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php



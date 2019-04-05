<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$_TT_SETTINGS_MENU_SLUG = "tallytoo-settings";

require_once( plugin_dir_path(__FILE__) . './settings_registration.php');
require_once( plugin_dir_path(__FILE__) . './settings_paywall.php');
require_once( plugin_dir_path(__FILE__) . './settings_donatewall.php');
require_once( plugin_dir_path(__FILE__) . './settings_donateinline.php');
require_once( plugin_dir_path(__FILE__) . './settings_display.php');
require_once( plugin_dir_path(__FILE__) . './settings_advanced.php');

/**
 * Add tallytoo top-level menu
 */
function tallytoo_plugin_menu_page()
{
    // Add tallytoo menu
    global $tt_settings_page;
    $tt_settings_page = add_menu_page(
        null,         // Page title
        "tallytoo (beta)",                 // Menu title
        "manage_options",           // Capability
        $GLOBALS["_TT_SETTINGS_MENU_SLUG"],        // Menu slug
        "tallytoo_options_page_html",       // Callback
        plugin_dir_url(__FILE__).'../../images/tallytoo-logo.png',        // Icon
        20      // Position
    );

    // Add subsections
    tt_register_settings_registration_page($GLOBALS["_TT_SETTINGS_MENU_SLUG"]);
    tt_register_settings_paywall_page($GLOBALS["_TT_SETTINGS_MENU_SLUG"]);
    tt_register_settings_donatewall_page($GLOBALS["_TT_SETTINGS_MENU_SLUG"]);
    tt_register_settings_donateinline_page($GLOBALS["_TT_SETTINGS_MENU_SLUG"]);
    tt_register_settings_display_page($GLOBALS["_TT_SETTINGS_MENU_SLUG"]);
    tt_register_settings_advanced_page($GLOBALS["_TT_SETTINGS_MENU_SLUG"]);

    // TODO: Admin security settings
    // TODO: Localisation settings

    add_action( 'admin_head-'. $tt_settings_page, 'tt_main_admin_head' );
  }


function tt_main_admin_head() {
    $css = file_get_contents(plugin_dir_path(__FILE__) .'../templates/main/main.css');
    echo '<style type="text/css">'.$css.'</style>';
}

add_action('admin_menu', 'tallytoo_plugin_menu_page');

function tallytoo_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    ?>

    <div class="wrap">

        <div class="tt_img_title">
            <img src="<?php echo plugin_dir_url(__FILE__).'../../images/tallytoo_no_background_all.svg' ?>">
            <img class="tt_beta" src="<?php echo plugin_dir_url(__FILE__).'../../images/beta.svg' ?>">
        </div>
        <div class="tt_main_box">

        <p><?php _e("Thanks for installing the tallytoo pay- donate- wall plugin", 'tallytoo-wall'); ?></p>
        <p><?php _e("This plugin allows you to easily use the tallytoo button to monetise your content", 'tallytoo-wall'); ?></p>
        <p><?php _e("You can find detailed instructions on setting up this plugin at <a href='https://tallytoo.com/publishers/integration/wordpress-plugin-tallytoo-wall/' target='_blank'>here</a>." , 'tallytoo-wall'); ?></p>
        <p><?php _e("We suggest that you first go to <a href='https://tallytoo.com/publishers' target='_blank'>tallytoo.com</a> for a full explanation of how tallytoo works, and to see a demo.", 'tallytoo-wall'); ?></p>
        <br>
        <div class="tt_beta_box">
          <p><?php _e("The tallytoo service as well as this plugin is in <strong>beta</strong>. Please don't hesitate to send us information about bugs, your feedback, or suggestions to <a href='mailto:support@tallytoo.com'>support@tallytoo.com</a>. Please be as explicit as possible, including as much information as possible.", 'tallytoo-wall'); ?></p>
        </div>
        

            <!-- 
            <h1>Get started</h1>
            <p>You need to follow a few steps to integrate tallytoo into your website:</p>
            <ol>
                <li>Register for free as a publisher at the <a href="<?php echo tt_getPublisherSignup(); ?>" target="_blank">tallytoo publisher portal</a> (if you have already done so, you can <a href="<?php echo tt_getPublisherPortal(); ?>" target="_blank">log-in here</a>)</li>
                <li>Tallytoo will get in touch with you to validate your details, and you'll get notified once your account has been activated.</li>
                <li>Once your account is activated, you need to set up a few details for security reasons:
                    <ol>
                        <li>In the tallytoo publisher portal, navigate to <strong>Integration</strong></li>
                        <li>Specify the domain of this website, including the protocol (for example, https://acme.com )</li>
                        <li>Generate an Api-Key. </li>
                        <li>Copy this key into <strong>Publisher API key</strong> in the <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-registration"); ?>">registration options screen</a>.</li>
                    </ol>
                </li>
                <li>At first creation, your tallytoo account is deactivated. This is to allow you to test the integration, without the service going live. In order to test the integration without activating your account: 
                    <ol>
                        <li>In the tallytoo publisher portal, navigate to <strong>Test Users</strong></li>
                        <li>Create a test user with and without points</li>
                        <li>You can log in as this test user by clicking "Impersonate" and by logging in using the test user's password</li>
                    </ol>
                </li>                    
            </ol>
            <p>You are now ready to test the integration of tallytoo on your website!</p>
            <p>If you are logged in as a test-user, you can now navigate to the <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-paywall"); ?>">paywall configuration</a> to see how the paywall looks. If all is correctly configured, you should see the blue tallytoo button integrated into the paywall: </p>
            <div class="tt_img_cont">
              <img src="<?php echo plugin_dir_url(__FILE__).'../../images/paywall_config.png' ?>">
            </div>
            <p>If you do not see the blue tallytoo button, there is something wrong with your configuration. Open the javascript console of your navigator to get the precise reason.</p>
              
            <h1>Test your first private post</h1>
            <p>We recommend thoroughly testing tallytoo pay- or donate-wall integration on a private page or post. To do so, create a post, and mark it's access as private only.</p>
            <p>
              While editing your post, you will notice a box entitled <strong>Protect with tallytoo</strong>.
            </p>    
            <div class="tt_img_cont">
              <img src="<?php echo plugin_dir_url(__FILE__).'../../images/paywall_post.png' ?>">
            </div>         
            <p>Choose the type of protection you wish:</p>
            <ul>
              <li><strong>Free access (default)</strong>: this content is not protected by tallytoo</li>
              <li><strong>Pay-wall</strong>: The pay-wall will be shown, entirely preventing access to that post until a payment has been made.</li>
              <li><strong>Donate-wall</strong>: The donate-wall will be shown, asking the user nicely to donate, but allowing him or her to bypass and get free access anyway</li>
              <li><strong>Donate-inline</strong>: Provide full access to the article, but intersperse with a request to donate a tallytoo point</li>
            </ul>               
            <p>The pay-wall, donate-wall and inline donate box each can be entirely customised in this plugin's settings. You will need to provide the custom html and css.</p>
            <p>By default, the pay-wall and donate-wall will prevent access to the entire post. However, you can show a certain amount of content by inserting the short-code <strong>[tallytoo-protect]</strong> into your text. All content up to that point will be included, and the paywall inserted just after. All subsequent content will be removed from the post.</p>
            <div class="tt_img_cont">
              <img src="<?php echo plugin_dir_url(__FILE__).'../../images/paywall_shortcode.png' ?>">
            </div>  
            <p>For the inline donate-wall, the short-code <strong>[tallytoo-donate]</strong> will indicate where to place the donation message and the tallytoo button. Otherwise, it will appear at the end of the article.</p>
            <p>We strongly recommend that you test your integration in two scenarios: </p>
            <ul>
              <li><strong>The test user has no points</strong>: Be sure to test the process of earning points. The tallytoo overlay should cover the screen and present ads. If your website has unusual html and body settings, the overlay may not work correctly. In this extreme case, you may <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-registration"); ?>">show the ad overlay as a popup</a> (not recommended)</li>
              <li><strong>The test user has points</strong>: The points should appear on the tallytoo button, and a click will provide subsequent full access to the content.</li>
            </ul>

            <h1>Customise your walls and the tallytoo button</h1>
            <p>You are totally free to customise the different pay-walls by providing your own html and css:</p>
            <ul>
              <li><strong>Pay-wall</strong>: Customise <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-paywall"); ?>">here</a></li>
              <li><strong>Donate-wall</strong>: Customise <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-donatewall"); ?>">here</a></li>
              <li><strong>Donate-inline</strong>: Customise <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-donateinline"); ?>">here</a></li>
              <li><strong>Tallytoo button</strong>: Customise <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-display"); ?>">here</a></li>
            </ul>   

            <h1>Activate your account</h1>
            <p>Once you are satisfied with your integration, return to the tallytoo publisher portal and activate your account. You will now start earning cash as your users spend their points on your site!</p>
            <p>The tallytoo publisher portal provides you with up-to-date information of your current earnings. Once a month, tallytoo will issue a statement, and pay you the sum accumulated in your account.</p>

            <h1>Important ! Don't lock out your readers!</h1>
            <p>Tallytoo is a <strong>best effort</strong> monetisation system. We will try our best to provide ads for your user-base. However, the case may arise where no ads match your user's profile, and that user has no accumulated points.</p>
            <p>In this case, unless you have an alternative payment method in place, your user will not be able to access your locked content.</p>
            <p>In this worst case scenario, we recommend that you activate the <strong>Allow free access</strong> option in the <a href="<?php echo admin_url("admin.php?page=tallytoo-settings-registration"); ?>">registration options screen</a>. Activated by default, this option will automatically detect this worst case, and reload the page with full access, thereby ensuring that your users are never locked out.</p>
            -->
        </div>
        
    </div>


    <?php
}


?>
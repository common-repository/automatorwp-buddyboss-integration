<?php
/**
 * Add User Group
 *
 * @package     AutomatorWP\Integrations\BuddyBoss\Actions\Add_User_Group
 * @author      AutomatorWP <contact@automatorwp.com>, Ruben Garcia <rubengcdev@gmail.com>
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AutomatorWP_BuddyBoss_Add_User_Group extends AutomatorWP_Integration_Action {

    public $integration = 'buddyboss';
    public $action = 'buddyboss_add_user_group';

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        automatorwp_register_action( $this->action, array(
            'integration'       => $this->integration,
            'label'             => __( 'Add user to group', 'automatorwp-buddyboss' ),
            'select_option'     => __( 'Add user to <strong>group</strong>', 'automatorwp-buddyboss' ),
            /* translators: %1$s: Group. */
            'edit_label'        => sprintf( __( 'Add user to %1$s', 'automatorwp-buddyboss' ), '{group}' ),
            /* translators: %1$s: Group. */
            'log_label'         => sprintf( __( 'Add user to %1$s', 'automatorwp-buddyboss' ), '{group}' ),
            'options'           => array(
                'group' => automatorwp_utilities_ajax_selector_option( array(
                    'field'             => 'group',
                    'option_default'    => __( 'group', 'automatorwp-buddyboss' ),
                    'name'              => __( 'Group:', 'automatorwp-buddyboss' ),
                    'option_none'       => false,
                    'option_custom'         => true,
                    'option_custom_desc'    => __( 'Group ID', 'automatorwp-buddyboss' ),
                    'action_cb'         => 'automatorwp_buddyboss_get_groups',
                    'options_cb'        => 'automatorwp_buddyboss_options_cb_group',
                    'placeholder'       => __( 'Select a group', 'automatorwp-buddyboss' ),
                    'default'           => '',
                ) )
            ),
        ) );

    }

    /**
     * Action execution function
     *
     * @since 1.0.0
     *
     * @param stdClass  $action             The action object
     * @param int       $user_id            The user ID
     * @param array     $action_options     The action's stored options (with tags already passed)
     * @param stdClass  $automation         The action's automation object
     */
    public function execute( $action, $user_id, $action_options, $automation ) {

        // Shorthand
        $group_id = $action_options['group'];

        // Bail if group not provided
        if( absint( $group_id ) === 0 ) {
            return;
        }

        // Add the user to the group
        groups_join_group( $group_id, $user_id );

    }

}

new AutomatorWP_BuddyBoss_Add_User_Group();
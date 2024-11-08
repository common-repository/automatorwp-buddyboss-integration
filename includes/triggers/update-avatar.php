<?php
/**
 * Update Avatar
 *
 * @package     AutomatorWP\Integrations\BuddyBoss\Triggers\Update_Avatar
 * @author      AutomatorWP <contact@automatorwp.com>, Ruben Garcia <rubengcdev@gmail.com>
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class AutomatorWP_BuddyBoss_Update_Avatar extends AutomatorWP_Integration_Trigger {

    public $integration = 'buddyboss';
    public $trigger = 'buddyboss_update_avatar';

    /**
     * Register the trigger
     *
     * @since 1.0.0
     */
    public function register() {

        automatorwp_register_trigger( $this->trigger, array(
            'integration'       => $this->integration,
            'label'             => __( 'User updates avatar', 'automatorwp-buddyboss' ),
            'select_option'     => __( 'User updates <strong>avatar</strong>', 'automatorwp-buddyboss' ),
            /* translators: %1$s: Number of times. */
            'edit_label'        => sprintf( __( 'User updates avatar %1$s time(s)', 'automatorwp-buddyboss' ), '{times}' ),
            'log_label'         => __( 'User updates avatar', 'automatorwp-buddyboss' ),
            'action'            => 'xprofile_avatar_uploaded',
            'function'          => array( $this, 'listener' ),
            'priority'          => 10,
            'accepted_args'     => 1,
            'options'           => array(
                'times' => automatorwp_utilities_times_option(),
            ),
            'tags' => array_merge(
                automatorwp_utilities_times_tag()
            )
        ) );

    }

    /**
     * Trigger listener
     *
     * @since 1.0.0
     *
     * @param int $user_id
     */
    public function listener( $user_id ) {

        if ( empty( $user_id ) ) {
            $user_id = bp_displayed_user_id();
        }

        // BuddyBoss filter for the user ID when a user has uploaded a new avatar.
        $user_id = apply_filters( 'bp_xprofile_new_avatar_user_id', $user_id );

        // Trigger the update avatar
        automatorwp_trigger_event( array(
            'trigger'       => $this->trigger,
            'user_id'       => $user_id,
        ) );

    }

}

new AutomatorWP_BuddyBoss_Update_Avatar();
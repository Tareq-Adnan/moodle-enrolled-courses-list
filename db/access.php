<?php
defined('MOODLE_INTERNAL') || die;

$capabilities = array(

    // This allows a user to add the slack block.

    'block/enrolled_courses:addinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'guest' => CAP_PREVENT,       // Prevent Guest user.
            'user' => CAP_ALLOW,        // Prevent Authenticated user.
            'student' => CAP_ALLOW,     // Prevent Student user.
            'teacher' => CAP_PREVENT,     // Prevent teacher user.
            'editingteacher' => CAP_ALLOW,// Allow Editingteacher user.
            'coursecreator' => CAP_ALLOW, // Allow Coursecreator user.
            'manager' => CAP_ALLOW        // Allow Manager user.
        ),
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),

    // This allows a user to add slack block to their dashboard (My Moodle Page).

    'block/enrolled_courses:myaddinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'guest' => CAP_PREVENT,       // Prevent Guest user.
            'user' => CAP_ALLOW,        // Prevent Authenticated user.
            'student' => CAP_ALLOW,     // Prevent Student user.
            'teacher' => CAP_PREVENT,     // Prevent teacher user.
            'editingteacher' => CAP_ALLOW,// Allow Editingteacher user.
            'coursecreator' => CAP_ALLOW, // Allow Coursecreator user.
            'manager' => CAP_ALLOW        // Allow Manager user.
        ),
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),

    'block/enrolled_courses:viewlist' => array(

        'captype' => 'read',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'user' => CAP_ALLOW,
            'guest' => CAP_PREVENT,
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    )
);

<?php

$menuItems = [
    [
        'label' => 'Dashboard',
        'url' => 'dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'permission' => 'dashboard_view'
    ],
    [
        'label' => 'Users',
        'url' => 'users',
        'icon' => 'fas fa-user',
        'permission' => 'users_list'
    ],
    [
        'label' => 'Create Schedule',
        'url' => 'createSchedule',
        'icon' => 'fas fa-user',
        'permission' => 'create_schedule'
    ],
    [
        'label' => 'View Locations',
        'url' => 'location',
        'icon' => 'fas fa-map-marker-alt',
        'permission' => 'view_location'
    ],
    [
        'label' => 'Add Location',
        'url' => 'location/add',
        'icon' => 'fas fa-map-marker-alt',
        'permission' => 'add_location'
    ],
    [
        'label' => 'View Expenses',
        'url' => 'expenses',
        'icon' => 'fas fa-dollar-sign',
        'permission' => 'view_expense_module'
    ],
    [
        'label' => 'Add Expenses',
        'url' => 'expenses/add',
        'icon' => 'fas fa-dollar-sign',
        'permission' => 'add_expense'
    ],
    [
        'label' => 'Activity Logs',
        'url' => 'activityLogs',
        'icon' => 'fas fa-history',
        'permission' => 'activity_log_list'
    ],
    [
        'label' => 'Roles',
        'url' => 'roles',
        'icon' => 'fas fa-lock',
        'permission' => 'roles_list'
    ],
    [
        'label' => 'Permissions',
        'url' => 'permissions',
        'icon' => 'fas fa-user',
        'permission' => 'permissions_list'
    ],
    [
        'label' => 'Backup',
        'url' => 'backup',
        'icon' => 'fas fa-database',
        'permission' => 'backup_db'
    ],
    [
        'label' => 'General Settings',
        'url' => 'settings/general',
        'icon' => 'fas fa-cog',
        'permission' => 'company_settings'
    ],
    [
        'label' => 'Company Settings',
        'url' => 'settings/company',
        'icon' => 'fas fa-cog',
        'permission' => 'company_settings'
    ],
    [
        'label' => 'Email Templates',
        'url' => 'settings/email_templates',
        'icon' => 'fas fa-cog',
        'permission' => 'company_settings' // Not sure about the permission for this one
    ],
    [
        'label' => 'Onboard Settings',
        'url' => 'settings/onboarding',
        'icon' => 'fas fa-cog',
        'permission' => 'view_onboarding_steps'
    ]
];

<?php
return array(
    array(
        'module'=>'admin',
        'name' => 'Administration',
        'controller' => array(
            array(
                'description' => 'Nodes',
                'name' => 'asterisk',
                'action' => array(
                    array(
                        'desc'  => 'Index of Nodes',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View Nodes',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create Node',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update Node',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete Node',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Site/Facility',
                'name' => 'buildings',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => ' View Floors',
                        'url'   => 'viewflors',
                    ),
                    array(
                        'desc'  => 'Create Floor',
                        'url'   => 'addFloor',
                    ),
                    array(
                        'desc'  => 'Update Floor',
                        'url'   => 'updateFloor',
                    ),
                    array(
                        'desc'  => 'Delete Floor',
                        'url'   => 'deleteFloor',
                    ),
                )
            ),
            array(
                'description' => 'Calls Type',
                'name' => 'callsType',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Pendant Type',
                'name' => 'pendantType',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'MaxiVox Type',
                'name' => 'maxivoxType',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Delivery',
                'name' => 'delivery',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Save E-mail',
                        'url'   => 'mailSave',
                    ),
                    array(
                        'desc'  => 'Test E-mail',
                        'url'   => 'testEmail',
                    ),
                    array(
                        'desc'  => 'Test SMS',
                        'url'   => 'testSMS',
                    ),
                    array(
                        'desc'  => 'Save SMS',
                        'url'   => 'smsSave',
                    ),
                )
            ),
            array(
                'description' => 'Devices',
                'name' => 'devices',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Generate Form for Add',
                        'url'   => 'addNew',
                    ),
                    array(
                        'desc'  => 'Get Floor List',
                        'url'   => 'floorList',
                    ),
                    array(
                        'desc'  => 'Get Room List',
                        'url'   => 'roomList',
                    ),
                    array(
                        'desc'  => 'Add Patient',
                        'url'   => 'addPatient',
                    ),
                    array(
                        'desc'  => 'Manage Extension',
                        'url'   => 'manageExtension',
                    ),
                    array(
                        'desc'  => 'Delete Extension',
                        'url'   => 'deleteExtension',
                    ),
                    array(
                        'desc'  => 'Floor Info',
                        'url'   => 'floorInfo',
                    ),
                    array(
                        'desc'  => 'Return Room Coordonate',
                        'url'   => 'roomCoordonate',
                    ),
                )
            ),
            array(
                'description' => 'Positioning',
                'name' => 'positioning',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Generate Form for Add',
                        'url'   => 'addNew',
                    ),
                    array(
                        'desc'  => 'Get Floor List',
                        'url'   => 'floorList',
                    ),
                    array(
                        'desc'  => 'Get Room List',
                        'url'   => 'roomList',
                    ),
                    array(
                        'desc'  => 'Add Patient',
                        'url'   => 'addPatient',
                    ),
                    array(
                        'desc'  => 'Manage Extension',
                        'url'   => 'manageExtension',
                    ),
                    array(
                        'desc'  => 'Delete Extension',
                        'url'   => 'deleteExtension',
                    ),
                    array(
                        'desc'  => 'Floor Info',
                        'url'   => 'floorInfo',
                    ),
                    array(
                        'desc'  => 'Return Room Coordonate',
                        'url'   => 'roomCoordonate',
                    ),
                )
            ),
            array(
                'description' => 'Pendants',
                'name' => 'pendantDevices',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Maxivox Device',
                'name' => 'maxivoxDevice',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Export',
                'name' => 'export',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                )
            ),
            array(
                'description' => 'Calling Number',
                'name' => 'func',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'All Save',
                        'url'   => 'allSave',
                    ),
                )
            ),
            array(
                'description' => 'Global Events',
                'name' => 'globalEventTemplate',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Event List By Pick',
                        'url'   => 'eventListByPick',
                    ),
                    array(
                        'desc'  => 'Receiver List',
                        'url'   => 'receiverList',
                    ),
                )
            ),
            array(
                'description' => 'Global Events Pendant',
                'name' => 'globalEventPendantTemplate',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Event List By Pick',
                        'url'   => 'eventListByPick',
                    ),
                    array(
                        'desc'  => 'Receiver List',
                        'url'   => 'receiverList',
                    ),
                )
            ),
            array(
                'description' => 'Global Events MaxiVox',
                'name' => 'globalEventMaxivoxTemplate',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Event List By Pick',
                        'url'   => 'eventListByPick',
                    ),
                    array(
                        'desc'  => 'Receiver List',
                        'url'   => 'receiverList',
                    ),
                )
            ),
            array(
                'description' => 'System Message',
                'name' => 'globalMessages',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Commands',
                'name' => 'command',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Custom Links',
                'name' => 'customLinks',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Update EMS',
                'name' => 'updateEms',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    )
                )
            ),
            array(
                'description' => 'System Camera',
                'name' => 'systemCameras',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Floor',
                'name' => 'maps',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                    array(
                        'desc'  => 'Save image',
                        'url'   => 'saveimage',
                    ),
                )
            ),
            array(
                'description' => 'Notification Settings',
                'name' => 'notificationSettings',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Patients',
                'name' => 'patients',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Reports',
                'name' => 'reports',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Events Reports',
                'name' => 'eventsReports',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    )
                )
            ),
            array(
                'description' => 'Events Pendant Reports',
                'name' => 'eventsPendantReports',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    /*array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),*/
                )
            ),
            array(
                'description' => 'Events Maxivox Reports',
                'name' => 'eventsMaxivoxReports',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    /*array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),*/
                )
            ),
            array(
                'description' => 'CDR Reports',
                'name' => 'cdr',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                )
            ),
            array(
                'description' => 'Vodia CDR',
                'name' => 'vodiaCdr',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                )
            ),
            array(
                'description' => 'Rooms',
                'name' => 'rooms',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Staff',
                'name' => 'staff',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Staff Working Info',
                'name' => 'staffWorking',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                )
            ),
            array(
                'description' => 'Extension Inventory',
                'name' => 'extensionInventory',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Appearance',
                'name' => 'setting',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'System Emails',
                'name' => 'systemEmail',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'System Notices',
                'name' => 'systemNotice',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'System SMS Number',
                'name' => 'systemSmsNumbers',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'System Voice Number',
                'name' => 'systemVoiceNumber',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Users',
                'name' => 'users',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Events',
                'name' => 'events',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'miPositioning Events',
                'name' => 'eventsPendant',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'MaxiVox Events',
                'name' => 'eventsMaxivox',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'Vodia Manage',
                'name' => 'vodiaManage',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
            array(
                'description' => 'HTTP Inventory',
                'name' => 'httpInventory',
                'action' => array(
                    array(
                        'desc'  => 'Index',
                        'url'   => 'index',
                    ),
                    array(
                        'desc'  => 'View',
                        'url'   => 'view',
                    ),
                    array(
                        'desc'  => 'Create',
                        'url'   => 'create',
                    ),
                    array(
                        'desc'  => 'Update',
                        'url'   => 'update',
                    ),
                    array(
                        'desc'  => 'Delete',
                        'url'   => 'delete',
                    ),
                )
            ),
        ),
    ),
    array(
        'module'=>'customLinks',
        'name' => 'CustomLinks',
        'data' => 'fromDB',
        'controller' => array(
        ),
    ),
    array(
        'module'=>'api',
        'name' => 'API Zone',
        'controller' => array(
            array(
                'description' => 'Default',
                'name' => 'default',
                'action' => array(
                    '',
                    '',
                )
            ),
            array(
                'description' => 'Notification Look Up',
                'name' => 'notificationLookUp',
                'action' => array(
                    '',
                    '',
                )
            ),
        ),
    ),
    array(
        'module'=>'livepanel',
        'name' => 'Live Panel Module',
        'controller' => array(
            array(
                'description' => 'Default',
                'name' => 'default',
                'action' => array(
                    '',
                    '',
                )
            ),
            array(
                'description' => 'Live Panel',
                'name' => 'liveRequest',
                'action' => array(
                    '',
                    '',
                )
            ),
        ),
    )

);

?>
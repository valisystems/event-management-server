<?php
return array(
    /*'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null,
        'abreviation' => 'G'
    ),*/
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest', // subclass guest
        ),
        'bizRule' => null,
        'data' => null,
        'abreviation' => 'U'
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Moderator',
        'children' => array(
            'user',          // let moderation everything is permitted user
        ),
        'bizRule' => null,
        'data' => null,
        'abreviation' => 'M'
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',         // let the admin everything is permitted moderation
        ),
        'bizRule' => null,
        'data' => null,
        'abreviation' => 'A'
    ),
);
?>
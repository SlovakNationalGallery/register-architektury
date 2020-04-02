<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'architect' => [
        'title' => 'Architects',

        'actions' => [
            'index' => 'Architects',
            'create' => 'New Architect',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'source_id' => 'Source',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'birth_date' => 'Birth date',
            'birth_place' => 'Birth place',
            'death_date' => 'Death date',
            'death_place' => 'Death place',
            'bio' => 'Bio',
            
        ],
    ],

    'building' => [
        'title' => 'Buildings',

        'actions' => [
            'index' => 'Buildings',
            'create' => 'New Building',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'source_id' => 'Source',
            'title' => 'Title',
            'title_alternatives' => 'Title alternatives',
            'description' => 'Description',
            'processed_date' => 'Processed date',
            'architect_names' => 'Architect names',
            'builder' => 'Builder',
            'builder_authority' => 'Builder authority',
            'location_city' => 'Location city',
            'location_district' => 'Location district',
            'location_street' => 'Location street',
            'location_gps' => 'Location gps',
            'project_start_dates' => 'Project start dates',
            'project_duration_dates' => 'Project duration dates',
            'decade' => 'Decade',
            'style' => 'Style',
            'status' => 'Status',
            'image_filename' => 'Image filename',
            'bibliography' => 'Bibliography',
            
        ],
    ],

    'architect' => [
        'title' => 'Architects',

        'actions' => [
            'index' => 'Architects',
            'create' => 'New Architect',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'source_id' => 'Source',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'birth_date' => 'Birth date',
            'birth_place' => 'Birth place',
            'death_date' => 'Death date',
            'death_place' => 'Death place',
            'bio' => 'Bio',
            
        ],
    ],

    'image' => [
        'title' => 'Images',

        'actions' => [
            'index' => 'Images',
            'create' => 'New Image',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'source_id' => 'Source',
            'building_id' => 'Building',
            'title' => 'Title',
            'author' => 'Author',
            'created_date' => 'Created date',
            'source' => 'Source',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
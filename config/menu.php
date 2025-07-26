<?php
// config/menu.php
return [
    [
        'label' => 'Dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'route' => 'dashboard',
        'permission' => 'dashboard',
        'active_patterns' => 'dashboard*', // String tunggal
    ],
    [
        'label' => 'Master Data',
        'icon' => 'fas fa-database',
        'route' => 'master.index',
        'permission' => 'master-data',
        'active_patterns' => ['master/*'],
        'children' => [
            [
                'label' => 'Document Type',
                'icon' => 'fas fa-file',
                'route' => 'document.type.index',
                'permission' => 'manage-document-types',
                'active_patterns' => 'master/document*',
            ],
            [
                'label' => 'Penduduk',
                'icon' => 'fas fa-users',
                'route' => 'residents',
                'permission' => 'manage-residents',
                'active_patterns' => 'master/resident*',
            ],
            [
                'label' => 'Users',
                'icon' => 'fas fa-users',
                'route' => 'users',
                'permission' => 'manage-users',
                'active_patterns' => 'master/users*',
            ],
            [
                'label' => 'Role & Permission',
                'icon' => 'fas fa-user-tag',
                'route' => 'role-permission.index',
                'permission' => 'manage-roles',
                'active_patterns' => 'master/role-permission*',
            ],
        ]
    ],
    [
        'label' => 'Buat Document',
        'icon' => 'fas fa-file',
        'route' => 'document.generated.index', // Menggunakan 'url' bukan 'route'
        'permission' => 'document-create',
        'active_patterns' => 'document/generate*', // Cocokkan URL path
    ],
    [
        'label' => 'Document',
        'icon' => 'fas fa-file',
        'route' => 'document.index', // Menggunakan 'url' bukan 'route'
        'permission' => 'document-list',
        'active_patterns' => 'documents*', // Cocokkan URL path
    ],
    [
        'label' => 'Laporan',
        'icon' => 'fas fa-file',
        'route' => 'report', // Menggunakan 'url' bukan 'route'
        'permission' => 'report',
        'active_patterns' => 'report*', // Cocokkan URL path
    ],


    // tambahkan item lain sesuai kebutuhan…
];

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'teacher' => [
        'driver' => 'session',
        'provider' => 'teachers',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'teachers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Teacher::class,
    ],
],

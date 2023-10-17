<?php

Route::post('create_user', [\App\Http\Module\User\Presentation\Controller\UserController::class, 'createUser']);
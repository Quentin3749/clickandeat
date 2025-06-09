<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('peut créer un utilisateur et un ID lui est attribué automatiquement', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->id)->not->toBeNull();
});

it('vérifier que le nom d\'utilisateur est bon lors de la création', function() {
    $user = User::factory()->create([
        'name' => 'Kévin',
        'email' => 'test@test.test',
    ]);

    expect($user->name)->toBe("Kévin");
});

it('vérifier que le mot de passe soit bien haché', function() {
    $pwd = 'test';
    $hash_pwd = Hash::make($pwd);
    
    $user = User::factory()->create([
        'password' => $hash_pwd,
    ]);

    expect($user->password)->not->toBe($pwd);
    expect($user->password)->toBe($hash_pwd);
});

it('on peut changer le nom d\'un User', function(){
    $user = User::factory()->create();

    $user->name = "toto";
    $user->save();

    $userFromDatabase = User::where('id', $user->id)->first();

    expect($userFromDatabase->name)->toBe("toto");
});
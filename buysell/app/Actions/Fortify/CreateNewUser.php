<?php
namespace App\Actions\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'address' => ['required'],
//            'image' => ['required'],
            'utype' => ['required'],
            'password' => $this->passwordRules($input['utype']),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
//        return DB::transaction(function () use ($input) {
//            return tap(User::create([
//                'name' => $input['name'],
//                'email' => $input['email'],
//                'phone' => $input['phone'],
//                'address' => $input['address'],
//                'utype' => $input['utype'],
//                'password' => Hash::make($input['password']),
//            ]), function (User $user) use ($input) {
////                $this->createTeam($user);
//                if (isset($input['image'])) {
//                    $user->updateProfilePhoto($input['image']);
//                }
//            });
//        });
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'utype' => $input['utype'],
            'password' => Hash::make($input['password']),
        ]);
    }
}

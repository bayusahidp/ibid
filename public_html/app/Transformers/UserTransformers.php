<?php
namespace App\Transformers;

use App\User;
use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{
	public function transform(User $user)
	{
	    return [
	        'id' => $user->id,
	        'name' => $user->name,
	        'email' => $user->email,
            'phone' => $user->phone,
            'job' => $user->job,
	        'created_at' => $user->created_at->format('d-m-Y'),
	        'updated_at' => $user->updated_at->format('d-m-Y'),
	    ];
	}
}
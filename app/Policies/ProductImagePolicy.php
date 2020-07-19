<?php

namespace App\Policies;

use App\Product_image;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product_image  $productImage
     * @return mixed
     */
    public function view(User $user, Product_image $productImage)
    {
        return $user->id = $productImage->product->user_id;
        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product_image  $productImage
     * @return mixed
     */
    public function update(User $user, Product_image $productImage)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product_image  $productImage
     * @return mixed
     */
    public function delete(User $user, Product_image $productImage)
    {
         return $user->id === $productImage->product->user_id;
         
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product_image  $productImage
     * @return mixed
     */
    public function restore(User $user, Product_image $productImage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product_image  $productImage
     * @return mixed
     */
    public function forceDelete(User $user, Product_image $productImage)
    {
        //
    }
}

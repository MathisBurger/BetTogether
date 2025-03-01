<?php

namespace App\Policies;

use App\Models\User;

/**
 * @template T
 */
interface PolicyInterface
{
    /**
     * @param  T  $object
     */
    public function read(User $authUser, $object): bool;

    /**
     * @param  T  $object
     */
    public function create(User $authUser, $object): bool;

    /**
     * @param  T  $object
     */
    public function update(User $authUser, $object): bool;

    /**
     * @param  T  $object
     */
    public function delete(User $authUser, $object): bool;

    public static function registerOther(): void;
}

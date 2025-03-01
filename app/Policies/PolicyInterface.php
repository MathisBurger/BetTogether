<?php

namespace App\Policies;

use App\Models\User;

/**
 * @template T
 */
interface PolicyInterface
{
    /**
     * Checks if the object can be read.
     *
     * @param  T  $object
     */
    public function read(User $authUser, $object): bool;

    /**
     * Checks if the object can be created.
     *
     * @param  T  $object
     */
    public function create(User $authUser, $object): bool;

    /**
     * Checks if the object can be updated.
     *
     * @param  T  $object
     */
    public function update(User $authUser, $object): bool;

    /**
     * Checks if the object can be deleted.
     *
     * @param  T  $object
     */
    public function delete(User $authUser, $object): bool;

    public static function registerOther(): void;
}

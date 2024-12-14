<?php

namespace App\Policies;

use App\Models\User;

/**
 * @template T
 */
interface PolicyInterface
{
    /**
     * @param User $authUser
     * @param T $object
     * @return bool
     */
    public function read(User $authUser, $object): bool;
    /**
     * @param User $authUser
     * @param T $object
     * @return bool
     */
    public function create(User $authUser, $object): bool;
    /**
     * @param User $authUser
     * @param T $object
     * @return bool
     */
    public function update(User $authUser, $object): bool;
    /**
     * @param User $authUser
     * @param T $object
     * @return bool
     */
    public function delete(User $authUser, $object): bool;
    public static function registerOther(): void;
}
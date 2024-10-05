<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;

class ExpensePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    protected function checkIfOwnerOrAdmin(User $user, Expense $expense)
    {
        return $expense->user_id === $user->id || $user->isAdmin();
    }

    public function update(User $user, Expense $expense)
    {
        return $this->checkIfOwnerOrAdmin($user, $expense);
    }

    public function destroy(User $user, Expense $expense)
    {
        return $this->checkIfOwnerOrAdmin($user, $expense);
    }
}

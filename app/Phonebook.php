<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
	/**
	 * Don't auto-apply mass assignment protection.
	 * @var array
	 */
    protected $guarded = [];
}

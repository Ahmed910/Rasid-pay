<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('en', 'auth')->pluck('value', 'key'));

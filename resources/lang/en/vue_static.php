<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('en', 'dashboard')->pluck('value', 'key'));

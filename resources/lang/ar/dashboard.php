<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('ar', 'dashboard')->pluck('value', 'key'));

<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('ar', 'auth')->pluck('value', 'key'));

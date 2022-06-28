<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('en', 'mobile')->pluck('value', 'key'));

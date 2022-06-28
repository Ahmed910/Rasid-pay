<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('en', 'vue_static')->pluck('value', 'key'));


<?php

use Illuminate\Support\Arr;

return Arr::undot(db_translations('ar', 'vue_static')->pluck('value', 'key'));
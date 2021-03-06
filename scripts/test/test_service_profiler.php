#!/usr/bin/env php
<?php

/*
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$root = dirname(dirname(dirname(__FILE__)));
require_once $root.'/scripts/__init_script__.php';

// Simple test script for PhutilServiceProfiler.

PhutilServiceProfiler::installEchoListener();

phutil_require_module('phutil', 'future/exec');

execx('ls %s', '/tmp');

exec_manual('sleep %s', 1);

phutil_passthru('cat');

echo "\n\nSERVICE CALL LOG\n";
var_dump(PhutilServiceProfiler::getInstance()->getServiceCallLog());

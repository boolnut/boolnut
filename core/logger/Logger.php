<?php

namespace Boolnut\Core\Logger;

interface Logger
{
    public function info($data);

    public function error($data);
}

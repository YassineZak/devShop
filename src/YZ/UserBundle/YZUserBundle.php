<?php

namespace YZ\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class YZUserBundle extends Bundle
{
  public function getParent()
    {
        return 'FOSUserBundle';
    }
}

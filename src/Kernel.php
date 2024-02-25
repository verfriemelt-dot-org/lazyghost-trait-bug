<?php

declare(strict_types=1);

namespace sample;

use sample\SymfonyOne\SfContext;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Override;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}

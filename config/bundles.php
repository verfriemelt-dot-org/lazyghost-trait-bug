<?php

declare(strict_types=1);

use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
];

<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Controller;

use App\Shared\Presentation\Validation\ValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    use ValidationTrait;
}
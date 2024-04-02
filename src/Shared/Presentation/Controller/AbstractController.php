<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Controller;

use App\Shared\Presentation\Trait\ResponseTrait;
use App\Shared\Presentation\Trait\ValidationTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;

abstract class AbstractController extends BaseController
{
    use ValidationTrait;
    use ResponseTrait;
}
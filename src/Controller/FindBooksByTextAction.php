<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FindBooksByTextAction extends AbstractController
{
    public function __invoke(BookRepository $bookRepository): array
    {
        return $bookRepository->findOneByText('lorem');
    }
}
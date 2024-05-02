<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FindBookByCategoryAction extends AbstractController
{
    public function __invoke(BookRepository $bookRepository, Request $request): array
    {
        $categoryId = $request->query->get('categoryId');

        if (!$categoryId) {
            throw new BadRequestHttpException('Kategoriya id\'sini kiritish majburiy');
        }

        return $bookRepository->findBy(['category' => $categoryId]);
    }
}

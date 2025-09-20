<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\CharacterBuilder;
use App\DevService\ProjectDir;
use App\Entity\Proficiency;
use App\Mapper\CharacterConfigDtoMapper;
use App\Repository\ProficiencyRepository;
use App\Service\CharacterCardService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnderDevController extends AbstractController
{
    #[Route('/underDev/{side}/{filename}', 'under-dev', methods: [Request::METHOD_GET])]
    public function underDev(
        string                   $side,
        string                   $filename,
        CharacterConfigDtoMapper $characterConfigDtoMapper,
        CharacterBuilder         $characterBuilder,
        ProjectDir               $projectDir,
        CharacterCardService     $characterCardService
    ): Response
    {
        $filepath = $projectDir . '/new_input/' . $filename . '.json';

        if (file_exists($filepath)) {
            $json = file_get_contents($filepath);
            $configDto = $characterConfigDtoMapper->fromJson($json);
            $character = $characterBuilder->build($configDto);

            $side = $side === 'front'
                ? $characterCardService->getFrontpage($character)
                : $characterCardService->getBackpage($character);
        }

        return new Response(
            $side ?? $filename
        );
    }
}

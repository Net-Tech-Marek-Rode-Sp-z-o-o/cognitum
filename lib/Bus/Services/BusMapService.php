<?php

declare(strict_types=1);

namespace Component\Bus\Services;

use Component\Bus\CommandBus\CommandHandler;
use Component\Bus\Data\BusMaps;
use Component\Bus\QueryBus\QueryHandler;
use Psr\Log\LoggerInterface;
use ReflectionClass;

final readonly class BusMapService
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function getCommandMaps(): array
    {
        return $this->getMaps()->commandsMap;
    }

    public function getQueryMaps(): array
    {
        return $this->getMaps()->queriesMap;
    }

    private function getMaps(): BusMaps
    {
        return $this->generateMapsFromAutoload();
    }

    private function generateMapsFromAutoload(): BusMaps
    {
        $classes = require base_path('vendor/composer/autoload_classmap.php');

        $commandsMap = [];
        $queriesMap = [];

        foreach ($classes as $class => $path) {
            if ($this->validateClass($class, $path) === false) {
                continue;
            }

            try {
                $reflectionClass = new ReflectionClass($class);

                $commandAttributes = $reflectionClass->getAttributes(CommandHandler::class);

                if (empty($commandAttributes) === false) {
                    $commandsMap[$class] = $commandAttributes[0]->getArguments()[0];
                }

                $queryAttributes = $reflectionClass->getAttributes(QueryHandler::class);

                if (empty($queryAttributes) === false) {
                    $queriesMap[$class] = $queryAttributes[0]->getArguments()[0];
                }
            } catch (\Throwable $e) {
                $this->logger->debug($e->getMessage());

                continue;
            }
        }

        return new BusMaps(
            commandsMap: $commandsMap,
            queriesMap: $queriesMap,
        );
    }

    private function validateClass(string $class, string $path): bool
    {
        return (str_ends_with($class, 'Command') || str_ends_with($class, 'Query'))
            && str_contains($path, 'Application');
    }
}

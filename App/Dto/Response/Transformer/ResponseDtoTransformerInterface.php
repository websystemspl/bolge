<?php

declare(strict_types=1);

namespace Bolge\App\Dto\Response\Transformer;

interface ResponseDtoTransformerInterface
{
    public function transformFromObject($object);
    public function transformFromObjects(iterable $objects): iterable;
}

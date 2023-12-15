<?php

namespace App\Normalizer;

use ArrayObject;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsDecorator('api_platform.jsonld.normalizer.item')]
class ApiNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    public function __construct(
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    public function normalize($object, $format = null, array $context = []): float|array|ArrayObject|bool|int|string|null
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if (
            array_key_exists('@id', $data)
            && array_key_exists('@type', $data)
            && str_ends_with($data['@type'], 'Response')
        ) {
            $nameConverter = new CamelCaseToSnakeCaseNameConverter();

            $data['@id'] = preg_replace(
                '/' . $nameConverter->normalize($data['@type']) . 's\//',
                '',
                $data['@id']
            );
        }

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $this->normalizer->supportsNormalization($data, $format);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        if ($this->normalizer instanceof SerializerAwareInterface) {
            $this->normalizer->setSerializer($serializer);
        }
    }


}
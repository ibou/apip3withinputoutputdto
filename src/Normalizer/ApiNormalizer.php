<?php

namespace App\Normalizer;

use App\Dto\Response;
use ArrayObject;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
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

        foreach ($data as $key => $value) {
            $obj = null;
            $func = 'get' . ucfirst($key);
            if (method_exists($object, $func)) {
                $obj = $object->$func();
            }

            if (is_string($value) && $obj instanceof Response) {
                unset($data[$key]);
                $data[$key]['@id'] = $this->rewriteIri($value);
                $data[$key]['@type'] = str_replace('Response', '', ucfirst($key));

                foreach (preg_grep('/^get/', get_class_methods($obj)) as $method) {
                    $attribute = lcfirst(str_replace('get', '', $method));
                    $data[$key][$attribute] = $obj->$method();
                }
            }

            if (
                is_string($data[$key])
                && str_starts_with($key, '@')
                && str_starts_with($value, '/api/')
            ) {
                $data[$key] = $this->rewriteIri($value);
            }
        }

        foreach (preg_grep('/^get/', get_class_methods($object)) as $method) {
            $attribute = lcfirst(str_replace('get', '', $method));
            $value = $object->$method();

            if (!$value instanceof Response) {
                $data[$attribute] = $value;
            }
        }

        return $data;
    }

    private function rewriteIri(string $iri): string
    {
        return preg_replace('/^(\/\w*\/\w*\/)(\w*)\//i', '$1', $iri);
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
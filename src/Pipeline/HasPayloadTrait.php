<?php

namespace Realfa\Common\Pipeline;

/**
 * Trait HasPayloadTrait
 *
 * @package Realfa\Common\Pipeline
 */
trait HasPayloadTrait
{
    /**
     * @var string
     */
    protected $missing = "VALOR PARA [ %s ] NÃO ENCONTRADO NO CONJUNTO DE ARGUMENTOS FORNECIDOS.";

    /**
     * @var array
     */
    protected $payload = [];

    /**
     * @param string $entry
     * @param mixed $default
     *
     * @return mixed
     */
    public function optional(string $entry, $default = null)
    {
        $value = $this->payload($entry, false);

        return !is_null($value) ? $value : $default;
    }

    /**
     * @param string $entry
     *
     * @return mixed
     */
    public function required(string $entry)
    {
        return $this->payload($entry, true);
    }

    /**
     * @param string $entry
     * @param bool $hard
     *
     * @return array|mixed|null
     * @throws \Exception
     */
    public function payload(string $entry, $hard = true)
    {
        $elem = $this->payload;

        foreach (explode('.', $entry) as $prop) {
            $elem = $elem[$prop] ?? null;

            if (is_null($elem) && $hard) {
                throw new \Exception(sprintf($this->missing, $entry), 400);
            }
        }

        return $elem ?? null;
    }
}

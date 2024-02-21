<?php


namespace CodeColliders\BasicUserBundle;


use CodeColliders\BasicUserBundle\DependencyInjection\CodeCollidersBasicUserExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodeCollidersBasicUserBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new CodeCollidersBasicUserExtension();
        }
        return $this->extension;
    }
}

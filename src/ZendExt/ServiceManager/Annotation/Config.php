<?php

namespace ZendExt\ServiceManager\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY","ANNOTATION"})
 */
final class Config implements Annotation
{
    public $key;
}
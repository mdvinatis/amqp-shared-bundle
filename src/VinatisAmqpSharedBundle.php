<?php

namespace Vinatis\Bundle\AmqpSharedBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vinatis\Bundle\AmqpSharedBundle\DependencyInjection\VinatisAmqpSharedExtention;

/**
 * Class VinatisAmqpSharedBundle.
 *
 * @author Michel Dourneau <mdourneau@vinatis.com>
 */
final class VinatisAmqpSharedBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new VinatisAmqpSharedExtention();
    }
}

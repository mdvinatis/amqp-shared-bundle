Vinatis AMQP Shared
============

### Installation

````
composer req vinatis/amqp-shared-bundle.git
````

### Config file

Create a config file `vinatis_amqp_shared.yaml` in `config/packages` .

### Complete configuration

````
vinatis_amqp_shared:

  messages:
    myname:
      class: App\Message\MyMessage
      type: 'example'
````

### Create your message class

````
<?php

namespace App\Message;

use Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Message\SharedMessage;

class MyMessage extends SharedMessage
{
    public function getType(): string
    {
        return 'example';
    }
}
````

### Create your handler

````
namespace App\Message;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Vinatis\Bundle\AmqpSharedBundle\Message\MyMessage;

class MyHandler implements MessageHandlerInterface
{
    public function __invoke(MyMessage $message): void
    {
        // add your logic here
    }
}
````

### Add configuration into `messenger.yaml`

````
            #
            # Shared ...
            #
            shared:
                dsn: '%env(MESSENGER_TRANSPORT_DSN_SHARED)%'
                serializer: Vinatis\Bundle\AmqpSharedBundle\Bridge\Symfony\Messenger\Serializer\SharedSerializer
                options:
                    exchange:
                        name: shared
                        type: direct
                        default_publish_routing_key: 'my_app_id'
                    queues:
                        "myapp_%env(APP_ID)%":
                            arguments:
                                x-queue-type: quorum
                            binding_keys: ['my_app_id', 'myapp']
````

<?php
return array(

    'view_manager' => array(
        'strategies' => array(
            'ViewYamlStrategy'
        )
    ),

    'service_manager' => array(
        'factories' => array(
            'Acelaya\Yaml\View\Strategy\YamlStrategy' => 'Acelaya\Yaml\View\Strategy\YamlStrategyFactory',
            'Acelaya\Yaml\View\Renderer\YamlRenderer' => 'Acelaya\Yaml\View\Renderer\YamlRendererFactory',
        ),
        'aliases' => array(
            'ViewYamlStrategy' => 'Acelaya\Yaml\View\Strategy\YamlStrategy'
        )
    )

);

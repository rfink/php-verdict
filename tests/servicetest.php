<?php

spl_autoload_register(function($className) {
    $classPath = '../src/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (is_readable($classPath))
    {
        require_once($classPath);
        return true;
    }
    return false;
});

//$discover = new \Verdict\Service\Comparison\Discover();
//print_r($discover->getComparisons());

use Verdict\Context\Generic as GenericContext,
    Verdict\Context\Property\Generic as ContextProperty,
    Verdict\Service\Context\Discover as ContextDiscover,
    Verdict\Context\Property\Type\NumberType,
    Verdict\Context\Property\Type\StringType;

$context = new GenericContext(array(
    'UserAgent' => array(
        'Value' => new ContextProperty(array(
            'value' => '1',
            'getSource' => function() {
                return array(
                    array(
                        'label' => 'Label 1',
                        'value' => '1'
                    ),
                    array(
                        'label' => 'Label 2',
                        'value' => '2'
                    )
                );
            },
            'getValue' => function($propertyObj) {
                return '3';
            },
            'type' => new NumberType()
        ))
    ),
    'Request' => array(
        'QueryString' => array(
            'Value' => new ContextProperty(array(
                'value' => '2',
                'type' => new StringType()
            ))
        )
    )
));

$service = new ContextDiscover();
print_r($service->toJson($context));
        
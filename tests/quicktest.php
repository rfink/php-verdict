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

$buildJson = '{"segmentName":"Root","isTerminatingNode":false,"children":[{"segmentId":4,"segmentName":"Shit Traffic","isTerminatingNode":true,"Condition":{"nodeType":"composite","nodeDriver":"all","children":[{"nodeType":"composite","nodeDriver":"any","children":[{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"Referrer::Value","configValue":"fb_xd_fragment"}]}]},"children":[],"payload":{"trafficType":"shit","runHailo":"0","leaseTime":"0"},"projections":[]},{"segmentId":3,"segmentName":"Internal","isTerminatingNode":true,"Condition":{"nodeType":"composite","nodeDriver":"all","children":[{"nodeType":"composite","nodeDriver":"any","children":[{"nodeType":"comparison","nodeDriver":"equals","contextKey":"UserAgent::IP","configValue":"10.24.1.254"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"Referrer::Value","configValue":"orvisapp"},{"nodeType":"comparison","nodeDriver":"equals","contextKey":"Request::QueryString::env","configValue":"orvis"}]}]},"children":[],"payload":{"trafficType":"internal","runHailo":"1","leaseTime":"60"},"projections":[]},{"segmentId":2,"segmentName":"Bot Traffic","isTerminatingNode":true,"Condition":{"nodeType":"composite","nodeDriver":"all","children":[{"nodeType":"composite","nodeDriver":"any","children":[{"nodeType":"comparison","nodeDriver":"equals","contextKey":"UserAgent::IsExcludedAddress","configValue":"1"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"bot"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"slurp"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"crawl"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"scan"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"link"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"ezine"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"preview"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"dig"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"tarantula"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"urllib"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"jakarta"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"yahooexternal"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"wget"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"webmin"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"newsgator"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"facebookexternal"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"rget"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"monitor"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"libwww"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"moozilla"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"seer"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"spice"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"snoopy"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"yahooseeker"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"spider"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"feedfetcher-google"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"google wireless transcoder"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"wordpress"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"curl"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"java"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"vb project"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"archive.org"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"xenu"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"netfront"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"feed"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"appmanager"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"covario"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"perl"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"host"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"lwp"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"preview"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"page speed"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"ptst"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"digext"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"crawl"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"nutch"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"link sleuth"},{"nodeType":"comparison","nodeDriver":"stringContains","contextKey":"UserAgent::Value","configValue":"yottaamonitor"}]}]},"children":[],"payload":{"trafficType":"bot","runHailo":"0","leaseTime":"0"},"projections":[]},{"segmentId":1,"segmentName":"Default","isTerminatingNode":true,"Condition":{"nodeType":"composite","nodeDriver":"all","children":[{"nodeType":"composite","nodeDriver":"any","children":[{"nodeType":"comparison","nodeDriver":"truth","contextKey":"","configValue":""}]}]},"children":[],"payload":{"trafficType":"normal","runHailo":"1","leaseTime":"3600"},"projections":[]}],"projections":[]}';

class MyContext implements Verdict\Context\ContextInterface
{
    private $props = array();
    public function getValue($key)
    {
        return $this->props[$key];
    }
    
    public function setValue($key, $val)
    {
        $this->props[$key] = $val;
        return $this;
    }
    
    public function addProperty(Verdict\Context\Property\PropertyInterface $property)
    {
        
    }
}

$context = new MyContext();
$context
    ->setValue('Referrer::Value', 'http://google.com')
    ->setValue('UserAgent::IP', '240.240.240.240')
    ->setValue('Request::QueryString::env', 'orvis')
    ->setValue('UserAgent::IsExcludedAddress', false)
    //->setValue('UserAgent::IsExcludedAddress', true)
    ->setValue('UserAgent::Value', 'firefox');

$factory = new Verdict\Segment\Factory\Json(json_decode($buildJson, true), $context);
$node = ($factory->build()->getLeafNode());
$node['node']->setParent(null);
print_r($node['node']);

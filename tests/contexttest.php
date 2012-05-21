<?php

require('/usr/share/www/intranet.directstartv.com/data/define.php');
require_once('phar://../verdict.phar');

use Verdict\Context\Generic as GenericContext,
    Verdict\Context\Property\Generic as GenericProperty,
    Verdict\Segment\Factory\Json as SegmentFactory,
    Verdict\Context\Property\Type\NumberType,
    Verdict\Context\Property\Type\StringType,
    Verdict\Context\Property\Type\BooleanType,
    Verdict\Context\Property\Type\DateType;

$t = microtime(true);

$t1 = microtime(true);
$context = new GenericContext(array(
            'Channel' => array(
                'ChannelID' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                ChannelID AS value,
                                CONCAT(ChannelName, " (", ChannelID, ")") AS label
                            FROM
                                Corporate.MarketingChannels
                        ')->to_array();
                    },
                    'type' => new NumberType()
                ))
            ),
            'Request' => array(
                'Value' => new GenericProperty(array(
                    'type' => new StringType()
                )),
                'QueryString' => array(
                    's_pid' => new GenericProperty(array(
                        'getSource' => function($params) {
                            return array(
                                array(
                                    'label' => '1',
                                    'value' => '1'
                                ),
                                array(
                                    'label' => '2',
                                    'value' => '2'
                                )
                            );
                        },
                        'type' => new NumberType()
                    )),
                    's_cid' => new GenericProperty(array(
                        'type' => new NumberType()
                    )),
                    's_agid' => new GenericProperty(array(
                        'type' => new NumberType()
                    )),
                    's_kid' => new GenericProperty(array(
                        'type' => new NumberType()
                    )),
                    's_aid' => new GenericProperty(array(
                        'type' => new NumberType()
                    )),
                    's_sid' => new GenericProperty(array(
                        'type' => new NumberType()
                    ))
                )
            ),
            'Referrer' => array(
                'Value' => new GenericProperty(array(
                    'type' => new StringType()
                ))
            ),
            'UserAgent' => array(
                'Value' => new GenericProperty(array(
                    'type' => new StringType()
                )),
                'IsBot' => new GenericProperty(array(
                    'type' => new BooleanType()
                )),
                'DeviceType' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return array(
                            array(
                                'label' => 'desktop',
                                'value' => 'desktop'
                            ),
                            array(
                                'label' => 'tablet',
                                'value' => 'tablet'
                            ),
                            array(
                                'label' => 'mobile',
                                'value' => 'mobile'
                            )
                        );
                    },
                    'type' => new StringType(),
                    'isRestrictedSet' => true
                )),
                'DeviceOS' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                DeviceOS AS value,
                                DeviceOS AS label
                            FROM
                                Analytics.UserAgent
                            WHERE
                                DeviceOS LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                DeviceOS
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'Platform' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                Platform AS value,
                                Platform AS label
                            FROM
                                Analytics.Browser
                            WHERE
                                Platform LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                Platform
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'Browser' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                BrowserName AS value,
                                BrowserName AS label
                            FROM
                                Analytics.Browser
                            WHERE
                                BrowserName LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                BrowserName
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'BrowserVersion' => new GenericProperty(array(
                    'type' => new StringType()
                )),
                'IP' => new GenericProperty(array(
                    'type' => new StringType()
                )),
                'IsExcludedAddress' => new GenericProperty(array(
                    'type' => new BooleanType()
                ))
            ),
            'DateTime' => array(
                'Value' => new GenericProperty(array(
                    'type' => new DateType()
                )),
                'Date' => new GenericProperty(array(
                    'getValue' => function($context) {
                        $value = $context->getValue('DateTime::Value');
                        return date('Y-m-d', strtotime($value));
                    },
                    'type' => new DateType()
                )),
                'Hour' => new GenericProperty(array(
                    'getSource' => function($params) {
                        $arr = array();
                        for ($i = 0; $i < 24; ++$i) {
                            $arr[] = array(
                                'label' => $i,
                                'value' => $i
                            );
                        }
                        return $arr;
                    },
                    'getValue' => function($context) {
                        $value = $context->getValue('DateTime::Value');
                        return date('H', strtotime($value));
                    },
                    'type' => new NumberType()
                )),
                'DateTime' => new GenericProperty(array(
                    'getValue' => function($context) {
                        $value = $context->getValue('DateTime::Value');
                        return date('Y-m-d H:i:s', strtotime($value));
                    },
                    'type' => new DateType()
                )),
                'DOW' => new GenericProperty(array(
                    'getSource' => function($params) {
                        $arr = array();
                        foreach (array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat') as $key => $value) {
                            $arr[] = array(
                                'label' => $value,
                                'value' => $key
                            );
                        }
                        return $arr;
                    },
                    'getValue' => function($context) {
                        $value = $context->getValue('DateTime::Value');
                        return date('w', strtotime($value));
                    },
                    'type' => new NumberType()
                )),
                'Week' => new GenericProperty(array(
                    'getSource' => function($params) {
                        $arr = array();
                        for ($i = 0; $i < 55; ++$i) {
                            $arr[] = array(
                                'label' => $i,
                                'value' => $i
                            );
                        }
                        return $arr;
                    },
                    'getValue' => function($context) {
                        $value = $context->getValue('DateTime::Value');
                        return date('W', strtotime($value));
                    },
                    'type' => new NumberType()
                )),
                'Month' => new GenericProperty(array(
                    'getSource' => function($params) {
                        $arr = array();
                        $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                        foreach ($months as $key => $value) {
                            $arr[] = array(
                                'label' => $value,
                                'value' => $key + 1
                            );
                        }
                        return $arr;
                    },
                    'getValue' => function($context) {
                        $value = $context->getValue('DateTime::Month');
                        return date('n', strtotime($value));
                    },
                    'type' => new NumberType()
                )),
                'CallCenterOpen' => new GenericProperty(array(
                    'type' => new BooleanType()                    
                ))
            ),
            'Serviceable' => array(
                'ClearWire' => new GenericProperty(array(
                    'type' => new BooleanType()                    
                ))
            ),
            'SearchStat' => array(
                'Provider' => new GenericProperty(array(
                    'getValue' => function($context) {
                        $s_pid = $context->getValue('Request::QueryString::s_pid');
                        switch ($s_pid) {
                            case 1:
                                return 'google';
                                break;
                            case 2:
                                return 'msn';
                                break;
                            default:
                                return null;
                        }
                    },
                    'getSource' => function($params) {
                        return array(
                            array(
                                'value' => 'google',
                                'label' => 'google'
                            ),
                            array(
                                'value' => 'msn',
                                'label' => 'msn'
                            )
                        );
                    },
                    'type' => new StringType(),
                    'isRestrictedSet' => true
                )),
                'GeoModCity' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                City AS value,
                                City AS label
                            FROM
                                Hailo.City
                            WHERE
                                City LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                City
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'GeoModState' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                State AS value,
                                State AS label
                            FROM
                                Hailo.State
                            WHERE
                                State LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                State
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'GeoModTarget' => new GenericProperty(array(
                    'type' => new StringType()
                ))
            ),
            'GeoIP' => array(
                'City' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                City AS value,
                                City AS label
                            FROM
                                Hailo.City
                            WHERE
                                City LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                City
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'State' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                State AS value,
                                State AS label
                            FROM
                                Hailo.State
                            WHERE
                                State LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                State
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'Zip' => new GenericProperty(array(
                    'type' => new StringType()
                )),
                'Country' => new GenericProperty(array(
                    'type' => new StringType()
                )),
                'NetSpeed' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return array(
                            array(
                                'value' => 'cable',
                                'label' => 'Cable'
                            ),
                            array(
                                'value' => 'mobile',
                                'label' => 'Mobile'
                            ),
                            array(
                                'value' => 'broadband',
                                'label' => 'Broadband'
                            ),
                            array(
                                'value' => 'xdsl',
                                'label' => 'XSDL'
                            ),
                            array(
                                'value' => 't1',
                                'label' => 'T1'
                            ),
                            array(
                                'value' => 'wireless',
                                'label' => 'Wireless'
                            ),
                            array(
                                'value' => 'satellite',
                                'label' => 'Satellite'
                            ),
                            array(
                                'value' => 'dialup',
                                'label' => 'Dialup'
                            ),
                            array(
                                'value' => 't3',
                                'label' => 'T3'
                            ),
                            array(
                                'value' => 'oc3',
                                'label' => 'OC3'
                            )
                        );
                    },
                    'type' => new StringType()
                )),
                'Provider' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                Provider AS value,
                                Provider AS label
                            FROM
                                Analytics.GeoLocation
                            WHERE
                                Provider LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                Provider
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                )),
                'MetroCode' => new GenericProperty(array(
                    'getSource' => function($params) {
                        return DB_Generic::fetch('
                            SELECT
                                MetroCode AS value,
                                MetroCode AS label
                            FROM
                                Analytics.GeoLocation
                            WHERE
                                MetroCode LIKE ' . r3a($params['term'] . '%') . '
                            GROUP BY
                                MetroCode
                            LIMIT 25
                        ', 'hailoslave')->to_array();
                    },
                    'type' => new StringType()
                ))
            )
        ));
echo 'Time for context build --- ' . (microtime(true) - $t1) . PHP_EOL;

$t1 = microtime(true);
$treeRow = RV_Cache::get(__FILE__ . ':794');
echo 'Time for RV_Cache --- ' . (microtime(true) - $t1) . PHP_EOL;

if (empty($treeRow)) {
    $treeRow = DB_Generic::fetch_one('SELECT * FROM OnlineSearch.Tree_SiteExperience WHERE SiteID = "794" AND StartDateTime <= NOW() ORDER BY StartDateTime DESC LIMIT 1');
    RV_Cache::set(__FILE__ . ':794', $treeRow, 60 * 60);
}

$t1 = microtime(true);
$factory = new SegmentFactory(json_decode($treeRow->Tree, true), $context);
$tree = $factory->build();
echo 'Time taken for segment factory --- ' . (microtime(true) - $t1) . PHP_EOL;

$t1 = microtime(true);
$node = $tree->getLeafNode();
$segmentId = $node['node']->getSegmentId();
echo 'Time taken for getLeafNode --- ' . (microtime(true) - $t1) . PHP_EOL;

$t1 = microtime(true);
$segment = RV_Cache::get(__FILE__ . ':segmentId:' . $segmentId);
echo 'Time taken for RV_Cache (segment) - ' . (microtime(true) - $t1) . PHP_EOL;

if (empty($segment)) {
    $segment = DB_Generic::fetch_one('SELECT * FROM OnlineSearch.Tree_SiteExperience_Segment WHERE SegmentID = ' . r3a($segmentId));
    RV_Cache::set(__FILE__ . ':segmentId:' . $segmentId, $segment, 60 * 60);
}

echo 'Time taken --- ' . (microtime(true) - $t) . PHP_EOL;

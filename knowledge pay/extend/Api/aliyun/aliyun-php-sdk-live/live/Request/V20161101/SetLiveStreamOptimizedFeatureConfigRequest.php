<?php

namespace live\Request\V20161101;

/**
 * @deprecated Please use https://github.com/aliyun/openapi-sdk-php
 *
 * Request of SetLiveStreamOptimizedFeatureConfig
 *
 * @method string getConfigStatus()
 * @method string getConfigName()
 * @method string getDomainName()
 * @method string getConfigValue()
 * @method string getOwnerId()
 */
class SetLiveStreamOptimizedFeatureConfigRequest extends \RpcAcsRequest
{

    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'live',
            '2016-11-01',
            'SetLiveStreamOptimizedFeatureConfig',
            'live'
        );
    }

    /**
     * @param string $configStatus
     *
     * @return $this
     */
    public function setConfigStatus($configStatus)
    {
        $this->requestParameters['ConfigStatus'] = $configStatus;
        $this->queryParameters['ConfigStatus'] = $configStatus;

        return $this;
    }

    /**
     * @param string $configName
     *
     * @return $this
     */
    public function setConfigName($configName)
    {
        $this->requestParameters['ConfigName'] = $configName;
        $this->queryParameters['ConfigName'] = $configName;

        return $this;
    }

    /**
     * @param string $domainName
     *
     * @return $this
     */
    public function setDomainName($domainName)
    {
        $this->requestParameters['DomainName'] = $domainName;
        $this->queryParameters['DomainName'] = $domainName;

        return $this;
    }

    /**
     * @param string $configValue
     *
     * @return $this
     */
    public function setConfigValue($configValue)
    {
        $this->requestParameters['ConfigValue'] = $configValue;
        $this->queryParameters['ConfigValue'] = $configValue;

        return $this;
    }

    /**
     * @param string $ownerId
     *
     * @return $this
     */
    public function setOwnerId($ownerId)
    {
        $this->requestParameters['OwnerId'] = $ownerId;
        $this->queryParameters['OwnerId'] = $ownerId;

        return $this;
    }
}

<?php

namespace Scaleflex\Filerobot\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class FilerobotConfig
{

    const SCALEFLEX_FILEROBOT_CDN = 'filerobot.com';

    /**
     * Scaleflex Enable/Disable config
     */
    const SCALEFLEX_FILEROBOT_ENABLE = 'scaleflex_filerobot/general/enable';

    /**
     * Scaleflex File Robot token config
     */
    const SCALEFLEX_FILEROBOT_TOKEN = 'scaleflex_filerobot/general/token';

    /**
     * Scaleflex File Robot template id config
     */
    const SCALEFLEX_FILEROBOT_TEMPLATEID = 'scaleflex_filerobot/general/template_id';

    /**
     * Scaleflex File Robot upload directory config
     */
    const SCALEFLEX_FILEROBOT_UPLOAD_DIRECTORY = 'scaleflex_filerobot/general/upload_directory';


    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * File Robot Token
     * @return string | null
     */
    public function getToken()
    {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_TOKEN, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * File Robot template id
     * @return string | null
     */
    public function getTemplateId()
    {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_TEMPLATEID, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * File Robot upload directory
     * @return string | null
     */
    public function getUploadDir()
    {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_UPLOAD_DIRECTORY, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * Get current status
     * @return mixed
     */
    public function getStatus()
    {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_ENABLE, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * File Robot enable/disable check function
     * @return boolean
     */
    public function checkStatus()
    {
        return $this->getStatus() &&
            $this->getToken() &&
            $this->getTemplateId() &&
            $this->getUploadDir();
    }


    /**
     * @param string $url
     * @return bool
     */
    public function isFilerobot(string $url)
    {
        return str_contains($url, FilerobotConfig::SCALEFLEX_FILEROBOT_CDN);
    }
}

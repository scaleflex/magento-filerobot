<?php

namespace Scaleflex\FileRobot\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class FileRobotConfig
{
    /**
     * Scaleflex Enable/Disable config
     */
    const SCALEFLEX_FILEROBOT_ENABLE = 'cms/scaleflex_filerobot/enable';

    /**
     * Scaleflex CNAME config
     */
    const SCALEFLEX_FILEROBOT_CNAME = 'cms/scaleflex_filerobot/cname';

    /**
     * Scaleflex File Robot token config
     */
    const SCALEFLEX_FILEROBOT_TOKEN = 'cms/scaleflex_filerobot/token';

    /**
     * Scaleflex File Robot template id config
     */
    const SCALEFLEX_FILEROBOT_TEMPLATEID = 'cms/scaleflex_filerobot/template_id';

    /**
     * Scaleflex File Robot upload directory config
     */
    const SCALEFLEX_FILEROBOT_UPLOAD_DIRECTORY = 'cms/scaleflex_filerobot/upload_directory';


    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * File Robot Token
     * @return string | null
     */
    public function getToken() {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_TOKEN, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * File Robot template id
     * @return string | null
     */
    public function getTemplateId() {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_TEMPLATEID, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * File Robot upload directory
     * @return string | null
     */
    public function getUploadDir() {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_UPLOAD_DIRECTORY, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }

    /**
     * File Robot enable/disable check function
     * @return boolean
     */
    public function checkStatus() {
        return $this->scopeConfig->getValue(self::SCALEFLEX_FILEROBOT_ENABLE, ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }
}

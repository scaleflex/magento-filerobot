<?php

namespace Scaleflex\Filerobot\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class ConfigChange implements ObserverInterface
{

    /** @var RequestInterface */
    protected $request;

    /** @var WriterInterface */
    protected $writer;

    /** @var \Magento\Framework\HTTP\Client\Curl $curl */
    protected $curl;

    public function __construct(
        RequestInterface                    $request,
        WriterInterface                     $writer,
        \Magento\Framework\HTTP\Client\Curl $curl
    )
    {
        $this->curl = $curl;
        $this->writer = $writer;
        $this->request = $request;
    }

    public function execute(EventObserver $observer)
    {
        $params = $this->request->getParams('groups');
        $fields = $params['groups']['general']['fields'];

        $token = $fields['token']['value'];
        $templateId = $fields['template_id']['value'];

        $status = $this->verifySetting($token, $templateId);

        if ($status != 200) {
            // Disabled the Enable if config not correct
            $this->writer->save(FilerobotConfig::SCALEFLEX_FILEROBOT_ENABLE, 0);
        }

        return $this;
    }

    /**
     * @param $token
     * @param $templateId
     * @return int
     */
    private function verifySetting($token, $templateId)
    {
        $url = "https://api.filerobot.com/" . $token . "/key/" . $templateId . "?";
        $this->curl->addHeader("Content-Type", "application/json");
        $this->curl->get($url);
        return $this->curl->getStatus();
    }
}

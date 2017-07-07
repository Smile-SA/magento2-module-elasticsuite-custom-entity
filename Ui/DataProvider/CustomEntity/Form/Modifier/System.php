<?php

namespace Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\Modifier;

class System extends AbstractModifier
{

    const KEY_SUBMIT_URL = 'submit_url';

    const KEY_VALIDATE_URL = 'validate_url';

    const KEY_RELOAD_URL = 'reloadUrl';

    /**
     *
     * @var \Smile\ElasticsuiteCustomEntity\Model\Locator\LocatorInterface
     */
    private $locator;

    /**
     *
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     *
     * @var array
     */
    private $entityUrls = [
        self::KEY_SUBMIT_URL => 'custom_entity/entity/save',
        self::KEY_VALIDATE_URL => 'custom_entity/entity/validate',
        self::KEY_RELOAD_URL => 'custom_entity/entity/reload'
    ];

    /**
     *
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     * @param array $productUrls
     */
    public function __construct(
        \Smile\ElasticsuiteCustomEntity\Model\Locator\LocatorInterface $locator,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $entityUrls = []
    ) {
        $this->locator     = $locator;
        $this->urlBuilder  = $urlBuilder;
        $this->entityUrls = array_replace_recursive($this->entityUrls, $entityUrls);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function modifyData(array $data)
    {
        $model = $this->locator->getEntity();
        $attributeSetId = $model->getAttributeSetId();

        $parameters = [
            'id' => $model->getId(),
            'store' => $model->getStoreId()
        ];
        $actionParameters = array_merge($parameters, [
            'set' => $attributeSetId
        ]);
        $reloadParameters = array_merge($parameters, [
            'popup' => 1,
            'componentJson' => 1,
            'prev_set_id' => $attributeSetId,
        ]);

        $submitUrl = $this->urlBuilder->getUrl($this->entityUrls[self::KEY_SUBMIT_URL], $actionParameters);
        $validateUrl = $this->urlBuilder->getUrl($this->entityUrls[self::KEY_VALIDATE_URL], $actionParameters);
        $reloadUrl = $this->urlBuilder->getUrl($this->entityUrls[self::KEY_RELOAD_URL], $reloadParameters);

        return array_replace_recursive($data, [
            'config' => [
                self::KEY_SUBMIT_URL => $submitUrl,
                //self::KEY_VALIDATE_URL => $validateUrl,
                self::KEY_RELOAD_URL => $reloadUrl
            ]
        ]);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}

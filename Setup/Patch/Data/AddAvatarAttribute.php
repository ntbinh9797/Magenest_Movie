<?php

namespace Magenest\Movie\Setup\Patch\Data;


use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddAvatarAttribute implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Config
     */
    private $eavConfig;
    /**
     * @var \Magento\Customer\Model\ResourceModel\Attribute
     */
    private $attributeResource;

    /**
     * AddAvatarAttribute constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $eavConfig
     * @param LoggerInterface $logger
     * @param \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(EavSetupFactory $eavSetupFactory,
                                Config $eavConfig,
                                LoggerInterface $logger,
                                \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
                                \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->logger = $logger;
        $this->attributeResource = $attributeResource;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @return AddAvatarAttribute|void
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        try {
            $this->addAvatarAttribute();
        } catch (AlreadyExistsException $e) {
        } catch (LocalizedException $e) {
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addAvatarAttribute()
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'avatar_customer', ['type' => 'text',
            'label' => 'Logo Image Avatar',
            'input' => 'image',
            "source" => '',
            'required' => false,
            'default' => '0',
            'visible' => true,
            'user_defined' => true,
            'position' => 999,
            'system' => false,
        ]);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(\Magento\Customer\Model\Customer::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(\Magento\Customer\Model\Customer::ENTITY);

        $attribute = $this->eavConfig->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'avatar_customer');
        $attribute->setData('attribute_set_id', $attributeSetId);
        $attribute->setData('attribute_group_id', $attributeGroupId);

        $attribute->setData('used_in_forms', [
            'adminhtml_customer', 'customer_account_create', 'customer_account_edit', 'frontend_customer'
        ]);

        $this->attributeResource->save($attribute);
    }

    public static function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [];
    }

    public function getAliases()
    {
        // TODO: Implement getAliases() method.
        return [];
    }

    public function revert()
    {
        // TODO: Implement revert() method.
    }
}
<?php

namespace UniteCMS\AdminBundle\AdminView\Types;

use Doctrine\Common\Collections\ArrayCollection;
use GraphQL\Language\AST\FragmentDefinitionNode;
use UniteCMS\AdminBundle\AdminView\AdminView;
use UniteCMS\CoreBundle\ContentType\ContentType;

class TableType extends AbstractAdminViewType
{
    const TYPE = 'table';
    const RETURN_TYPE = 'TableAdminView';

    /**
     * {@inheritDoc}
     */
    public function createView(string $category, ?ContentType $contentType = null, ?FragmentDefinitionNode $definition = null, ?array $directive = null) : AdminView {
        $config = new ArrayCollection();
        $config->set('limit', empty($directive['settings']['limit']) ? 20 : $directive['settings']['limit']);
        $config->set('orderBy', empty($directive['settings']['orderBy']) ? [['field' => 'created', 'order' => 'DESC']] : $directive['settings']['orderBy']);

        if($directive) {
            if (!empty($directive['settings']['filter']['field']) || !empty($directive['settings']['filter']['AND']) || !empty($directive['settings']['filter']['OR'])) {
                $config->set('filter', $directive['settings']['filter']);
            }
        }

        return parent::createView($category, $contentType, $definition, $directive)->setConfig($config);
    }
}

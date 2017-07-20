<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductSale;

use Pyz\Shared\ProductSale\ProductSaleConfig;
use Spryker\Client\Kernel\AbstractFactory;

class ProductSaleFactory extends AbstractFactory
{

    /**
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function getSaleSearchQueryPlugin(array $requestParameters = [])
    {
        $saleQueryPlugin = $this->getProvidedDependency(ProductSaleDependencyProvider::SALE_SEARCH_QUERY_PLUGIN);

        return $this->getSearchClient()->expandQuery(
            $saleQueryPlugin,
            $this->getSaleSearchQueryExpanderPlugins(),
            $requestParameters
        );
    }

    /**
     * @return \Spryker\Client\ProductLabel\ProductLabelClientInterface
     */
    public function getProductLabelClient()
    {
        return $this->getProvidedDependency(ProductSaleDependencyProvider::CLIENT_PRODUCT_LABEL);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore()
    {
        return $this->getProvidedDependency(ProductSaleDependencyProvider::STORE);
    }

    /**
     * @return \Pyz\Shared\ProductSale\ProductSaleConfig
     */
    public function createProductSaleConfig()
    {
        return new ProductSaleConfig();
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    public function getSearchClient()
    {
        return $this->getProvidedDependency(ProductSaleDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface[]
     */
    protected function getSaleSearchQueryExpanderPlugins()
    {
        return $this->getProvidedDependency(ProductSaleDependencyProvider::SALE_SEARCH_QUERY_EXPANDER_PLUGINS);
    }

    /**
     * @return \Spryker\Client\Search\Dependency\Plugin\ResultFormatterPluginInterface[]
     */
    public function getSaleSearchResultFormatterPlugins()
    {
        return $this->getProvidedDependency(ProductSaleDependencyProvider::SALE_SEARCH_RESULT_FORMATTER_PLUGINS);
    }

}

<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Pyz\Yves\Customer\Communication\Plugin\Provider;

use Pyz\Yves\Customer\Communication\Plugin\RegisterForm;
use Pyz\Yves\Application\Communication\Plugin\Provider\AbstractServiceProvider;
use Silex\Application;

class CustomerServiceProvider extends AbstractServiceProvider
{

    /**
     * @param Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        $this->addGlobalTemplateVariable($app, [
            'registerForm' => $app['form.factory']->create(
                (new RegisterForm())->createFormRegister()
            )->createView(),
        ]);
    }

    /**
     * @param Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
    }

}
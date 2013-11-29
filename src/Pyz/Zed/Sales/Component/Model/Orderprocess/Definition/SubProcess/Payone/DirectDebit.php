<?php

namespace Pyz\Zed\Sales\Component\Model\Orderprocess\Definition\SubProcess\Payone;

use Generated\Zed\Payone\Component\Dependency\PayoneFacadeInterface;
use Generated\Zed\Payone\Component\Dependency\PayoneFacadeTrait;
use Pyz\Zed\Sales\Component\ConstantsInterface\Orderprocess;
use ProjectA\Zed\Payone\Component\Model\Zed\StateMachine\StateMachineConstants as PayoneStateMachineConstants;

/**
 * @property \Generated\Zed\Sales\Component\SalesFactory $factory
 * @property \ProjectA_Zed_Sales_Component_Model_Orderprocess_StateMachine_Setup $setup
 */
class DirectDebit
    extends \ProjectA_Zed_Sales_Component_Model_Orderprocess_Definition_Abstract
        implements PayoneFacadeInterface, Orderprocess, PayoneStateMachineConstants
{

    use PayoneFacadeTrait;

    /**
     * @param string $processName
     */
    public function __construct($processName = 'Payment Direct Debit Subprocess (Payone)')
    {
        parent::__construct($processName);
    }

    protected function createDefinition()
    {
        $this->getNewSetup();
        $this->addTransitions();
        $this->addMetaInfo();
        $this->addCommands();
        $this->addFlags();
    }

    protected function addTransitions()
    {
        $this->setup->addTransition(self::STATE_PAYONE_INIT_PAYMENT, self::STATE_PAYONE_WAITING_FOR_AUTHORIZATION_APPOINTMENT, self::EVENT_ON_ENTER, self::RULE_PAYONE_TRANSACTION_APPROVED);
        $this->setup->addTransition(self::STATE_PAYONE_INIT_PAYMENT, self::STATE_PAYONE_PAYMENT_INVALID, self::EVENT_ON_ENTER);
        $this->setup->addTransition(self::STATE_PAYONE_WAITING_FOR_AUTHORIZATION_APPOINTMENT, self::STATE_PAYONE_PAYMENT_AUTHORIZED, self::EVENT_PAYONE_TRANSACTION_STATUS_APPOINTED_RECEIVED);
        $this->setup->setTimeout(self::STATE_PAYONE_WAITING_FOR_AUTHORIZATION_APPOINTMENT, self::STATE_PAYONE_PAYMENT_INVALID, '1 day');
    }

    protected function addCommands()
    {
        $payoneAuthorizeCommand = $this->facadePayone->createFacadeStateMachine()->getCommandAuthorizeGrandTotal();
        $this->setup->addCommand(self::STATE_PAYONE_INIT_PAYMENT, self::EVENT_ON_ENTER, $payoneAuthorizeCommand);
    }

    protected function addFlags()
    {
    }

    protected function addMetaInfo()
    {
        $groupStates = [
            self::STATE_PAYONE_INIT_PAYMENT,
            self::STATE_PAYONE_WAITING_FOR_AUTHORIZATION_APPOINTMENT,
            self::STATE_PAYONE_PAYMENT_INVALID,
            self::STATE_PAYONE_PAYMENT_AUTHORIZED,

        ];

        foreach ($groupStates as $groupState) {
            $this->setup->addStateMetaInfo($groupState, 'group', $this->getName());
        }
    }

}

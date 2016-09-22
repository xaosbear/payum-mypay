<?php

namespace PayumTW\Mypay\Action;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Request\Sync;
use Payum\Core\Exception\RequestNotSupportedException;
use PayumTW\Mypay\Api;
use PayumTW\Mypay\Request\Api\GetTransactionData;
use Payum\Core\ApiAwareTrait;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\GatewayAwareInterface;

class SyncAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param $request Sync
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getModel());

        $this->gateway->execute(new GetTransactionData($details));
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Sync &&
            $request->getModel() instanceof \ArrayAccess;
    }
}

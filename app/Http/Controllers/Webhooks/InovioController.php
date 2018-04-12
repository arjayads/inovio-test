<?php

namespace App\Http\Controllers\Webhooks;

use Plustelecom\Inovio\Controllers\PostbackController;

class InovioController extends PostbackController
{
    const OK = '<html><body>100</body></html>';

    public function handleCustomerCreated($payload) {
        return self::OK;
    }

    public function handlePurchase($payload) {
        return self::OK;
    }

    public function handleRenewal($payload) {
        return self::OK;
    }

    public function handleSubscriptionTerminationRequest($payload) {
        return self::OK;
    }

    public function handleSubscriptionTermination($payload) {
        return self::OK;
    }

    public function handleUpsell($payload) {
        return self::OK;
    }

    public function handlePurchaseWithXsale($payload) {
        return self::OK;
    }

    public function handleXsalePurchase($payload) {
        return self::OK;
    }

    public function handleCredit($payload) {
        return self::OK;
    }

    public function handleReversal($payload) {
        return self::OK;
    }

    public function handleChargeback($payload) {
        return self::OK;
    }

    public function handleInformationChange($payload) {
        return self::OK;
    }

    public function handleSubscriptionUsernameChange($payload) {
        return self::OK;
    }

    public function handleSubscriptionPasswordChange($payload) {
        return self::OK;
    }

    public function handleCustomerEmailChange($payload) {
        return self::OK;
    }

    public function handleBlacklistPaymentNumber($payload) {
        return self::OK;
    }
}
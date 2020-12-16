<?php
namespace Squeezely\Plugin\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Newsletter\Model\Subscriber;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;
use Squeezely\Plugin\Helper\SqueezelyApiHelper;
use Squeezely\Plugin\Helper\Data;
use stdClass;
use Throwable;

class SalesOrderInvoicePay implements ObserverInterface {

    /**
     * @var SqueezelyApiHelper
     */
    private $_squeezelyHelperApi;

    /**
     * @var Subscriber
     */
    protected $_subscriber;

    /**
     * @var LoggerInterface
     */
    private $_logger;

    public function __construct(
        SqueezelyApiHelper $squeezelyHelperApi,
        Subscriber $subscriber,
        LoggerInterface $logger
    ) {
        $this->_squeezelyHelperApi = $squeezelyHelperApi;
        $this->_subscriber = $subscriber;
        $this->_logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer) {
        /** @var Order $order */
        try {
            /** @var Order\Invoice $invoice */
            $invoice = $observer->getEvent()->getInvoice();
            $order = $invoice->getOrder();

            if($invoice->getState() === Order\Invoice::STATE_PAID) {
                $this->_squeezelyHelperApi->sendPurchases($this->transformOrderData($order));
            }
        }
        catch(Throwable $throwable) {
            $this->_logger->warning(Data::SQUEEZELY_PLUGIN_NAME . ': Couldn\'t fetch order from invoice event.');
        }
    }

    /**
     * @param Order $order
     *
     * @return stdClass
     */
    private function transformOrderData($order) {
        $formattedProduct = new stdClass();

        $formattedProduct->event = "Purchase";
        $formattedProduct->email = $order->getCustomerEmail();
        $formattedProduct->firstname = $order->getCustomerFirstname();
        $formattedProduct->lastname = $order->getCustomerLastname();
        $formattedProduct->orderid = $order->getRealOrderId();
        $formattedProduct->timestamp = $order->getCreatedAt();

        if($order->getCustomerIsGuest()) {
            $formattedProduct->userid = $order->getCustomerFirstname() . " " . $order->getCustomerLastname();
        } else {
            $formattedProduct->userid = $order->getCustomerId();
        }

        $formattedProduct->gender = $order->getCustomerGender();
        $formattedProduct->birthdate = $order->getCustomerDob();
        $formattedProduct->phone = $order->getShippingAddress()->getTelephone();
        $formattedProduct->postcode = $order->getShippingAddress()->getPostcode();
        $formattedProduct->city = $order->getShippingAddress()->getCity();
        $formattedProduct->country = $order->getShippingAddress()->getCountryId();
        $formattedProduct->currency = $order->getOrderCurrencyCode();
        $formattedProduct->service = 'yes';

        $checkSubscriber = $this->_subscriber->loadByEmail($order->getCustomerEmail());

        switch($checkSubscriber->getStatus()) {
            case Subscriber::STATUS_SUBSCRIBED:
                $formattedProduct->newsletter = 'yes';
                break;
            case Subscriber::STATUS_UNSUBSCRIBED:
                $formattedProduct->newsletter = 'no';
                break;
            default:
                $formattedProduct->newsletter = '';
                break;
        }

        $formattedProduct->products = new stdClass();
        $formattedProduct->products = $this->retrieveProductsFromOrder($order->getAllItems());

        return $formattedProduct;
    }

    /**
     * @param array $products
     *
     * @return array
     */
    private function retrieveProductsFromOrder(array $products) {
        $formattedProducts = [];
        foreach($products as $product) {
            if($product->getData('has_children') !== true) {
                continue;
            }

            $productFormat = new stdClass();
            $productFormat->id = $product->getSku();
            $productFormat->name = $product->getName();
            $productFormat->price = $product->getPrice();
            $productFormat->quantity = $product->getQtyOrdered();

            array_push($formattedProducts, $productFormat);
        }
        return $formattedProducts;
    }
}

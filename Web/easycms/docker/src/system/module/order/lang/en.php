<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->order->common  = 'Order';

$lang->order->id                = 'ID';
$lang->order->productInfo       = 'Details';
$lang->order->account           = 'Account';
$lang->order->address           = 'Shipping Address';
$lang->order->price             = 'Price';
$lang->order->score             = 'Point';
$lang->order->count             = 'Count';
$lang->order->amount            = 'Amount';
$lang->order->sn                = 'TSN';
$lang->order->payStatus         = 'Payment';
$lang->order->paidDate          = 'Paid On';
$lang->order->deliveryStatus    = 'Shipment Status';
$lang->order->deliveriedDate    = 'Shipped';
$lang->order->confirmedDate     = 'Delivered';
$lang->order->payment           = 'Payment';
$lang->order->createdDate       = 'Order Placed';
$lang->order->express           = 'Shipping Carrier';
$lang->order->waybill           = 'Tracking Number';
$lang->order->expressInfo       = 'Shipping Company';
$lang->order->receiver          = 'Receiver';
$lang->order->noRecord          = 'N/A';
$lang->order->status            = 'Status';
$lang->order->note              = 'Note';
$lang->order->frontNote         = 'Note';
$lang->order->basic             = 'Basic Info';
$lang->order->type              = 'Type';
$lang->order->info              = 'Details';
$lang->order->savePay           = 'Payment';
$lang->order->edit              = 'Edit';
$lang->order->contact           = 'Contact';
$lang->order->phone             = 'Phone';
$lang->order->zipcode           = 'Zipcode';
$lang->order->deliveryStatus    = 'Status';
$lang->order->last              = 'Last Action';
$lang->order->comment           = 'Comment';
$lang->order->manage            = 'Manage';
$lang->order->finish            = 'Done';

$lang->order->deliverList['not_send']  = 'Pending';
$lang->order->deliverList['send']      = 'Delivered';
$lang->order->deliverList['confirmed'] = 'Received';

$lang->order->admin          = 'Orders';
$lang->order->view           = 'Details';
$lang->order->setting        = 'System Settings';
$lang->order->browse         = 'My Order';
$lang->order->bought         = 'Purchased';
$lang->order->createdSuccess = 'Your order has been placed!';
$lang->order->paidSuccess    = 'Thank you for your payment!';
$lang->order->submit         = 'Submit';
$lang->order->cancel         = 'Cancel';
$lang->order->pay            = 'Checkout';
$lang->order->goToPay        = 'Your order has been placed. If paid, please go to My Order/My License to find your license.';
$lang->order->goToCart       = 'Back to cart';
$lang->order->editPrice      = 'Edit Price';
$lang->order->return         = 'Collect';
$lang->order->refund         = 'Refund';
$lang->order->delivery       = 'Ship';
$lang->order->delete         = 'Delete';
$lang->order->finish         = 'Finish';
$lang->order->confirm        = 'Confirmation';
$lang->order->selectProducts = "You have <strong class='text-danger'>%s</strong> in your cart. ";
$lang->order->totalToPay     = "Total <strong id='amount' class='text-danger'>%s</strong>";
$lang->order->amountToPay     = "Total???<strong id='total' class='text-lg text-danger'>%s</strong>";
$lang->order->cartProducts    = "<strong>%s</strong> products";
$lang->order->statistics      = "<strong class='text-danger'>%s</strong> products, total:<strong id='amount' class='text-lg text-danger'>%s</strong>";
$lang->order->orderProducts   = "<strong class='text-danger'>%s</strong> products, total: <strong class='text-danger'>%s%s</strong>";
$lang->order->payInfo        = "%s %s order";
$lang->order->goToBank       = "Please pay online.";
$lang->order->track          = 'View Shipment';
$lang->order->life           = 'History';
$lang->order->days           = 'Day';
$lang->order->deliveryInfo   = 'Details';
$lang->order->backToCart     = 'Back to Cart';
$lang->order->paid           = 'Paid';
$lang->order->products       = 'Ordered Products';
$lang->order->selectPayment  = 'Choose payment';
$lang->order->settlement     = 'Checkout';
$lang->order->check          = 'Settle Order';
$lang->order->all            = 'All';
$lang->order->applyRefund    = 'Apply for Refund';
$lang->order->wechatpay      = 'Wechat pay';
$lang->order->scanCode       = 'Pay by wechat qrcode';
$lang->order->wechatScan     = 'Please scan the qrcode <br> by wechat.';
$lang->order->inWechatTip    = 'Tips: WeChat browser does not support Alipay. If you have to use Alipay, copy the URL to others browsers and then pay there.';

$lang->order->confirmLimit         = 'Receiving Cyle';
$lang->order->expireLimit          = 'Order Expiration';
$lang->order->confirmReceived      = 'Confirm Receipt';
$lang->order->deliveryConfirmed    = 'Thank you for your confirmation. Shop again!';
$lang->order->confirmWarning       = "Please confirm after your order has been received!";
$lang->order->cancelWarning        = "Do you want to cancle this order?";
$lang->order->cancelSuccess        = "Order cancelled.";
$lang->order->paymentRequired      = 'Choose payment';
$lang->order->confirmLimitRequired = 'Set receiving cycle';
$lang->order->finishWarning        = "Do you want to finish this order?";
$lang->order->noProducts           = "No product in this order";
$lang->order->lowStocks            = "<strong>%s</strong> is out of stock!";
$lang->order->invokeWechatpay      = 'Invoking wechatpay.';

$lang->order->alipayParam    = 'Params of alipay';
$lang->order->wechatpayParam = 'Params of wechatpay';

$lang->order->alipayPid   = 'Partner ID';
$lang->order->alipayKey   = 'Partner KEY';
$lang->order->alipayEmail = 'Alipay Email';

$lang->order->wechatpayAppid     = 'APPID of wechat public';
$lang->order->wechatpayMchid     = "Merchant ID";
$lang->order->wechatpayApiKey    = "wechatpay key";
$lang->order->wechatpayAppSecret = "wechat publicmkey";
$lang->order->wechatpayH5Status  = 'wechat H5 payment';
$lang->order->wechatpayNote      = 'Please return and pay by other method, if wechat is timeout';

$lang->order->placeholder = new stdclass();
$lang->order->placeholder->pid   = 'Corporate identity to ID, 16 number begin with 2088.';
$lang->order->placeholder->key   = 'Security checking code, 32 characters of numbers and letters.';
$lang->order->placeholder->email = 'Alipay Email';
$lang->order->placeholder->appid     = 'ID of wechat public';
$lang->order->placeholder->mchid     = 'Merchant id assigned by wechatpay';
$lang->order->placeholder->apikey    = 'Key of wechatpay API';
$lang->order->placeholder->appsecret = "wechat public's key";
$lang->order->placeholder->note      = 'Optional???leave a message for seller.';

$lang->order->paymentList = array();
$lang->order->paymentList['alipay']        = 'Alipay Payment';
$lang->order->paymentList['alipaySecured'] = 'Alipay Secured';
$lang->order->paymentList['COD']           = 'Cash on Delivery';
$lang->order->paymentList['offlinepay']    = 'Offline Payment';
$lang->order->paymentList['wechatpay']     = 'Wechatpay';

$lang->order->statusList = array();
$lang->order->statusList['not_paid']  = 'Not Paid';
$lang->order->statusList['paid']      = 'Paid';
$lang->order->statusList['not_send']  = 'Pending';
$lang->order->statusList['send']      = 'Shipped';
$lang->order->statusList['confirmed'] = 'Received';
$lang->order->statusList['normal']    = 'In Process';
$lang->order->statusList['finished']  = 'Finished';
$lang->order->statusList['canceled']  = 'Cancelled';
$lang->order->statusList['refunding'] = 'Refunding';
$lang->order->statusList['refunded']  = 'Refunded';
$lang->order->statusList['expired']   = 'Expired';

$lang->order->payStatusList = array();
$lang->order->payStatusList['not_paid']  = 'Not Paid';
$lang->order->payStatusList['paid']      = 'Paid';
$lang->order->payStatusList['refunding'] = 'Refunding';
$lang->order->payStatusList['refunded']  = 'Refunded';

$lang->order->types = array();
$lang->order->types['shop']  = 'Products';
$lang->order->types['score'] = 'Points';

$lang->order->abbr = new stdclass();
$lang->order->abbr->paidDate       = 'Paid';
$lang->order->abbr->deliveriedDate = 'Delivered';
$lang->order->abbr->confirmedDate  = 'Received';
$lang->order->abbr->createdDate    = 'Created';

$lang->order->searchLabels = new stdclass();
$lang->order->searchLabels->all         = 'All|mode=all';
$lang->order->searchLabels->waitPay     = 'Not paid|mode=payStatus&param=not_paid';
$lang->order->searchLabels->waitSend    = 'Pending|mode=deliveryStatus&param=not_send';
$lang->order->searchLabels->waitConfirm = 'Sent|mode=deliveryStatus&param=send';
$lang->order->searchLabels->refunding   = 'Refunding|mode=payStatus&param=refunding';
$lang->order->searchLabels->confirmed   = 'Received|mode=deliveryStatus&param=confirmed';
$lang->order->searchLabels->finished    = 'Finished|mode=status&param=finished';
$lang->order->searchLabels->refunded    = 'Refunded|mode=payStatus&param=refunded';
$lang->order->searchLabels->canceled    = 'Cancelled|mode=status&param=canceled';
$lang->order->searchLabels->expired     = 'Expired|mode=status&param=expired';

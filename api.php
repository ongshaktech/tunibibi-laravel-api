<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerRegistrationController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\ShopOnlineConteroller;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\SellerHomeController;
use App\Http\Controllers\UnitWeightController;
use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\SubCatagoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\ProductVideoController;
//auth:sanctum
Route::prefix("seller")->group(function(){

    //Otp Verification System
    Route::post("/otp-send",[OtpController::class,"create"]);
    Route::post("/otp-verify",[OtpController::class,"verify"]);

    //Add Business Info
    Route::get("/business-types",[BusinessTypeController::class,"index"]);
    Route::put("/add-business/{id}",[BusinessTypeController::class,"update"]);
//    Route::post("/add-logo/{id}",[\App\Http\Controllers\Seller::class,"LogoUpdate"]);

    //Password Setup
    Route::put("/set-password/{id}",[SellerRegistrationController::class,"PasswordSetup"]);

    Route::put("/change-password",[SellerRegistrationController::class,"ChangePassword"])->middleware("auth:sanctum");;

    //Login
    Route::post("/login",[SellerRegistrationController::class,"Login"]);
    Route::post("/refresh-token",[SellerRegistrationController::class,"RefreshToken"]);


    //Forget Password
    Route::post("/forget",[SellerRegistrationController::class,"ForgetOtp"]);
    Route::post("/otp-match",[SellerRegistrationController::class,"MatchOtp"]);
    Route::post("/set-password",[SellerRegistrationController::class,"ForgetPasswordSetup"]);


    //Addresss
    Route::put("/address",[SellerRegistrationController::class,"AddAddress"])->middleware("auth:sanctum");

    //Shop Info
    Route::get("/shop-info",[SellerHomeController::class,"ShopInfo"])->middleware("auth:sanctum");


    //Shop-Online
    Route::get("/check-status",[ShopOnlineConteroller::class,"CheckStatus"])->middleware("auth:sanctum");
    Route::post("/online",[ShopOnlineConteroller::class,"GoOnline"])->middleware("auth:sanctum");
    Route::put("/offline",[ShopOnlineConteroller::class,"GoOffline"])->middleware("auth:sanctum");

    //Banners
    Route::get("/banners",[BannerController::class,"GetBanners"]);


    //Seller Home
    Route::post("/home",[SellerHomeController::class,"Home"]);


    //Unit Weights
    Route::get("unit-weights",[UnitWeightController::class,"Weights"]);

    //CatagoryController
    Route::get("catagory-tree",[CatagoryController::class,"AllCatagory"]);
    Route::get("catagory",[CatagoryController::class,"Catagory"]);
    Route::get("sub-catagory/{id}",[SubCatagoryController::class,"GetSubCatagory"]);


    //ProductController
    Route::get("all-products",[ProductController::class,"AllProduct"])->middleware("auth:sanctum");


    Route::get("colors",[ProductController::class,"GetColors"]);
    Route::post("add-varient",[ProductController::class,"AddVarient"])->middleware("auth:sanctum");
    Route::put("varient/{id}",[ProductController::class,"UpdateVarient"])->middleware("auth:sanctum");
    Route::delete("varient/{id}",[ProductController::class,"DeleteVarient"])->middleware("auth:sanctum");
    Route::get("get-varient",[ProductController::class,"GetVarient"])->middleware("auth:sanctum");
    Route::put("product/stock/{id}",[ProductController::class,"ProductStockStatus"])->middleware("auth:sanctum");

    Route::post("add-product",[ProductController::class,"AddProduct"])->middleware("auth:sanctum");
    Route::post("add-draft-product",[ProductController::class,"AddDraftProduct"])->middleware("auth:sanctum");
    Route::post("add-product/image",[ProductController::class,"AddProductImage"])->middleware("auth:sanctum");
    Route::delete("add-product/image/{id}",[ProductController::class,"DeleteProductImage"])->middleware("auth:sanctum");
    Route::put("product/update/{id}",[ProductController::class,"UpdateProduct"])->middleware("auth:sanctum");


//   Route::post("varient_image/{id}",[ProductController::class,"AddVarientImage"])->middleware("auth:sanctum");

//    Route::post("add-product-img/{id}",[ProductController::class,"AddProductImage"])->middleware("auth:sanctum");

    Route::delete("product/delete/{id}",[ProductController::class,"DeleteProduct"])->middleware("auth:sanctum");


    Route::get("product/{id}",[ProductController::class,"GetProductDetails"])->middleware("auth:sanctum");




    //Order-Controller
    Route::get("delivery_times",[\App\Http\Controllers\DeliveryTimesController::class,"DeliveryTimes"])->middleware("auth:sanctum");
    Route::get("Order",[OrderController::class,"Orders"])->middleware("auth:sanctum");
    Route::get("Orders/{id}",[OrderController::class,"OrderDetails"])->middleware("auth:sanctum");
    Route::post("order-approve",[OrderController::class,"Approve"])->middleware("auth:sanctum");
    Route::post("order-reject",[OrderController::class,"Reject"])->middleware("auth:sanctum");
    Route::post("order-ship",[OrderController::class,"Shiped"])->middleware("auth:sanctum");
    Route::post("order-faild",[OrderController::class,"Faild"])->middleware("auth:sanctum");
    Route::post("order-complete",[OrderController::class,"Complete"])->middleware("auth:sanctum");
    Route::get("my_courier",[\App\Http\Controllers\SellerCurierChargesController::class,"Index"])->middleware("auth:sanctum");
    Route::post("order-delivery",[OrderController::class,"Delivered"])->middleware("auth:sanctum");
    //Coupon
    Route::post("add-percent-coupon",[CouponController::class,"AddPercentCoupon"])->middleware("auth:sanctum");
    Route::post("add-flat-coupon",[CouponController::class,"AddFlatCoupon"])->middleware("auth:sanctum");
    Route::get("all-coupon",[CouponController::class,"AllCoupon"])->middleware("auth:sanctum");

    Route::post("add-deal",[CouponController::class,"AddDeal"])->middleware("auth:sanctum");

    //Payents Info
    Route::get("payment_methods",[\App\Http\Controllers\SellerPaymentDetailsController::class,"PaymentMethods"])->middleware("auth:sanctum");
    Route::post("payment_methods",[\App\Http\Controllers\SellerPaymentDetailsController::class,"PaymentMethodSave"])->middleware("auth:sanctum");
    Route::get("my_payments",[\App\Http\Controllers\SellerPaymentDetailsController::class,"MyPayments"])->middleware("auth:sanctum");

//    Route::post("payment/upi_payment",[\App\Http\Controllers\SellerPaymentDetailsController::class,"UpiPaymentAdd"])->middleware("auth:sanctum");
//    Route::put("payment/upi_payment",[\App\Http\Controllers\SellerPaymentDetailsController::class,"UpiPaymentEdit"])->middleware("auth:sanctum");
//    Route::get("payment/upi_payment",[\App\Http\Controllers\SellerPaymentDetailsController::class,"UpiPayment"])->middleware("auth:sanctum");
//
//    Route::post("payment/bank_payment",[\App\Http\Controllers\SellerPaymentDetailsController::class,"BankPaymentAdd"])->middleware("auth:sanctum");
//    Route::put("payment/bank_payment",[\App\Http\Controllers\SellerPaymentDetailsController::class,"BankPaymentEdit"])->middleware("auth:sanctum");
//    Route::get("payment/bank_payment",[\App\Http\Controllers\SellerPaymentDetailsController::class,"BankPayment"])->middleware("auth:sanctum");
//
//    Route::post("payment/cod",[\App\Http\Controllers\SellerPaymentDetailsController::class,"CODAdd"])->middleware("auth:sanctum");
//    Route::get("payment/cod",[\App\Http\Controllers\SellerPaymentDetailsController::class,"CODGet"])->middleware("auth:sanctum");
//
//    Route::get("payment/AllPaymentsDetails",[\App\Http\Controllers\SellerPaymentDetailsController::class,"AllPaymentsDetails"])->middleware("auth:sanctum");
//


    //Cuired Charges
    Route::post("add-courier",[\App\Http\Controllers\SellerCurierChargesController::class,"AddCurrierCharge"])->middleware("auth:sanctum");
    Route::put("add-courier",[\App\Http\Controllers\SellerCurierChargesController::class,"EditCurrierCharge"])->middleware("auth:sanctum");
    Route::get("add-courier",[\App\Http\Controllers\SellerCurierChargesController::class,"GetCurrierCharge"])->middleware("auth:sanctum");



    Route::post("live",[LiveController::class,"LiveStart"])->middleware("auth:sanctum");
    Route::put("live-end/{id}",[LiveController::class,"LiveEnd"])->middleware("auth:sanctum");
    Route::get("live-history",[LiveController::class,"AllHistory"])->middleware("auth:sanctum");

    //Bar Code
    Route::get("qr-code",[\App\Http\Controllers\Seller::class,"QrCode"])->middleware("auth:sanctum");

    //Edit Business
    Route::put("EditBusiness",[\App\Http\Controllers\Seller::class,"Edit"])->middleware("auth:sanctum");



    //ExtraCharge

Route::get("extra-charges",[\App\Http\Controllers\ExtraChargeController::class,"GetExtraCharges"])->middleware("auth:sanctum");
Route::post("extra-charges",[\App\Http\Controllers\ExtraChargeController::class,"PostExtraCharges"])->middleware("auth:sanctum");
Route::post("my-extra-charges",[\App\Http\Controllers\ExtraChargeController::class,"MyextraCharges"])->middleware("auth:sanctum");


    //LeaderBoard
    Route::get("leaderboard",[\App\Http\Controllers\SellerReferEarningController::class,"LeaderBoard"])->middleware("auth:sanctum");
    Route::get("my_rank",[\App\Http\Controllers\SellerReferEarningController::class,"MyRank"])->middleware("auth:sanctum");
    Route::get("refer_policy",[\App\Http\Controllers\SellerReferEarningController::class,"ReferPolicy"])->middleware("auth:sanctum");
    Route::post("recharge",[\App\Http\Controllers\SellerReferEarningController::class,"Recharge"])->middleware("auth:sanctum");
    Route::get("recharge",[\App\Http\Controllers\SellerReferEarningController::class,"RechargeData"])->middleware("auth:sanctum");

   Route::get("country",[\App\Http\Controllers\SellerReferEarningController::class,"Countrys"])->middleware("auth:sanctum");
  Route::get("operators/{id}",[\App\Http\Controllers\SellerReferEarningController::class,"Operators"])->middleware("auth:sanctum");

    //Refer
    Route::get("refer-earning",[\App\Http\Controllers\BuyerReferEarningController::class,"MyReferEarning"])->middleware("auth:sanctum");
    Route::get("my-refers",[\App\Http\Controllers\BuyerReferEarningController::class,"MyRefers"])->middleware("auth:sanctum");
    Route::post("refer-recharge",[\App\Http\Controllers\BuyerReferEarningController::class,"Recharge"])->middleware("auth:sanctum");


    Route::post("ProductVideos",[ProductVideoController::class,"AddVideo"])->middleware("auth:sanctum");
    Route::get("ProductVideos",[ProductVideoController::class,"History"])->middleware("auth:sanctum");
    //




});






//Buyer
Route::prefix("buyer")->group(function (){
    //Otp Verification System
    Route::post("/check_number",[\App\Http\Controllers\BuyerController::class,"CheckNumber"]);
    Route::post("/otp-send",[\App\Http\Controllers\BuyerController::class,"OtpSend"]);
    Route::post("/verify/{id}",[\App\Http\Controllers\BuyerController::class,"Verify"]);
    Route::post("/login",[\App\Http\Controllers\BuyerController::class,"Login"]);



    Route::middleware(["auth:sanctum"])->group(function (){

        //Select Country
        Route::get("/country",[\App\Http\Controllers\Admin\CountryController::class,"Index"]);
        Route::get("/seller_country",[\App\Http\Controllers\Admin\BuyerProductCountrySelectController::class,"Index"]);
        Route::put("/seller_country",[\App\Http\Controllers\Admin\BuyerProductCountrySelectController::class,"Update"]);


        Route::get("/search/options",[\App\Http\Controllers\Admin\FilterControllerController::class,"FilterOptions"]);
        Route::post("/search/filter",[\App\Http\Controllers\Admin\FilterControllerController::class,"Filter"]);




        Route::get("/banners",[\App\Http\Controllers\BuyerBannersController::class,"Index"]);
        Route::get("/super-deal",[\App\Http\Controllers\BuyerSuperDealController::class,"Index"]);
        Route::get("/super-deal-category",[\App\Http\Controllers\BuyerSuperDealController::class,"CategoryWithDeals"]);
        Route::get("/super-deal/{id}",[\App\Http\Controllers\BuyerSuperDealController::class,"Show"]);
        Route::get("/shipping_details",[\App\Http\Controllers\ShippingPackagesController::class,"Show"]);
        Route::get("/reviews/{id}",[\App\Http\Controllers\BuyerSuperDealController::class,"Reviews"]);
        Route::get("/shop_info/{id}",[\App\Http\Controllers\BuyerSuperDealController::class,"ShopInfo"]);
        Route::get("/product_details/{id}",[\App\Http\Controllers\BuyerSuperDealController::class,"ProductDetails"]);
        Route::get("/follow_shop/{id}",[\App\Http\Controllers\SellerFlowersController::class,"Following"]);
        Route::get("/unfollow_shop/{id}",[\App\Http\Controllers\SellerFlowersController::class,"Unfollowing"]);
        Route::get("/coupons/{id}",[\App\Http\Controllers\CouponController::class,"GetBuyerCoupons"]);
        Route::get("/coupons/save/{id}",[\App\Http\Controllers\CustomerCouponController::class,"store"]);
        Route::post("/write_review/{id}",[\App\Http\Controllers\ProductReviewController::class,"WriteReview"]);
        Route::get("/products",[\App\Http\Controllers\ProductController::class,"GetBuyerHomeProducts"]);
        Route::get("/feature_products",[\App\Http\Controllers\ProductController::class,"FeaturedProducts"]);
        Route::post("/product_search",[\App\Http\Controllers\ProductController::class,"SearchByName"]);

        Route::get("catagory-tree",[CatagoryController::class,"AllCatagory"]);
        Route::get("catagory",[CatagoryController::class,"Catagory"]);
        Route::get("sub-catagory/{id}",[SubCatagoryController::class,"GetSubCatagory"]);
        Route::get("products/sub_catagoroy/{id}",[ProductController::class,"SubCatagoryWiseProducts"]);
        Route::get("order/track/{id}",[OrderController::class,"TrackOrder"]);


        Route::get("favourite_name",[\App\Http\Controllers\BuyerFavouriteProductController::class,"CatagoryIndex"]);
        Route::post("favourite_name",[\App\Http\Controllers\BuyerFavouriteProductController::class,"CatagoryCreate"]);

        Route::get("favourite_product",[\App\Http\Controllers\BuyerFavouriteProductController::class,"Index"]);
        Route::post("favourite_product",[\App\Http\Controllers\BuyerFavouriteProductController::class,"Create"]);






        Route::get("shipping/add/{id}",[\App\Http\Controllers\BuyerShippingController::class,"store"]);
        Route::get("shipping",[\App\Http\Controllers\BuyerShippingController::class,"index"]);
        Route::post("buy_now/add",[\App\Http\Controllers\BuyNowController::class,"store"]);
        Route::post("buy_now/voucher",[\App\Http\Controllers\BuyNowController::class,"applayvoucher"]);
        Route::post("buy_now/checkout",[\App\Http\Controllers\BuyNowController::class,"checkout"]);

//        Route::post("buy_now/checkout",[\App\Http\Controllers\BuyTogetherController::class,"BuyNow"]);




        //Buy Together

        Route::post("buy_together",[\App\Http\Controllers\BuyTogetherController::class,"Create"]);
        Route::get("buy_together",[\App\Http\Controllers\BuyTogetherController::class,"Index"]);
        Route::post("buy_together/voucher",[\App\Http\Controllers\BuyTogetherController::class,"applayvoucher"]);
        Route::get("buy_together_details/{id}",[\App\Http\Controllers\BuyTogetherController::class,"Show"]);
        Route::get("buy_together/quantity_incress/{id}",[\App\Http\Controllers\BuyTogetherController::class,"QuantityUpdate"]);
        Route::get("buy_together/quantity_decress/{id}",[\App\Http\Controllers\BuyTogetherController::class,"QuantityDecress"]);
        Route::post("buy_together/checkout",[\App\Http\Controllers\BuyTogetherController::class,"Checkout"]);




        //Payment
        Route::get("/payment_methods",[\App\Http\Controllers\BuyerPaymentMethodController::class,"Index"]);



//        Route::post("city_delivery_charges",[\App\Http\Controllers\CityDeliveryChargeController::class,"Show"]);
        Route::post("shipping_address",[\App\Http\Controllers\BuyerShippingAddressController::class,"Create"]);
        Route::get("shipping_address",[\App\Http\Controllers\BuyerShippingAddressController::class,"Index"]);
        Route::put("shipping_address/{id}",[\App\Http\Controllers\BuyerShippingAddressController::class,"Update"]);
        Route::put("default_shipping",[\App\Http\Controllers\BuyerShippingAddressController::class,"DefaultShipping"]);
        Route::get("default_shipping",[\App\Http\Controllers\BuyerShippingAddressController::class,"GetDefaultShipping"]);
//        Route::post("deivery_charge_local",[\App\Http\Controllers\CityDeliveryChargeController::class,"ShowChargeByAddressID"]);


        Route::post("apply_coupon",[\App\Http\Controllers\CouponController::class,"GetBuyerDiscountAmount"]);
        Route::post("apply_voucher",[\App\Http\Controllers\VoucherController::class,"Index"]);



        Route::post("/cart",[\App\Http\Controllers\CartsController::class,"Cart"]);
        Route::get("/cart",[\App\Http\Controllers\CartsController::class,"Index"]);
        Route::get("/cart/select/{id}",[\App\Http\Controllers\CartsController::class,"Select"]);
        Route::get("/cart/unselect/{id}",[\App\Http\Controllers\CartsController::class,"Unselect"]);
        Route::get("/cart/increment/{id}",[\App\Http\Controllers\CartsController::class,"Increment"]);
        Route::get("/cart/decrement/{id}",[\App\Http\Controllers\CartsController::class,"Decrement"]);
        Route::delete("/cart/{id}",[\App\Http\Controllers\CartsController::class,"DeleteItem"]);
        Route::post("/cart/checkout",[\App\Http\Controllers\CartsController::class,"Checkout"]);



        //Orders
        Route::get("/orders",[\App\Http\Controllers\BuyerOrderController::class,"Index"]);
        Route::post("/orders/payment_info/{id}",[\App\Http\Controllers\BuyerOrderController::class,"PaymentInfoSubmit"]);
        Route::get("/orders/{order_id}",[\App\Http\Controllers\BuyerOrderController::class,"Show"]);
        Route::get("/orders/filter/{status}",[\App\Http\Controllers\BuyerOrderController::class,"ToDelivery"]);


        Route::post("/orders/pay/delivery",[\App\Http\Controllers\BuyerOrderController::class,"DeliveryFeePay"]);


        //Seller HomePage

        Route::get("/seller/{id}",[\App\Http\Controllers\SellerHomePageController::class,"Show"]);
        Route::get("/seller/all_products/{id}",[\App\Http\Controllers\SellerHomePageController::class,"AllProducts"]);
        Route::get("/seller/new_products/{id}",[\App\Http\Controllers\SellerHomePageController::class,"NewProducts"]);

        //Security
        Route::get("/security",[\App\Http\Controllers\BuyerSecuritySettingsController::class,"Index"]);
        Route::put("/security",[\App\Http\Controllers\BuyerSecuritySettingsController::class,"Update"]);


        //Buyer Profile
        Route::get("/profile",[\App\Http\Controllers\BuyerProfileController::class,"Index"]);
        Route::put("/profile",[\App\Http\Controllers\BuyerProfileController::class,"Update"]);


        //Flowing Shops
        Route::get("/following",[\App\Http\Controllers\BuyerFollowingController::class,"Index"]);



        Route::get("/invoice/{id}",[\App\Http\Controllers\InvoiceController::class,"Show"]);
        Route::get("/pendingOrders",[\App\Http\Controllers\InvoiceController::class,"Orders"]);
        Route::get("/notification",[\App\Http\Controllers\InvoiceController::class,"Notification"]);







        Route::get("leaderboard",[\App\Http\Controllers\buyer\LeaderBoardController::class,"LeaderBoard"])->middleware("auth:sanctum");
        Route::get("refer_policy",[\App\Http\Controllers\SellerReferEarningController::class,"ReferPolicy"])->middleware("auth:sanctum");
        Route::get("my_rank",[\App\Http\Controllers\SellerReferEarningController::class,"MyRankBuyer"])->middleware("auth:sanctum");
        Route::get("claim_point",[\App\Http\Controllers\SellerReferEarningController::class,"ClaimPoint"])->middleware("auth:sanctum");

    });

});







//Admin
Route::prefix("admin")->group(function (){
    Route::post("login",[\App\Http\Controllers\AdminController::class,"Login"]);

    Route::middleware(["auth:sanctum"])->group(function (){


        Route::post("add-business",[\App\Http\Controllers\BusinessTypeController::class,"AddBussiness"]);
        Route::get("business",[\App\Http\Controllers\BusinessTypeController::class,"index"]);
        Route::put("business/{id}",[\App\Http\Controllers\BusinessTypeController::class,"EditBusiness"]);
        Route::delete("business/{id}",[\App\Http\Controllers\BusinessTypeController::class,"DeleteBusiness"]);


//Sellers Control
        Route::get("sellers",[\App\Http\Controllers\Admin\SellerController::class,"Sellers"]);
        Route::post("add-seller",[\App\Http\Controllers\Admin\SellerController::class,"RegistrationSeller"]);
        Route::put("add-seller/{id}",[\App\Http\Controllers\Admin\SellerController::class,"UpdateSeller"]);
        Route::delete("add-seller/{id}",[\App\Http\Controllers\Admin\SellerController::class,"DeleteSeller"]);
        Route::put("seller-password/{id}",[\App\Http\Controllers\Admin\SellerController::class,"ChangePassword"]);


//Banners

        Route::get("banners",[\App\Http\Controllers\Admin\BannerController::class,"index"]);
        Route::post("add-banner",[\App\Http\Controllers\Admin\BannerController::class,"create"]);
        Route::put("banner/{id}",[\App\Http\Controllers\Admin\BannerController::class,"update"]);
        Route::delete("banner/{id}",[\App\Http\Controllers\Admin\BannerController::class,"delete"]);




//Unit Weights
        Route::get("units",[\App\Http\Controllers\Admin\UnitController::class,"index"]);
        Route::post("units",[\App\Http\Controllers\Admin\UnitController::class,"create"]);
        Route::put("units/{id}",[\App\Http\Controllers\Admin\UnitController::class,"update"]);
        Route::delete("units/{id}",[\App\Http\Controllers\Admin\UnitController::class,"delete"]);


//Unit Catagory
        Route::get("catagory",[\App\Http\Controllers\Admin\CatagoryController::class,"index"]);
        Route::post("catagory",[\App\Http\Controllers\Admin\CatagoryController::class,"create"]);
        Route::put("catagory/{id}",[\App\Http\Controllers\Admin\CatagoryController::class,"update"]);
        Route::delete("catagory/{id}",[\App\Http\Controllers\Admin\CatagoryController::class,"delete"]);


        //Unit Catagory
        Route::get("subcatagory",[\App\Http\Controllers\Admin\SubCatagoryController::class,"index"]);
        Route::post("subcatagory",[\App\Http\Controllers\Admin\SubCatagoryController::class,"create"]);
        Route::put("subcatagory/{id}",[\App\Http\Controllers\Admin\SubCatagoryController::class,"update"]);
        Route::delete("subcatagory/{id}",[\App\Http\Controllers\Admin\SubCatagoryController::class,"delete"]);


        //Variant

        Route::post("add-variant",[\App\Http\Controllers\Admin\VariantController::class,"Store"]);
        Route::get("get-variant",[\App\Http\Controllers\Admin\VariantController::class,"Index"]);
        Route::put("variant/{id}",[\App\Http\Controllers\Admin\VariantController::class,"Update"]);
        Route::delete("variant/{id}",[\App\Http\Controllers\Admin\VariantController::class,"Delete"]);




        //Product
        Route::post("product",[\App\Http\Controllers\Admin\ProductController::class,"Store"]);
        Route::get("product",[\App\Http\Controllers\Admin\ProductController::class,"Index"]);
        Route::put("product/{id}",[\App\Http\Controllers\Admin\ProductController::class,"Update"]);
        Route::delete("product/{id}",[\App\Http\Controllers\Admin\ProductController::class,"Delete"]);
        Route::put("product/stock/{id}",[\App\Http\Controllers\Admin\ProductController::class,"StockStatus"]);
        Route::get("product/seller/{id}",[\App\Http\Controllers\Admin\ProductController::class,"Index"]);


        Route::post("product/image",[\App\Http\Controllers\Admin\ProductImageController::class,"Store"]);
        Route::delete("product/image/{id}",[ProductController::class,"DeleteProductImage"]);

        //Flat Discount
        Route::post("discount/flat/add",[\App\Http\Controllers\Admin\CouponController::class,"FlatDiscountStore"]);
        Route::get("discount/flat",[\App\Http\Controllers\Admin\CouponController::class,"GetFlatDiscount"]);
        Route::put("discount/flat/{id}",[\App\Http\Controllers\Admin\CouponController::class,"UpdateFlatDiscount"]);
        Route::get("discount/flat/seller/{id}",[\App\Http\Controllers\Admin\CouponController::class,"SellerFlatDiscount"]);


        //Percent Discount
        Route::post("discount/percent/add",[\App\Http\Controllers\Admin\CouponController::class,"PercentDiscountStore"]);
        Route::get("discount/percent",[\App\Http\Controllers\Admin\CouponController::class,"GetPercentDiscount"]);
        Route::put("discount/percent/{id}",[\App\Http\Controllers\Admin\CouponController::class,"UpdatePercentDiscount"]);
        Route::get("discount/percent/seller/{id}",[\App\Http\Controllers\Admin\CouponController::class,"SellerPercentDiscount"]);

        //Delete
        Route::delete("discount/{id}",[\App\Http\Controllers\Admin\CouponController::class,"Delete"]);


        //Seller Payment Method
        Route::post("payment_method/seller/add",[\App\Http\Controllers\Admin\SellerPaymentMethodController::class,"Store"]);
        Route::get("payment_method/seller",[\App\Http\Controllers\Admin\SellerPaymentMethodController::class,"Index"]);
        Route::put("payment_method/seller/{id}",[\App\Http\Controllers\Admin\SellerPaymentMethodController::class,"Update"]);
        Route::delete("payment_method/seller/{id}",[\App\Http\Controllers\Admin\SellerPaymentMethodController::class,"Delete"]);




        //Courier Charge
        Route::post("/seller/courier/charge/add",[\App\Http\Controllers\Admin\SellerCourierController::class,"Store"]);
        Route::get("/seller/courier/charge/{id}",[\App\Http\Controllers\Admin\SellerCourierController::class,"Index"]);
        Route::put("/seller/courier/charge/{id}",[\App\Http\Controllers\Admin\SellerCourierController::class,"Update"]);
        Route::delete("/seller/courier/charge/{id}",[\App\Http\Controllers\Admin\SellerCourierController::class,"Delete"]);


        //Delivery Times
        Route::post("/seller/delivery/times",[\App\Http\Controllers\Admin\SellerDeliveryTimesController::class,"Store"]);
        Route::get("/seller/delivery/times",[\App\Http\Controllers\Admin\SellerDeliveryTimesController::class,"Index"]);
        Route::put("/seller/delivery/times/{id}",[\App\Http\Controllers\Admin\SellerDeliveryTimesController::class,"Update"]);
        Route::delete("/seller/delivery/times/{id}",[\App\Http\Controllers\Admin\SellerDeliveryTimesController::class,"Delete"]);


        //Seller Own Payment Details
        Route::post("/seller/payment/details",[\App\Http\Controllers\Admin\SellerPaymentDetailsController::class,"Store"]);
        Route::get("/seller/payment/details/{id}",[\App\Http\Controllers\Admin\SellerPaymentDetailsController::class,"Index"]);
        Route::put("/seller/payment/details/{id}",[\App\Http\Controllers\Admin\SellerPaymentDetailsController::class,"Update"]);
        Route::delete("/seller/payment/details/{id}",[\App\Http\Controllers\Admin\SellerPaymentDetailsController::class,"Delete"]);




        //Seller Exter Charge Type
        Route::post("/seller/exter/charges/type",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"Store"]);
        Route::put("/seller/exter/charges/type/{id}",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"Update"]);
        Route::get("/seller/exter/charges/type",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"Index"]);
        Route::delete("/seller/exter/charges/type/{id}",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"Delete"]);


//Url
        Route::post("/seller/exter/charges/{id}",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"StoreExterCharge"]);
        Route::put("/seller/exter/charges/{id}",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"UpdateExterCharge"]);
        Route::get("/seller/exter/charges/{id}",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"FetchExterCharge"]);
        Route::delete("/seller/exter/charges/{id}",[\App\Http\Controllers\Admin\SellerExterChargeController::class,"DeleterExterCharge"]);



        //Live List
        Route::get("/lives",[\App\Http\Controllers\Admin\SellerLivesController::class,"Index"]);
        Route::get("/lives/seller/{id}",[\App\Http\Controllers\Admin\SellerLivesController::class,"SellerTotalLives"]);


        //Refer Policy
        Route::get("/refer-policy",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Index"]);
        Route::post("/refer-policy",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Store"]);
        Route::put("/refer-policy/{id}",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Update"]);
        Route::delete("/refer-policy/{id}",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Delete"]);


        //Recharge Request
        Route::get("/recharge-request",[\App\Http\Controllers\Admin\RechargeRequestController::class,"Index"]);
        Route::get("/recharge-request/approve/{id}",[\App\Http\Controllers\Admin\RechargeRequestController::class,"Approve"]);

        //Address Own Tunibibi
        Route::get("/settings/address",[\App\Http\Controllers\Admin\SettingsController::class,"Index"]);
        Route::post("/settings/address",[\App\Http\Controllers\Admin\SettingsController::class,"Store"]);
        Route::put("/settings/address/{id}",[\App\Http\Controllers\Admin\SettingsController::class,"Update"]);
        Route::delete("/settings/address/{id}",[\App\Http\Controllers\Admin\SettingsController::class,"Delete"]);



        //Shipping Package
        Route::get("/shippingPackage",[\App\Http\Controllers\Admin\ShippingPackageController::class,"Index"]);
        Route::post("/shippingPackage",[\App\Http\Controllers\Admin\ShippingPackageController::class,"Store"]);
        Route::put("/shippingPackage/{id}",[\App\Http\Controllers\Admin\ShippingPackageController::class,"Update"]);
        Route::delete("/shippingPackage/{id}",[\App\Http\Controllers\Admin\ShippingPackageController::class,"Delete"]);


        //Shipping Package
        Route::get("/Buyer",[\App\Http\Controllers\Admin\BuyerController::class,"Index"]);
        Route::post("/Buyer",[\App\Http\Controllers\Admin\BuyerController::class,"Store"]);
        Route::put("/Buyer/{id}",[\App\Http\Controllers\Admin\BuyerController::class,"Update"]);
        Route::delete("/Buyer/{id}",[\App\Http\Controllers\Admin\BuyerController::class,"Delete"]);



        //Buyer Feature

        Route::get("/featured_shop",[\App\Http\Controllers\Admin\FeaturedShopController::class,"Index"]);
        Route::post("/featured_shop",[\App\Http\Controllers\Admin\FeaturedShopController::class,"Store"]);
        Route::put("/featured_shop/{id}",[\App\Http\Controllers\Admin\FeaturedShopController::class,"Update"]);
        Route::delete("/featured_shop/{id}",[\App\Http\Controllers\Admin\FeaturedShopController::class,"Delete"]);




        //RMS Section
        Route::get("/rms/menus",[\App\Http\Controllers\Admin\RMS\RMSMenuController::class,"index"]);
        Route::post("/rms/menus",[\App\Http\Controllers\Admin\RMS\RMSMenuController::class,"store"]);
        Route::put("/rms/menus/{id}",[\App\Http\Controllers\Admin\RMS\RMSMenuController::class,"update"]);
        Route::delete("/rms/menus/{id}",[\App\Http\Controllers\Admin\RMS\RMSMenuController::class,"delete"]);


        Route::get("/rms/groups",[\App\Http\Controllers\Admin\RMS\RMSGroupsController::class,"index"]);
        Route::post("/rms/groups",[\App\Http\Controllers\Admin\RMS\RMSGroupsController::class,"store"]);
        Route::put("/rms/groups/{id}",[\App\Http\Controllers\Admin\RMS\RMSGroupsController::class,"update"]);
        Route::delete("/rms/groups/{id}",[\App\Http\Controllers\Admin\RMS\RMSGroupsController::class,"delete"]);


        Route::get("/rms/groups-menu",[\App\Http\Controllers\Admin\RMS\RMSGroupMenusController::class,"index"]);
        Route::post("/rms/groups-menu",[\App\Http\Controllers\Admin\RMS\RMSGroupMenusController::class,"store"]);
        Route::put("/rms/groups-menu/{id}",[\App\Http\Controllers\Admin\RMS\RMSGroupMenusController::class,"update"]);
        Route::delete("/rms/groups-menu/{id}",[\App\Http\Controllers\Admin\RMS\RMSGroupMenusController::class,"delete"]);



        Route::get("/rms/users",[\App\Http\Controllers\Admin\AdminController::class,"users"]);


        Route::get("/rms/permission",[\App\Http\Controllers\Admin\RMS\RMSPermissionController::class,"index"]);
        Route::post("/rms/permission",[\App\Http\Controllers\Admin\RMS\RMSPermissionController::class,"store"]);
        Route::put("/rms/permission/{id}",[\App\Http\Controllers\Admin\RMS\RMSPermissionController::class,"update"]);
        Route::delete("/rms/permission/{id}",[\App\Http\Controllers\Admin\RMS\RMSPermissionController::class,"delete"]);
        Route::post("/rms/permission/check",[\App\Http\Controllers\Admin\RMS\RMSPermissionController::class,"checkPermission"]);
        Route::get("/rms/my-permissions",[\App\Http\Controllers\Admin\RMS\RMSPermissionController::class,"myPermission"]);








        Route::post("/wirehouse/add",[\App\Http\Controllers\WirehouseController::class,"store"]);
        Route::get("/wirehouse",[\App\Http\Controllers\WirehouseController::class,"index"]);
        Route::put("/wirehouse/{id}",[\App\Http\Controllers\WirehouseController::class,"update"]);
        Route::put("/wirehouse/password/{id}",[\App\Http\Controllers\WirehouseController::class,"passupdate"]);
        Route::delete("/wirehouse/{id}",[\App\Http\Controllers\WirehouseController::class,"delete"]);



        //

        Route::get("country",[\App\Http\Controllers\Admin\SellerController::class,"Country"]);
        Route::post("country/add",[\App\Http\Controllers\Admin\CountryController::class,"store"]);
        Route::put("country/{id}",[\App\Http\Controllers\Admin\CountryController::class,"update"]);
        Route::delete("country/{id}",[\App\Http\Controllers\Admin\CountryController::class,"delete"]);
        Route::put("country/dollar_rate/{id}",[\App\Http\Controllers\Admin\CountryController::class,"dollarrate"]);


//        storage/payment/method/



//        storage/payment/method/

        Route::get("buyer/payment_methods",[\App\Http\Controllers\BuyerPaymentMethodController::class,"all"]);
        Route::post("buyer/payment_methods",[\App\Http\Controllers\BuyerPaymentMethodController::class,"store"]);
        Route::put("buyer/payment_methods/{id}",[\App\Http\Controllers\BuyerPaymentMethodController::class,"update"]);
        Route::delete("buyer/payment_methods/{id}",[\App\Http\Controllers\BuyerPaymentMethodController::class,"delete"]);



        Route::get("buyer/banner",[\App\Http\Controllers\BannerController::class,"getbuyerbanner"]);
        Route::post("buyer/banner",[\App\Http\Controllers\BannerController::class,"store"]);
        Route::put("buyer/banner/{id}",[\App\Http\Controllers\BannerController::class,"update"]);
        Route::delete("buyer/banner/{id}",[\App\Http\Controllers\BannerController::class,"delete"]);



        Route::get("buyer/vouchers",[\App\Http\Controllers\VoucherController::class,"all"]);
        Route::post("buyer/vouchers",[\App\Http\Controllers\VoucherController::class,"store"]);
        Route::put("buyer/vouchers/{id}",[\App\Http\Controllers\VoucherController::class,"update"]);
        Route::delete("buyer/vouchers/{id}",[\App\Http\Controllers\VoucherController::class,"delete"]);



        //Refer Policy
        Route::get("buyer/refer-policy",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Index"]);
        Route::post("buyer/refer-policy",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Store"]);
        Route::put("buyer/refer-policy/{id}",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Update"]);
        Route::delete("buyer/refer-policy/{id}",[\App\Http\Controllers\Admin\ReferEarningPolicyController::class,"Delete"]);



        Route::get("/search-history",[\App\Http\Controllers\SearchHistoryController::class,"index"]);




        Route::get("/orders/pending",[\App\Http\Controllers\Admin\OrderController::class,"PendingOrders"]);
        Route::post("/orders/confirm_payment/{id}",[\App\Http\Controllers\Admin\OrderController::class,"VerifyOrderPayment"]);

        Route::get("/orders/delivery/pending",[\App\Http\Controllers\Admin\OrderController::class,"DeliveryPendingOrders"]);
        Route::post("/orders/delivery/confirm_payment/{id}",[\App\Http\Controllers\Admin\OrderController::class,"DeliveryVerifyOrderPayment"]);

        Route::post("/orders/all",[\App\Http\Controllers\Admin\OrderController::class,"AllOrders"]);

        Route::get("/orders_details/{id}",[\App\Http\Controllers\Admin\OrderController::class,"ShowDetails"]);


        Route::get("orders/track/{id}",[OrderController::class,"TrackOrder"]);
        Route::post("orders/track/{id}",[OrderController::class,"AddTrackOrder"]);
        Route::put("orders/track",[OrderController::class,"Update"]);
        Route::delete("orders/track/{id}",[OrderController::class,"Delete"]);



//        Route::get("/orders-all/admin_filter/{status}",[\App\Http\Controllers\Admin\OrderController::class,"adminOrderStatus"]);
//        Route::get("/orders-all/payment_filter/{status}",[\App\Http\Controllers\Admin\OrderController::class,"paymentOrderStatus"]);
//        Route::get("/orders/seller/{id}",[\App\Http\Controllers\Admin\OrderController::class,"sellerOrders"]);






    });

});


Route::prefix("wirehouse")->group(function (){
    Route::post("login",[\App\Http\Controllers\WirehouseController::class,"Login"]);

    Route::middleware("auth:sanctum")->group(function (){
        Route::post("check_in/check",[\App\Http\Controllers\WirehouseController::class,"check_in"]);
        Route::put("check_in/{id}",[\App\Http\Controllers\WirehouseController::class,"check_in_product"]);
        Route::get("wirehouses",[\App\Http\Controllers\WirehouseController::class,"index"]);
        Route::put("check_in/send_shipment/{id}",[\App\Http\Controllers\WirehouseController::class,"SendProductWordWide"]);



        Route::get("receive_order/{id}",[\App\Http\Controllers\WirehouseController::class,"ReceiveOrder"]);
        Route::put("receive_order/confirm/{id}",[\App\Http\Controllers\WirehouseController::class,"ReceiveOrderProductConfirm"]);
        Route::get("receive_order/courier_hand_over/list",[\App\Http\Controllers\WirehouseController::class,"ReadyToCourier"]);
        Route::post("receive_order/courier_hand_over/list/{id}",[\App\Http\Controllers\WirehouseController::class,"SendedCourier"]);
        Route::post("receive_order/delivery_confirm/list/{id}",[\App\Http\Controllers\WirehouseController::class,"DeliveryConfirm"]);

    });


});
